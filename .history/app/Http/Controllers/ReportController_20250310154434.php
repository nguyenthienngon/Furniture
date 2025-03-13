<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\RevenueReportExport;
use App\Models\Order;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function exportRevenue(Request $request)
    {
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');

        return Excel::download(new RevenueReportExport($from_date, $to_date), 'doanh-thu.xlsx');
    }
}
