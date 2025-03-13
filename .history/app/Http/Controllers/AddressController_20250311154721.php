<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class AddressController extends Controller
{
   public function index()
    {
        // Đọc dữ liệu JSON từ file
        $json = file_get_contents(storage_path('app/public/address.json'));
        $locations = json_decode($json, true); // Chuyển JSON thành mảng

        return view('locations.index', compact('locations'));
    }
}
