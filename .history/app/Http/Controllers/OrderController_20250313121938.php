<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Shipping;
use App\Models\Banner;
use App\Models\Post;
use App\Models\Category;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Helper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;
use App\Notifications\StatusNotification;
use App\Models\Product;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Http;
use App\Mail\OrderInvoiceMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage; // ✅ Đúng namespace



use SimpleSoftwareIO\QrCode\Facades\QrCode;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::orderBy('id', 'DESC')->paginate(10);
        return view('backend.order.index')->with('orders', $orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


public function store(Request $request)
{
    $this->validate($request, [
        'first_name' => 'string|required',
        'last_name' => 'string|required',
        'address1' => 'string|required',
        'coupon' => 'nullable|numeric',
        'phone' => 'numeric|required',
        'email' => 'string|required',
        'shipping' => 'required|exists:shippings,id',
        'payment_method' => 'string|required'
    ]);

    $cart = Cart::where('user_id', auth()->id())->whereNull('order_id')->get();
    if ($cart->isEmpty()) {
        return back()->with('error', 'Giỏ hàng trống.');
    }

    $sub_total = 0;
    foreach ($cart as $cart_item) {
        $product = Product::find($cart_item->product_id);
        if (!$product) {
            return back()->with('error', 'Sản phẩm ID ' . $cart_item->product_id . ' không tồn tại.');
        }
        $sub_total += $cart_item->amount;
    }

    $shipping = Shipping::find($request->shipping);
    if (!$shipping) {
        return back()->with('error', 'Phương thức giao hàng không hợp lệ.');
    }

    try {
        DB::beginTransaction();

        $order = new Order();
        $order_data = $request->only(['first_name', 'last_name', 'address1', 'address2', 'phone', 'email']);
        $order_data['order_number'] = 'ORD-' . strtoupper(Str::random(10));
        $order_data['user_id'] = auth()->id();
        $order_data['shipping_id'] = $shipping->id;
        $order_data['country'] = $request->input('country', 'Vietnam');
        $order_data['sub_total'] = $sub_total;
        $order_data['quantity'] = $cart->sum('quantity');
        $order_data['coupon'] = session()->get('coupon.value', 0);
        $order_data['total_amount'] = $sub_total + $shipping->price - $order_data['coupon'];
        $order_data['status'] = 'new';
        $order_data['payment_status'] = 'Unpaid';
        $order_data['payment_method'] = $request->payment_method;

        $order->fill($order_data);
        $order->save();

        foreach ($cart as $cart_item) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $cart_item->product_id,
                'quantity' => $cart_item->quantity
            ]);

            Product::where('id', $cart_item->product_id)->decrement('stock', $cart_item->quantity);
        }

        Cart::where('user_id', auth()->id())->whereNull('order_id')->update(['order_id' => $order->id]);
        session()->forget('cart');

        DB::commit();

        // **Gửi email bằng job để không làm chậm quá trình đặt hàng**
dispatch(new SendOrderInvoice($order)); // Gọi job

        // **Xử lý thanh toán MOMO**
        if ($request->payment_method === 'momo') {
            return $this->momoPayment($order);
        }

        return redirect()->route('home')->with('success', 'Bạn đã đặt hàng thành công. Hóa đơn sẽ được gửi vào email.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Đã có lỗi xảy ra: ' . $e->getMessage());
    }
}




    public function momoPayment($order)
    {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = env('MOMO_PARTNER_CODE');
        $accessKey = env('MOMO_ACCESS_KEY');
        $secretKey = env('MOMO_SECRET_KEY');

        $requestId = time();
        $orderId = $order->order_number;
        $amount = (int) $order->total_amount;
        $orderInfo = "Thanh toán đơn hàng #{$order->id}";
        $redirectUrl = route('payment.success');
        $ipnUrl = route('payment.notify');

        // Sử dụng phương thức thanh toán bằng thẻ ATM nội địa thay vì quét QR
        $requestType = "payWithATM";

        $rawHash = "accessKey=$accessKey&amount=$amount&extraData=&ipnUrl=$ipnUrl&orderId=$orderId&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=$redirectUrl&requestId=$requestId&requestType=$requestType";
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = [
            'partnerCode' => $partnerCode,
            'accessKey' => $accessKey,
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'extraData' => "",
            'requestType' => $requestType, // Chuyển sang thanh toán bằng thẻ ATM
            'signature' => $signature
        ];

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Tắt kiểm tra SSL nếu dùng localhost

        $response = curl_exec($ch);
        curl_close($ch);

        if ($response === false) {
            return back()->with('error', 'cURL Error: ' . curl_error($ch));
        }

        $jsonResult = json_decode($response, true);

        if (isset($jsonResult['payUrl'])) {
            return redirect()->away($jsonResult['payUrl']); // Chuyển hướng tới trang nhập thông tin thẻ ATM
        }

        return back()->with('error', 'Không thể tạo link thanh toán MoMo.');
    }
    // ✅ Cập nhật MoMo IPN để đảm bảo lưu đúng payment_status và payment_method
    public function moMoIPN(Request $request)
    {
        $data = $request->all();

        // Ghi log dữ liệu MoMo trả về để debug

        if (!isset($data['resultCode']) || !isset($data['orderId'])) {
            return response()->json(['message' => 'Invalid MoMo IPN data'], 400);
        }

        if ($data['resultCode'] == 0) { // Thanh toán thành công
            $order = Order::where('order_number', $data['orderId'])->first();
            if ($order) {
                $order->update([
                    'payment_status' => 'Paid',
                    'status' => 'process',
                    'payment_method' => 'momo' // Cập nhật phương thức thanh toán thành MoMo
                ]);
            } else {
                return response()->json(['message' => 'Order not found'], 404);
            }
        }

        return response()->json(['message' => 'IPN received successfully']);
    }

    // ✅ Kiểm tra & cập nhật đơn hàng khi redirect về trang success
    public function success(Request $request)
    {
        if ($request->has('orderId')) {
            $order = Order::where('order_number', $request->orderId)->first();
            if ($order && $order->payment_method == 'momo' && $order->payment_status != 'Paid') {
                $order->update([
                    'payment_status' => 'Paid',
                    'status' => 'process'
                ]);
            }
        }
             $pdfUrl = route('order.pdf', ['id' => $order->id]);
        $pdf = Http::get($pdfUrl)->body();

        // **Gửi email hóa đơn**
        Mail::to($order->email)->send(new OrderInvoiceMail($order, $pdf));
        $featured = Product::where('status', 'active')->where('is_featured', 1)->orderBy('price', 'DESC')->limit(2)->get();
        $posts = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(5)->get();
        $banners = Banner::where('status', 'active')->limit(3)->orderBy('id', 'DESC')->get();
        $products = Product::where('status', 'active')->orderBy('id', 'DESC')->where('is_featured', 1)->get();
        $category = Category::where('status', 'active')->where('is_parent', 1)->orderBy('title', 'ASC')->get();

        return view('frontend.index')
            ->with('featured', $featured)
            ->with('banners', $banners)
            ->with('posts', $posts)
            ->with('product_lists', $products)
            ->with('category_lists', $category)
            ->with('success', 'Thanh toán thành công! Cảm ơn bạn đã mua hàng.');
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
        // return $order;
        return view('backend.order.show')->with('order', $order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::find($id);
        return view('backend.order.edit')->with('order', $order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        $this->validate($request, [
            'status' => 'required|in:new,process,delivered,cancel'
        ]);
        $data = $request->all();
        // return $request->status;
        if ($request->status == 'delivered') {
            foreach ($order->cart as $cart) {
                $product = $cart->product;
                // return $product;
                $product->stock -= $cart->quantity;
                $product->save();
            }
        }
        $status = $order->fill($data)->save();
        if ($status) {
            request()->session()->flash('success', 'Cập nhật đơn hàng thành công');
        } else {
            request()->session()->flash('error', 'Có lỗi khi cập nhật đơn hàng');
        }
        return redirect()->route('order.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        if ($order) {
            $status = $order->delete();
            if ($status) {
                request()->session()->flash('success', 'Xóa đơn hàng thành công');
            } else {
                request()->session()->flash('error', 'Đơn hàng không thể xóa');
            }
            return redirect()->route('order.index');
        } else {
            request()->session()->flash('error', 'Không tìm thấy đơn hàng');
            return redirect()->back();
        }
    }

    public function orderTrack()
    {
        return view('frontend.pages.order-track');
    }

    public function productTrackOrder(Request $request)
    {
        $order = Order::where('user_id', auth()->user()->id)
            ->where('order_number', $request->order_number)
            ->first();

        if ($order) {
            if ($order->status == "new") {
                return response()->json(['message' => 'Đơn hàng của bạn đã được đặt. Vui lòng chờ.', 'icon' => 'info']);
            } elseif ($order->status == "process") {
                return response()->json(['message' => 'Đơn hàng của bạn đang được xử lý. Vui lòng chờ.', 'icon' => 'info']);
            } elseif ($order->status == "delivered") {
                return response()->json(['message' => 'Đơn hàng của bạn đã được giao. Xin chân thành cảm ơn.', 'icon' => 'success']);
            } else {
                return response()->json(['message' => 'Đơn hàng của bạn đã bị hủy, vui lòng thử lại.', 'icon' => 'error']);
            }
        } else {
            return response()->json(['message' => 'Mã đơn hàng không hợp lệ, vui lòng thử lại.', 'icon' => 'error']);
        }
    }
    public function pdf($id)
    {
        ini_set('max_execution_time', 600); // Cho phép xử lý lâu hơn nếu cần

        $order = Order::getAllOrder($id);

        if (!$order) {
            return redirect()->back()->with('error', 'Không tìm thấy hóa đơn');
        }

        $file_name = 'HoaDon-' . $order->order_number . '.pdf';

        // Tạo PDF
        $pdf = PDF::loadview('backend.order.pdf', compact('order'))
            ->setPaper('A4')
            ->setOptions([
                'defaultFont' => 'DejaVu Sans',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);

        return $pdf->download($file_name);
    }


    // Income chart
    public function incomeChart(Request $request)
    {
        $year = \Carbon\Carbon::now()->year;
        // dd($year);
        $items = Order::with(['cart_info'])->whereYear('created_at', $year)->where('status', 'delivered')->get()
            ->groupBy(function ($d) {
                return \Carbon\Carbon::parse($d->created_at)->format('m');
            });
        // dd($items);
        $result = [];
        foreach ($items as $month => $item_collections) {
            foreach ($item_collections as $item) {
                $amount = $item->cart_info->sum('amount');
                // dd($amount);
                $m = intval($month);
                // return $m;
                isset($result[$m]) ? $result[$m] += $amount : $result[$m] = $amount;
            }
        }
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = date('F', mktime(0, 0, 0, $i, 1));
            $data[$monthName] = (!empty($result[$i])) ? number_format((float)($result[$i]), 2, '.', '') : 0.0;
        }
        return $data;
    }

    // Income chart quarterly
    public function incomeChartQuarterly(Request $request)
    {
        $year = \Carbon\Carbon::now()->year;
        // Tạo một thể hiện mới của Carbon
        $currentDate = \Carbon\Carbon::now();
        // Gọi phương thức trên thể hiện
        $quarters = $currentDate->quartersUntil($endDate = null, $factor = 1);

        // Tiếp tục với logic của bạn
        $items = Order::with(['cart_info'])
            ->whereMonth('created_at', $quarters)
            ->where('status', 'delivered')
            ->get()
            ->groupBy(function ($d) {
                return \Carbon\Carbon::parse($d->created_at)->format('m');
            });

        // Logic tiếp theo
        $result = [];
        foreach ($items as $month => $item_collections) {
            foreach ($item_collections as $item) {
                $amount = $item->cart_info->sum('amount');
                $m = intval($month);
                isset($result[$m]) ? $result[$m] += $amount : $result[$m] = $amount;
            }
        }
        $data = [];
        for ($i = 1; $i <= 4; $i++) {
            $monthName = date('n', mktime(0, 0, 0, $i, 1));
            $data[$monthName] = (!empty($result[$i])) ? number_format((float)($result[$i]), 2, '.', '') : 0.0;
        }
        return $data;
    }
}
