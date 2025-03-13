<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\RevenueReportExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function exportRevenue(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        if (!$start_date || !$end_date) {
            return redirect()->back()->with('error', 'Vui lòng chọn khoảng thời gian hợp lệ.');
        }

        // Lấy dữ liệu trong khoảng thời gian được chọn
        $revenues = Order::whereBetween('created_at', [$start_date, $end_date])->get();

        // Xuất báo cáo ra Excel hoặc PDF
        return Excel::download(new RevenueExport($revenues), 'bao-cao-doanh-thu.xlsx');
    }
}
