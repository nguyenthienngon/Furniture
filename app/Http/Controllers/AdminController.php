<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;
use App\User;
use App\Rules\MatchOldPassword;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $data = User::select(DB::raw("COUNT(*) as count"), DB::raw("DAYNAME(created_at) as day_name"), DB::raw("DAY(created_at) as day"))
            ->where('created_at', '>', Carbon::today()->subDays(6))
            ->groupBy('day_name', 'day')
            ->orderBy('day')
            ->get();

        if ($data->isEmpty()) {
            $array = [['Name', 'Number'], ['Không có dữ liệu', 0]]; // Đảm bảo có dữ liệu mặc định
        } else {
            $array = [['Name', 'Number']];
            foreach ($data as $value) {
                $array[] = [$value->day_name, (int) $value->count];
            }
        }

        return view('backend.index')->with('users', json_encode($array));
    }



    // API lấy dữ liệu doanh thu theo tháng
    public function getIncomeData(Request $request)
    {
        $month = $request->query('month', date('m'));
        $income = Order::select(
            DB::raw("DATE(created_at) as date"),
            DB::raw("SUM(total_amount) as revenue")
        )
            ->whereMonth('created_at', $month)
            ->groupBy('date')
            ->pluck('revenue', 'date');

        return response()->json($income);
    }

    // API lấy dữ liệu doanh thu theo cả năm
    public function getIncomeDataAll()
    {
        $income = Order::select(
            DB::raw("MONTH(created_at) as month"),
            DB::raw("SUM(total_amount) as revenue")
        )
            ->where('status', 'delivered') // Lọc theo trạng thái đã giao hàng
            ->groupBy('month')
            ->pluck('revenue', 'month');

        return response()->json($income);
    }

    public function getUserRegistrationData()
    {
        $data = User::select(
            DB::raw("COUNT(*) as count"),
            DB::raw("DAYNAME(created_at) as day_name"),
            DB::raw("DAY(created_at) as day")
        )
            ->where('created_at', '>', Carbon::today()->subDays(6))
            ->groupBy('day_name', 'day')
            ->orderBy('day')
            ->get();

        $array = [];
        foreach ($data as $value) {
            $array[] = [$value->day_name, (int) $value->count];
        }

        return response()->json($array);
    }

    public function profile()
    {
        $profile = Auth()->user();
        // return $profile;
        return view('backend.users.profile')->with('profile', $profile);
    }

    public function profileUpdate(Request $request, $id)
    {
        // return $request->all();
        $user = User::findOrFail($id);
        $data = $request->all();
        $status = $user->fill($data)->save();
        if ($status) {
            request()->session()->flash('success', 'Cập nhật thông tin cá nhân thành công');
        } else {
            request()->session()->flash('error', 'Vui lòng thử lại!');
        }
        return redirect()->back();
    }

    public function settings()
    {
        $data = Settings::first();
        return view('backend.setting')->with('data', $data);
    }

    public function settingsUpdate(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'short_des' => 'required|string',
            'description' => 'required|string',
            'photo' => 'required',
            'logo' => 'required',
            'address' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
        ]);
        $data = $request->all();
        // return $data;
        $settings = Settings::first();
        // return $settings;
        $status = $settings->fill($data)->save();
        if ($status) {
            request()->session()->flash('success', 'Cập nhật cài đặt thành công');
        } else {
            request()->session()->flash('error', 'Vui lòng thử lại');
        }
        return redirect()->route('admin');
    }

    public function changePassword()
    {
        return view('backend.layouts.changePassword');
    }
    public function changPasswordStore(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);

        return redirect()->route('admin')->with('success', 'thay đổi mật khẩu thành công');
    }
}
