<!DOCTYPE html>
<html>

<head>
    <title>Invoice @if ($order)
            - {{ $order->order_number }}
        @endif
    </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    @if ($order)
        <style>
            body {
                font-family: "DejaVu Sans", sans-serif;
            }

            .invoice-header {
                background: #f7f7f7;
                padding: 15px 20px;
                border-bottom: 2px solid #ddd;
            }

            .site-logo {
                margin-top: 10px;
            }

            .invoice-title {
                color: #333;
                font-size: 28px;
                font-weight: bold;
            }

            .invoice-details,
            .customer-details {
                padding: 20px;
                border: 1px solid #ddd;
                margin-bottom: 20px;
            }

            thead {
                background: #007bff;
                color: white;
            }
        </style>

        <div class="invoice-header d-flex justify-content-between align-items-center">
            <div class="site-logo">
                <img src="{{ public_path('images/logo1.png') }}" alt="Logo">
            </div>
            <div class="text-right">
                <h4>Artisan Furniture</h4>
                <p>351/9 Khu vực 6 An Bình, Ninh Kiều, Cần Thơ</p>
                <p>Phone: <a href="tel:{{ env('0774823918') }}">0774823918</a></p>
                <p>Email: <a
                        href="mailto:{{ env('ngonb2110020@student.ctu.edu.vn') }}">ngonb2110020@student.ctu.edu.vn</a>
                </p>
            </div>
        </div>

        <div class="invoice-details">
            <h3 class="invoice-title">Invoice #{{ $order->order_number }}</h3>
            <p>Date: {{ $order->created_at->format('D, d M Y') }}</p>
        </div>

        <div class="customer-details">
            <h5>Billing Information</h5>
            <p><strong>Name:</strong> {{ $order->first_name }} {{ $order->last_name }}</p>
            <p><strong>Country:</strong> {{ $order->country }}</p>
            <p><strong>Address:</strong> {{ $order->address1 }} {{ $order->address2 ? ' , ' . $order->address2 : '' }}
            </p>
            <p><strong>Phone:</strong> {{ $order->phone }}</p>
            <p><strong>Email:</strong> {{ $order->email }}</p>
        </div>

        <section class="order_details">
            <h5>Order Details</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->cart_info as $cart)
                        @php
                            $product = DB::table('products')->select('title')->where('id', $cart->product_id)->first();
                        @endphp
                        <tr>
                            <td>{{ $product->title ?? 'Unknown Product' }}</td>
                            <td>x{{ $cart->quantity }}</td>
                            <td>{{ number_format($cart->price, 0) }}đ</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2" class="text-right">Subtotal:</th>
                        <th>{{ number_format($order->sub_total, 0) }}đ</th>
                    </tr>
                    <tr>
                        <th colspan="2" class="text-right">Total:</th>
                        <th>{{ number_format($order->total_amount, 0) }}đ</th>
                    </tr>
                </tfoot>
            </table>
        </section>

        <div class="text-right mt-5">
            <p>-----------------------------</p>
            <h5>Authorized Signature</h5>
        </div>
    @else
        <h5 class="text-danger">Invalid Order</h5>
    @endif
</body>

</html>
