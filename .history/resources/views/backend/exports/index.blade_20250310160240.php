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

        .total-row {
            font-weight: bold;
            background-color: #ffeeba;
        }
    </style>
</head>

<body>
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
                        $revenue = $orders->where('date', $date)->sum('total_revenue');
                        $totalRevenue += $revenue;
                    @endphp
                    <tr>
                        <td>{{ $date }}</td>
                        <td>{{ number_format($revenue, 0, ',', '.') }} VND</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td>Tổng doanh thu</td>
                    <td>{{ number_format($totalRevenue, 0, ',', '.') }} VND</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
