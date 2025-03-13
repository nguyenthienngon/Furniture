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

    <div class="table-container">
        <h2 class="table-title">Thống kê đơn hàng theo trạng thái</h2>
        <table>
            <thead>
                <tr>
                    <th>Trạng thái</th>
                    <th>Số lượng đơn hàng</th>
                    <th>Doanh thu</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderStatusReport as $status => $data)
                    <tr>
                        <td>
                            @switch($status)
                                @case('delivered')
                                    Đã giao
                                @break

                                @case('new')
                                    Mới
                                @break

                                @case('cancel')
                                    Hủy
                                @break

                                @case('process')
                                    Đang xử lý
                                @break

                                @default
                                    {{ ucfirst($status) }}
                            @endswitch
                        </td>
                        <td>{{ $data['count'] }}</td>
                        <td>{{ number_format($data['revenue'], 0, ',', '.') }} VND</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

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
                @foreach ($allDates as $date)
                    <tr>
                        <td>{{ $date }}</td>
                        <td>{{ number_format($orders[$date]->total_revenue ?? 0, 0, ',', '.') }} VND</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>
