<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;

use App\Models\Cart;
use App\Models\Brand;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;

class FrontendController extends Controller
{

    public function index(Request $request)
    {
        return redirect()->route($request->user()->role);
    }

    public function home()
    {
        $featured = Product::where('status', 'active')->where('is_featured', 1)->orderBy('price', 'DESC')->limit(2)->get();
        $posts = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(6)->get();
        $banners = Banner::where('status', 'active')->limit(3)->orderBy('id', 'DESC')->get();
        $products = Product::where('status', 'active')->orderBy('id', 'DESC')->where('is_featured', 1)->get();
        $category = Category::where('status', 'active')->where('is_parent', 1)->orderBy('title', 'ASC')->get();

        return view('frontend.index')
            ->with('featured', $featured)
            ->with('banners', $banners)
            ->with('posts', $posts)
            ->with('product_lists', $products)
            ->with('category_lists', $category);
    }


    public function aboutUs()
    {
        return view('frontend.pages.about-us');
    }

    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function productDetail($slug)
    {
        $product_detail = Product::getProductBySlug($slug);

        if (!$product_detail) {
            abort(404);
        }

        // Lấy danh mục của sản phẩm hiện tại
        $category_id = $product_detail->cat_id;

        // Lấy sản phẩm liên quan (cùng danh mục, không lấy sản phẩm hiện tại, giới hạn 12)
        $related_products = Product::where('cat_id', $category_id)
            ->where('id', '!=', $product_detail->id)
            ->where('status', 'active')
            ->latest()
            ->limit(12)
            ->get();

        return view('frontend.pages.product_detail', compact('product_detail', 'related_products'));
    }


    public function productGrids()
    {
        $products = Product::query();

        if (!empty($_GET['category'])) {
            $slug = explode(',', $_GET['category']);
            // dd($slug);
            $cat_ids = Category::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            // dd($cat_ids);
            $products->whereIn('cat_id', $cat_ids);
            // return $products;
        }
        if (!empty($_GET['brand'])) {
            $slugs = explode(',', $_GET['brand']);
            $brand_ids = Brand::select('id')->whereIn('slug', $slugs)->pluck('id')->toArray();
            return $brand_ids;
            $products->whereIn('brand_id', $brand_ids);
        }
        if (!empty($_GET['sortBy'])) {
            if ($_GET['sortBy'] == 'title') {
                $products = $products->where('status', 'active')->orderBy('title', 'ASC');
            }
            if ($_GET['sortBy'] == 'price') {
                $products = $products->orderBy('price', 'ASC');
            }
        }

        if (!empty($_GET['price'])) {
            $price = explode('-', $_GET['price']);
            $products->whereBetween('price', $price);
        }

        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        // Sort by number
        if (!empty($_GET['show'])) {
            $products = $products->where('status', 'active')->paginate($_GET['show']);
        } else {
            $products = $products->where('status', 'active')->paginate(9);
        }
        // Sort by name , price, category


        return view('frontend.pages.product-grids')->with('products', $products)->with('recent_products', $recent_products);
    }
    public function productLists()
    {
        $products = Product::query();

        if (!empty($_GET['category'])) {
            $slug = explode(',', $_GET['category']);
            // dd($slug);
            $cat_ids = Category::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            // dd($cat_ids);
            $products->whereIn('cat_id', $cat_ids);
            // return $products;
        }
        if (!empty($_GET['brand'])) {
            $slugs = explode(',', $_GET['brand']);
            $brand_ids = Brand::select('id')->whereIn('slug', $slugs)->pluck('id')->toArray();
            return $brand_ids;
            $products->whereIn('brand_id', $brand_ids);
        }
        if (!empty($_GET['sortBy'])) {
            if ($_GET['sortBy'] == 'title') {
                $products = $products->where('status', 'active')->orderBy('title', 'ASC');
            }
            if ($_GET['sortBy'] == 'price') {
                $products = $products->orderBy('price', 'ASC');
            }
        }

        if (!empty($_GET['price'])) {
            $price = explode('-', $_GET['price']);
            $products->whereBetween('price', $price);
        }

        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        // Sort by number
        if (!empty($_GET['show'])) {
            $products = $products->where('status', 'active')->paginate($_GET['show']);
        } else {
            $products = $products->where('status', 'active')->paginate(9);
        }
        // Sort by name , price, category


        return view('frontend.pages.product-lists')->with('products', $products)->with('recent_products', $recent_products);
    }

    public function productFilter(Request $request)
    {
        $data = $request->all();

        // Bắt đầu truy vấn sản phẩm
        $products = Product::query();

        // Xử lý các checkbox trong price_range
        if (!empty($data['price_range'])) {
            $products->where(function ($query) use ($data) {
                foreach ($data['price_range'] as $range) {
                    list($min, $max) = explode('-', $range);
                    $query->orWhereBetween('price', [(int)$min, (int)$max]);
                }
            });
        }

        // Thêm các bộ lọc khác nếu cần
        if (!empty($data['category'])) {
            $products->whereIn('category_id', $data['category']);
        }

        if (!empty($data['brand'])) {
            $products->whereIn('brand_id', $data['brand']);
        }

        // Lấy sản phẩm đã lọc
        $products = $products->paginate(12)->appends($data); // Giữ lại các tham số trong URL

        // Kiểm tra trang hiện tại
        $currentPage = $request->input('page') ? $request->input('page') : 1;
        $view = $request->input('view') == 'list' ? 'frontend.pages.product-lists' : 'frontend.pages.product-grids';

        return view($view, compact('products', 'currentPage'));
    }




    public function productSearch(Request $request)
    {
        $search = $request->query('search'); // Lấy từ khoá tìm kiếm từ URL

        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        $products = Product::where(function ($query) use ($search) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('slug', 'like', '%' . $search . '%')
                ->orWhere('price', 'like', '%' . $search . '%');
        })
            ->orderBy('id', 'DESC')
            ->paginate(24)
            ->appends(['search' => $search]); // Giữ lại từ khoá tìm kiếm khi phân trang

        return view('frontend.pages.product-grids', compact('products', 'recent_products'));
    }


    public function productBrand(Request $request)
    {
        // Lấy thương hiệu dựa trên slug
        $brand = Brand::where('slug', $request->slug)->first();

        // Kiểm tra nếu không tìm thấy thương hiệu
        if (!$brand) {
            return redirect()->back()->with('error', 'Thương hiệu không tồn tại.');
        }

        // Lấy sản phẩm của thương hiệu
        $products = $brand->products()->where('status', 'active'); // Lấy sản phẩm hoạt động của thương hiệu

        // Lấy số lượng sản phẩm mỗi trang từ request hoặc mặc định là 12
        $perPage = 12;

        // Phân trang sản phẩm và giữ lại các tham số trong URL
        $paginatedProducts = $products->paginate($perPage)->appends($request->except('page')); // Giữ lại các tham số trong URL ngoại trừ 'page'

        // Kiểm tra loại hiển thị (list hoặc grid)
        $view = $request->input('view') === 'grid' ? 'frontend.pages.product-grids' : 'frontend.pages.product-lists';

        // Trả về view với dữ liệu
        return view($view, compact('paginatedProducts'));
    }




    public function productCat(Request $request)
    {
        $products = Category::getProductByCat($request->slug)->products()->paginate(12);
        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();


        return view('frontend.pages.product-grids')
            ->with('products', $products)
            ->with('recent_products', $recent_products);
    }

    public function productSubCat(Request $request)
    {
        $products = Category::getProductBySubCat($request->sub_slug)->sub_products()->paginate(12);
        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();

        // Kiểm tra xem trang hiện tại là 'product-grids' hay 'product-lists' và trả về view tương ứng

        return view('frontend.pages.product-grids')
            ->with('products', $products)
            ->with('recent_products', $recent_products);
    }



    public function blog()
    {
        $post = Post::query();

        if (!empty($_GET['category'])) {
            $slug = explode(',', $_GET['category']);
            // dd($slug);
            $cat_ids = PostCategory::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            return $cat_ids;
            $post->whereIn('post_cat_id', $cat_ids);
            // return $post;
        }
        if (!empty($_GET['tag'])) {
            $slug = explode(',', $_GET['tag']);
            // dd($slug);
            $tag_ids = PostTag::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            // return $tag_ids;
            $post->where('post_tag_id', $tag_ids);
            // return $post;
        }

        if (!empty($_GET['show'])) {
            $post = $post->where('status', 'active')->orderBy('id', 'DESC')->paginate($_GET['show']);
        } else {
            $post = $post->where('status', 'active')->orderBy('id', 'DESC')->paginate(9);
        }
        // $post=Post::where('status','active')->paginate(8);
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        return view('frontend.pages.blog')->with('posts', $post)->with('recent_posts', $rcnt_post);
    }


    public function blogDetail($slug)
    {
        $post = Post::getPostBySlug($slug);
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        // return $post;
        return view('frontend.pages.blog-detail')->with('post', $post)->with('recent_posts', $rcnt_post);
    }

    public function blogSearch(Request $request)
    {
        // return $request->all();
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        $posts = Post::orwhere('title', 'like', '%' . $request->search . '%')
            ->orwhere('quote', 'like', '%' . $request->search . '%')
            ->orwhere('summary', 'like', '%' . $request->search . '%')
            ->orwhere('description', 'like', '%' . $request->search . '%')
            ->orwhere('slug', 'like', '%' . $request->search . '%')
            ->orderBy('id', 'DESC')
            ->paginate(8);
        return view('frontend.pages.blog')->with('posts', $posts)->with('recent_posts', $rcnt_post);
    }

    public function blogFilter(Request $request)
    {
        $data = $request->all();
        // return $data;
        $catURL = "";
        if (!empty($data['category'])) {
            foreach ($data['category'] as $category) {
                if (empty($catURL)) {
                    $catURL .= '&category=' . $category;
                } else {
                    $catURL .= ',' . $category;
                }
            }
        }

        $tagURL = "";
        if (!empty($data['tag'])) {
            foreach ($data['tag'] as $tag) {
                if (empty($tagURL)) {
                    $tagURL .= '&tag=' . $tag;
                } else {
                    $tagURL .= ',' . $tag;
                }
            }
        }
        // return $tagURL;
        // return $catURL;
        return redirect()->route('blog', $catURL . $tagURL);
    }

    public function blogByCategory(Request $request)
    {
        $post = PostCategory::getBlogByCategory($request->slug);
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        return view('frontend.pages.blog')->with('posts', $post->post)->with('recent_posts', $rcnt_post);
    }

    public function blogByTag($slug)
    {
        // Lấy danh sách bài viết có chứa tag tương ứng
        $posts = Post::getBlogByTag($slug);

        // Lấy 3 bài viết mới nhất
        $recent_posts = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();

        return view('frontend.pages.blog', compact('posts', 'recent_posts'));
    }



    // Login
    public function login()
    {
        return view('frontend.pages.login');
    }
    public function loginSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Sai tên đăng nhập hoặc mật khẩu.']);
        }

        // if (!$user->hasVerifiedEmail()) {
        //     return back()->withErrors(['email' => 'Vui lòng xác minh email trước khi đăng nhập.']);
        // }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 'active'])) {
            session(['user' => Auth::user()]);
            request()->session()->flash('success', 'Đăng nhập thành công');
            return redirect()->route('home');
        }

        return back()->withErrors(['email' => 'Sai tên đăng nhập hoặc mật khẩu.']);
    }



    public function logout()
    {
        Session::forget('user');
        Auth::logout();
        request()->session()->flash('success', 'Đăng xuất thành công');
        return back();
    }

    public function register()
    {
        return view('frontend.pages.register');
    }
    public function registerSubmit(Request $request)
    {
        $this->validate($request, [
            'name' => 'string|required|min:2',
            'email' => 'string|required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Gửi email xác thực
        $user->sendEmailVerificationNotification();

        // Lưu email vào session để hiển thị thông báo
        Session::put('email_verification', $request->email);

        return redirect()->route('verification.notice');
    }
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => 'active'
        ]);
    }
    // Reset password
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    // Xử lý yêu cầu gửi link đặt lại mật khẩu
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    // Hiển thị form nhập mật khẩu mới
    public function showResetForm($token = null)
    {
        return view('auth.passwords.reset')->with([
            'token' => $token,
            'email' => request('email')
        ]);
    }

    // Xử lý yêu cầu cập nhật mật khẩu mới
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login.form')->with('success', __('Mật khẩu của bạn đã được đặt lại thành công. Vui lòng đăng nhập!'));
        } else {
            return back()->withErrors(['email' => [__($status)]]);
        }
    }

    public function subscribe(Request $request)
    {
        // Kiểm tra nếu email được nhập vào và hợp lệ
        $request->validate([
            'email' => 'required|email'
        ]);

        // Giả sử bạn đang có bảng users hoặc một bảng khác chứa email
        $emailExists = DB::table('users') // Hoặc bảng lưu trữ email của bạn
            ->where('email', $request->email)
            ->exists();

        if ($emailExists) {
            // Hiển thị thông báo nếu email đã đăng ký
            $request->session()->flash('error', 'Bạn đã đăng ký rồi !!!');
            return back();
        } else {
            // Hiển thị thông báo thành công nếu email chưa đăng ký
            $request->session()->flash('success', 'Đã đăng ký! Vui lòng kiểm tra Email của bạn để nhận mã giảm giá.');
            return redirect()->route('home');
        }
    }
}
