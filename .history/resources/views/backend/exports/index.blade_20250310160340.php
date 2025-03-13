<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo cáo doanh thu</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        th,
        td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        td {
            font-size: 16px;
        }

        .table-container {
            margin-bottom: 40px;
        }

        .table-title {
            font-size: 20px;
            color: #333;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <!-- Báo cáo doanh thu theo ngày -->
    <div class="table-container">
        <h2 class="table-title">Báo cáo doanh thu theo ngày</h2>
        <table>
            <thead>
                <tr>
                    <th>Ngày</th>
                    <th>Doanh thu</th>
                </tr>
            </thead>
            <tbody>
                @php $totalRevenue = 0; @endphp
                @foreach ($allDates as $date)
                    @php
                        $revenue = isset($orders[$date]) ? $orders[$date]->total_revenue : 0;
                        $totalRevenue += $revenue;
                    @endphp
                    <tr>
                        <td>{{ $date }}</td>
                        <td>{{ number_format($revenue, 0, ',', '.') }} VND</td>
                    </tr>
                @endforeach
                <tr>
                    <td><strong>Tổng doanh thu</strong></td>
                    <td><strong>{{ number_format($totalRevenue, 0, ',', '.') }} VND</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Báo cáo doanh thu theo danh mục -->
    <div class="table-container">
        <h2 class="table-title">Báo cáo doanh thu theo danh mục</h2>
        <table>
            <thead>
                <tr>
                    <th>Danh mục</th>
                    <th>Doanh thu</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categoryRevenue as $category)
                    <tr>
                        <td>{{ $category->category_name }}</td>
                        <td>{{ number_format($category->revenue, 0, ',', '.') }} VND</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Báo cáo doanh thu theo khách hàng -->
    <div class="table-container">
        <h2 class="table-title">Báo cáo doanh thu theo khách hàng</h2>
        <table>
            <thead>
                <tr>
                    <th>Khách hàng</th>
                    <th>Doanh thu</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customerRevenue as $customer)
                    <tr>
                        <td>{{ $customer->customer_name }}</td>
                        <td>{{ number_format($customer->revenue, 0, ',', '.') }} VND</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Báo cáo sản phẩm bán chạy -->
    <div class="table-container">
        <h2 class="table-title">Báo cáo sản phẩm bán chạy</h2>
        <table>
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Số lượng bán</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($topSellingProducts as $product)
                    <tr>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->quantity_sold }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Báo cáo số lượng sản phẩm bán ra -->
    <div class="table-container">
        <h2 class="table-title">Báo cáo số lượng sản phẩm bán ra</h2>
        <table>
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productRevenue as $sale)
                    <tr>
                        <td>{{ $sale->product_name }}</td>
                        <td>{{ $sale->quantity_sold }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>
