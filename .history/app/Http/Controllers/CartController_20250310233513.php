<?php

namespace App\Http\Controllers;

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
        if (empty($request->slug)) {
            return response()->json(['success' => false, 'message' => 'Sản phẩm không hợp lệ']);
        }

        $product = Product::where('slug', $request->slug)->first();
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại']);
        }

        $user_id = auth()->user()->id;

        $already_cart = Cart::where('user_id', $user_id)
            ->where('order_id', null)
            ->where('product_id', $product->id)
            ->first();

        if ($already_cart) {
            $already_cart->quantity += 1;
            $already_cart->amount += $product->price;

            if ($already_cart->product->stock < $already_cart->quantity) {
                return response()->json(['success' => false, 'message' => 'Không đủ hàng trong kho!']);
            }

            $already_cart->save();
        } else {
            $cart = new Cart;
            $cart->user_id = $user_id;
            $cart->product_id = $product->id;
            $cart->price = $product->price - ($product->price * $product->discount / 100);
            $cart->quantity = 1;
            $cart->amount = $cart->price;

            if ($cart->product->stock < $cart->quantity) {
                return response()->json(['success' => false, 'message' => 'Không đủ hàng trong kho!']);
            }

            $cart->save();

            Wishlist::where('user_id', $user_id)
                ->where('cart_id', null)
                ->update(['cart_id' => $cart->id]);
        }

        // Trả về JSON response
        return response()->json([
            'success' => true,
            'message' => 'Sản phẩm đã được thêm vào giỏ hàng!',
            'cart_count' => Cart::where('user_id', $user_id)->count()
        ]);
    }



    public function singleAddToCart(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $request->validate([
            'slug' => 'required',
            'quant' => 'required|integer|min:1',
        ]);

        // Lấy thông tin sản phẩm dựa trên slug
        $product = Product::where('slug', $request->slug)->first();

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Sản phẩm không hợp lệ.'], 400);
        }

        // Kiểm tra tồn kho
        if ($product->stock < $request->quant) {
            return response()->json(['success' => false, 'message' => 'Không đủ hàng trong kho!'], 400);
        }

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        $already_cart = Cart::where('user_id', auth()->id())
            ->where('order_id', null)
            ->where('product_id', $product->id)
            ->first();

        if ($already_cart) {
            // Nếu đã có, tăng số lượng và cập nhật tổng giá trị
            $already_cart->quantity += $request->quant;
            $already_cart->amount += $product->price * $request->quant;

            // Kiểm tra tồn kho
            if ($already_cart->product->stock < $already_cart->quantity) {
                return response()->json(['success' => false, 'message' => 'Không đủ hàng trong kho!'], 400);
            }

            $already_cart->save();
        } else {
            // Nếu chưa có, thêm sản phẩm mới vào giỏ hàng
            $cart = new Cart;
            $cart->user_id = auth()->id();
            $cart->product_id = $product->id;
            $cart->price = $product->price - ($product->price * $product->discount / 100);
            $cart->quantity = $request->quant;
            $cart->amount = $product->price * $request->quant;

            // Kiểm tra tồn kho
            if ($cart->product->stock < $cart->quantity) {
                return response()->json(['success' => false, 'message' => 'Không đủ hàng trong kho!'], 400);
            }

            $cart->save();
        }

        // Đếm số lượng sản phẩm trong giỏ hàng
        $cart_count = Cart::where('user_id', auth()->id())->count();

        return response()->json(['success' => true, 'message' => 'Sản phẩm đã được thêm vào giỏ hàng.', 'cart_count' => $cart_count]);
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


    public function checkout(Request $request)
    {

        // Tiếp tục xử lý checkout nếu số lượng hợp lệ
        $totalAmount = Helper::totalCartPrice();
        $discount = session()->get('coupon.value', 0);
        $grandTotal = $totalAmount - $discount;

        return view('frontend.pages.checkout', compact('totalAmount', 'discount', 'grandTotal'));
    }
}
