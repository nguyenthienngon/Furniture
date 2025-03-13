<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\Cart;
use Illuminate\Support\Str;
use Helper;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    protected $product = null;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function addToCart(Request $request)
    {
        // Kiểm tra slug của sản phẩm
        if (empty($request->slug)) {
            request()->session()->flash('error', 'Sản phẩm không hợp lệ');
            return back();
        }

        // Lấy thông tin sản phẩm dựa trên slug
        $product = Product::where('slug', $request->slug)->first();
        if (empty($product)) {
            request()->session()->flash('error', 'Sản phẩm không hợp lệ');
            return back();
        }

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        $already_cart = Cart::where('user_id', auth()->user()->id)
            ->where('order_id', null)
            ->where('product_id', $product->id)
            ->first();

        if ($already_cart) {
            // Nếu đã có, tăng số lượng và tính lại tổng giá trị
            $already_cart->quantity += 1;
            $already_cart->amount += $product->price;

            // Kiểm tra tồn kho
            if ($already_cart->product->stock < $already_cart->quantity || $already_cart->product->stock <= 0) {
                return back()->with('error', 'Không đủ hàng trong kho!');
            }

            $already_cart->save();
        } else {
            // Nếu chưa có, thêm sản phẩm mới vào giỏ hàng
            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $product->id;
            $cart->price = $product->price - ($product->price * $product->discount / 100);
            $cart->quantity = 1;
            $cart->amount = $cart->price;

            // Kiểm tra tồn kho
            if ($cart->product->stock < $cart->quantity || $cart->product->stock <= 0) {
                return back()->with('error', 'Không đủ hàng trong kho!');
            }

            $cart->save();

            // Cập nhật wishlist
            Wishlist::where('user_id', auth()->user()->id)
                ->where('cart_id', null)
                ->update(['cart_id' => $cart->id]);
        }

        // Thông báo thành công
        request()->session()->flash('success', 'Sản phẩm đã được thêm vào giỏ hàng');
        return back();
    }


    public function singleAddToCart(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'slug' => 'required',
            'quant' => 'required',
        ]);

        // Lấy thông tin sản phẩm dựa trên slug
        $product = Product::where('slug', $request->slug)->first();

        // Kiểm tra số lượng nhập vào và tồn kho
        if ($product->stock < $request->quant[1]) {
            return back()->with('error', 'Vui lòng nhập lại số lượng sản phẩm!');
        }
        if ($request->quant[1] < 1 || empty($product)) {
            request()->session()->flash('error', 'Sản phẩm không hợp lệ');
            return back();
        }

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        $already_cart = Cart::where('user_id', auth()->user()->id)
            ->where('order_id', null)
            ->where('product_id', $product->id)
            ->first();

        if ($already_cart) {
            // Nếu đã có, tăng số lượng và cập nhật tổng giá trị
            $already_cart->quantity += $request->quant[1];
            $already_cart->amount += $product->price * $request->quant[1];

            // Kiểm tra tồn kho
            if ($already_cart->product->stock < $already_cart->quantity || $already_cart->product->stock <= 0) {
                return back()->with('error', 'Không đủ hàng trong kho!');
            }

            $already_cart->save();
        } else {
            // Nếu chưa có, thêm sản phẩm mới vào giỏ hàng
            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $product->id;
            $cart->price = $product->price - ($product->price * $product->discount / 100);
            $cart->quantity = $request->quant[1];
            $cart->amount = $product->price * $request->quant[1];

            // Kiểm tra tồn kho
            if ($cart->product->stock < $cart->quantity || $cart->product->stock <= 0) {
                return back()->with('error', 'Không đủ hàng trong kho!');
            }

            $cart->save();
        }

        // Thông báo thành công
        request()->session()->flash('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
        return back();
    }



    public function cartDelete($id)
    {
        $cart = Cart::find($id);

        if ($cart) {
            $cart->delete();
            return response()->json(['success' => true, 'message' => 'Xóa sản phẩm trong giỏ hàng thành công']);
        }
        return response()->json(['success' => false, 'message' => 'Có lỗi, vui lòng thử lại']);
    }



    public function cartUpdate(Request $request)
    {
        // dd($request->all());
        if ($request->quant) {
            $error = array();
            $success = '';
            // return $request->quant;
            foreach ($request->quant as $k => $quant) {
                // return $k;
                $id = $request->qty_id[$k];
                // return $id;
                $cart = Cart::find($id);
                // return $cart;
                if ($quant > 0 && $cart) {
                    // return $quant;

                    if ($cart->product->stock < $quant) {
                        request()->session()->flash('error', 'Hết hàng');
                        return back();
                    }
                    $cart->quantity = ($cart->product->stock > $quant) ? $quant  : $cart->product->stock;
                    // return $cart;

                    if ($cart->product->stock <= 0) continue;
                    $after_price = ($cart->product->price - ($cart->product->price * $cart->product->discount) / 100);
                    $cart->amount = $after_price * $quant;
                    // return $cart->price;
                    $cart->save();
                    $success = 'Cập nhật giỏ hàng thành công!';
                } else {
                    $error[] = 'Giỏ hàng không hợp lệ!';
                }
            }
            return back()->with($error)->with('success', $success);
        } else {
            return back()->with('Giỏ hàng không hợp lệ!');
        }
    }

    public function checkout()
    {
        // Lấy danh sách tỉnh/thành phố từ database
        $provinces = DB::table('provinces')->get();

        // Lấy danh sách quận/huyện
        $districts = DB::table('districts')->get();

        // Lấy danh sách xã/phường
        $wards = DB::table('wards')->get();
     
        // Tính tổng tiền đơn hàng
        $totalAmount = Helper::totalCartPrice();
        $discount = session()->get('coupon.value', 0);
        $grandTotal = $totalAmount - $discount;
      
        // Truyền dữ liệu vào view
        return view('frontend.pages.checkout', compact('totalAmount', 'discount', 'grandTotal', 'provinces', 'districts', 'wards'));
    }
}
