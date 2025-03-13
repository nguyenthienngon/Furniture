<?php

namespace App\Http\Controllers;

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
        return response()->json($province ? $province['District'] : []);
    }

    public function getWards($provinceCode, $districtCode)
    {
        $data = $this->getAddressData();
        $province = collect($data)->firstWhere('Code', $provinceCode);
        $district = collect($province['District'] ?? [])->firstWhere('Code', $districtCode);
        return response()->json($district ? $district['Ward'] : []);
    }

    private function getAddressData()
    {
        $json = file_get_contents(public_path('js/address.json'));
        return json_decode($json, true);
    }
}
