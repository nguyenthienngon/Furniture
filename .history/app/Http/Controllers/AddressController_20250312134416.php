<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function getDistricts(Request $request)
    {
        $districts = DB::table('districts')
            ->where('province_code', $request->province_code)
            ->get();
        return response()->json($districts);
    }

    public function getWards(Request $request)
    {
        $wards = DB::table('wards')
            ->where('district_code', $request->district_code)
            ->get();
        return response()->json($wards);
    }
}
