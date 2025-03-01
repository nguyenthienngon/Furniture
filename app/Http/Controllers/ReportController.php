<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\RevenueReportExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function exportRevenueReport()
    {
        return Excel::download(new RevenueReportExport, 'bao_cao_doanh_thu.xlsx');
    }
}
