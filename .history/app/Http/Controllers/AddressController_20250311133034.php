<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function getProvinces()
    {
        $data = $this->getAddressData();
        $provinces = [];
        foreach ($data as $province) {
            $provinces[] = [
                'code' => $province['Code'],
                'name' => $province['FullName']
            ];
        }
        return response()->json($provinces);
    }

    public function getDistricts($provinceCode)
    {
        $data = $this->getAddressData();
        $province = collect($data)->firstWhere('Code', $provinceCode);
        if ($province && isset($province['District'])) {
            $districts = [];
            foreach ($province['District'] as $district) {
                $districts[] = [
                    'Code' => $district['Code'],
                    'FullName' => $district['FullName']
                ];
            }
            return response()->json($districts);
        }
        return response()->json([]); // Trả về mảng rỗng nếu không tìm thấy
    }

    public function getWards($provinceCode, $districtCode)
    {
        $data = $this->getAddressData();
        $province = collect($data)->firstWhere('Code', $provinceCode);
        if ($province && isset($province['District'])) {
            $district = collect($province['District'])->firstWhere('Code', $districtCode);
            if ($district && isset($district['Ward'])) {
                $wards = [];
                foreach ($district['Ward'] as $ward) {
                    $wards[] = [
                        'Code' => $ward['Code'],
                        'FullName' => $ward['FullName']
                    ];
                }
                return response()->json($wards);
            }
        }
        return response()->json([]); // Trả về mảng rỗng nếu không tìm thấy
    }

    private function getAddressData()
    {
        $json = file_get_contents(public_path('js/address.json'));
        $data = json_decode($json, true);
        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            Log::error('Lỗi giải mã JSON: ' . json_last_error_msg());
            return []; // Trả về mảng rỗng nếu có lỗi
        }
        return $data;
    }
}
