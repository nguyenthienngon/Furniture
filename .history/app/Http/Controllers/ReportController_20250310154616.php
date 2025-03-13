<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\RevenueReportExport;
use App\Models\Order;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function exportRevenueReport(Request $request)
    {
        // Lấy ngày bắt đầu và ngày kết thúc từ request
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Kiểm tra nếu thiếu ngày thì trả về lỗi
        if (!$start_date || !$end_date) {
            return redirect()->back()->with('error', 'Vui lòng chọn khoảng thời gian.');
        }

        // Xuất file Excel với khoảng thời gian được chọn
        return Excel::download(new RevenueReportExport($start_date, $end_date), 'bao-cao-doanh-thu.xlsx');
    }
}
