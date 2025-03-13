<!DOCTYPE html>
<html>

<head>
    <title>Hóa đơn điện tử</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            margin: 0;
        }

        .invoice-box {
            padding: 5px 10px 10px 10px;
            border: 1px solid #000;
            background: #fff;
            max-width: 800px;
            margin: 0 auto;
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2px;
        }

        .company-logo {
            font-size: 24px;
            font-weight: bold;
            color: #000;
        }

        .invoice-title {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }

        .invoice-title-sub {
            font-size: 12px;
            text-align: center;
            margin-top: -5px;
        }

        .invoice-details {
            text-align: right;
            font-size: 12px;
        }

        .company-info,
        .buyer-info {
            margin-bottom: 5px;
        }

        .company-info p,
        .buyer-info p {
            margin: 1px 0;
        }

        .table th {
            background: #000;
            color: #fff;
            text-align: center;
            font-size: 12px;
            padding: 5px;
        }

        .table td {
            padding: 5px;
            text-align: center;
            font-size: 12px;
        }

        .table .text-left {
            text-align: left;
        }

        .table .text-right {
            text-align: right;
        }

        .totals-table {
            margin-top: 5px;
        }

        .totals-table td {
            padding: 5px;
            font-weight: bold;
        }

        .footer-note {
            font-size: 10px;
            text-align: center;
            margin-top: 10px;
        }

        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 5px;
            /* Reduced from 10px to 5px to halve the space */
            position: relative;
            /* Added for absolute positioning of stamp */
        }

        .signature-buyer,
        .signature-seller {
            width: 40%;
            text-align: center;
            /* Centered text for consistency */
        }

        .signature-seller {
            position: relative;
            /* Container for absolute positioning of stamp */
        }

        .signature-stamp {
            position: absolute;
            top: -20px;
            /* Adjust this value to move the stamp up or down */
            right: 0;
            background-color: #d4edda;
            /* Light green background for validity */
            border: 1px solid #28a745;
            /* Green border */
            padding: 2px 5px;
            font-size: 10px;
            color: #28a745;
            border-radius: 3px;
        }

        .signature-date {
            border: 1px solid #000;
            padding: 2px 5px;
            display: inline-block;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class="container invoice-box">
        <!-- Header -->
        <div class="invoice-header">
            <div class="company-logo">ARTISAN</div>
            <div>
                <h2 class="invoice-title">HÓA ĐƠN ĐIỆN TỬ</h2>
                <p class="invoice-title-sub">HOA DON DIEN TU BAN HANG</p>
            </div>
            <div class="invoice-details">
                <p><strong>Số:</strong> #ORD-ZS9MWWKYAI</p>
                <p><strong>Ngày lập:</strong> 12/03/2025</p>
            </div>
        </div>

        <!-- Seller Information -->
        <div class="company-info">
            <p><strong>Người bán hàng:</strong> Tập đoàn xuất nhập khẩu - Ngôn Nguyễn</p>
            <p><strong>Địa chỉ:</strong> Khu II, Đ. 3 Tháng 2, Xuân Khánh, Ninh Kiều, Cần Thơ</p>
            <p><strong>Mã số thuế:</strong> 0100109106</p>
            <p><strong>Điện thoại:</strong> 0981234567</p>
            <p><strong>Email:</strong> support@artisan.com.vn</p>
            <hr>
        </div>

        <!-- Buyer Information -->
        <div class="buyer-info">
            <p><strong>Người mua hàng:</strong> test2 Nguyễn</p>
            <p><strong>Địa chỉ:</strong> 810, Vietnam</p>
            <p><strong>Điện thoại:</strong> 0930647899</p>
            <p><strong>Email:</strong> admin@gmail.com</p>
        </div>

        <!-- Product Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên hàng hóa, dịch vụ</th>
                    <th>ĐVT</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td class="text-left">Tủ Quần Áo MOHO KOSTER Màu Nâu</td>
                    <td>Chiếc</td>
                    <td>1</td>
                    <td class="text-right">5.501.200</td>
                    <td class="text-right">5.501.200</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td class="text-left">Kệ Đệ Sách 5 Tầng Artisan WORKS 701</td>
                    <td>Chiếc</td>
                    <td>1</td>
                    <td class="text-right">4.200.000</td>
                    <td class="text-right">4.200.000</td>
                </tr>
            </tbody>
        </table>

        <!-- Totals Table -->
        <table class="table table-bordered totals-table">
            <tbody>
                <tr>
                    <td class="text-left">Tạm tính</td>
                    <td class="text-right">9.701.200 VNĐ</td>
                </tr>
                <tr>
                    <td class="text-left">Thuế GTGT (10%)</td>
                    <td class="text-right">970.120 VNĐ</td>
                </tr>
                <tr>
                    <td class="text-left">Tổng cộng</td>
                    <td class="text-right">9.751.200 VNĐ</td>
                </tr>
                <tr>
                    <td class="text-left">Số tiền bằng chữ</td>
                    <td class="text-right">Chín triệu bảy trăm năm mươi mốt nghìn hai trăm đồng</td>
                </tr>
            </tbody>
        </table>

        <!-- Footer Note -->
        <div class="footer-note">
            <p>(Hóa đơn điện tử không bắt buộc sử dụng con dấu của người bán và người mua)</p>
        </div>

        <!-- Signatures -->
        <div class="signatures">
            <div class="signature-buyer">
                <p>Người mua hàng</p>
                <p>(Ký, ghi rõ họ tên)</p>
            </div>
            <div class="signature-seller">
                <p>Người bán hàng</p>
                <p>(Ký, ghi rõ họ tên)</p>
                <div class="signature-stamp">
                    Signature Valid<br>
                    Ký bởi Công ty xuất nhập khẩu Ngôn Nguyễn<br>
                    Ký ngày: 21/05/2023
                </div>
            </div>
        </div>
    </div>
</body>

</html>
