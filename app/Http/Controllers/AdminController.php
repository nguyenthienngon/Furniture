<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;
use App\User;
use App\Rules\MatchOldPassword;
use App\Models\Order;
use App\Models\Product;
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
            $array = [['Name', 'Number'], ['Không có dữ liệu', 0]];
        } else {
            $array = [['Name', 'Number']];
            foreach ($data as $value) {
                $array[] = [$value->day_name, (int) $value->count];
            }
        }

        return view('backend.index')->with('users', json_encode($array));
    }

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

    public function getIncomeDataAll()
    {
        $income = Order::select(
            DB::raw("MONTH(created_at) as month"),
            DB::raw("SUM(total_amount) as revenue")
        )
            ->where('status', 'delivered')
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
    public function getOrderStats()
    {
        $data = DB::table('orders')
            ->selectRaw("
                COALESCE(SUM(CASE WHEN status = 'delivered' THEN 1 ELSE 0 END), 0) as success,
                COALESCE(SUM(CASE WHEN status = 'cancel' THEN 1 ELSE 0 END), 0) as canceled,
                COUNT(*) as total
            ")
            ->first();

        return response()->json([
            'success' => $data->success ?? 0,
            'canceled' => $data->canceled ?? 0,
            'total' => $data->total ?? 0
        ]);
    }

    public function conversionRate()
    {
        // Đếm số lượng khách truy cập trong 1 tuần qua
        $totalVisitors = DB::table('visitor_logs')
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();

        // Đếm tổng số đơn hàng trong 1 tuần qua
        $totalOrders = Order::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();

        // Tính tỷ lệ chuyển đổi
        $conversionRate = ($totalOrders / max($totalVisitors, 1)) * 100;

        return response()->json([
            'conversion_rate' => round($conversionRate, 2), // Làm tròn 2 số thập phân
            'total_visitors' => $totalVisitors,
            'total_orders' => $totalOrders
        ]);
    }


    public function productSalesByCategory()
    {
        $salesData = DB::table('orders')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('categories', 'products.cat_id', '=', 'categories.id')
            ->select(
                'categories.title as category',
                DB::raw("SUM(CASE WHEN MONTH(orders.created_at) = MONTH(CURRENT_DATE()) THEN order_details.quantity ELSE 0 END) as current_month_sales"),
                DB::raw("SUM(CASE WHEN MONTH(orders.created_at) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH) THEN order_details.quantity ELSE 0 END) as previous_month_sales")
            )
            ->groupBy('categories.title')
            ->orderBy('current_month_sales', 'desc')
            ->get();

        return response()->json($salesData);
    }

    public function orderCompletionRate()
    {
        $completedOrders = Order::where('status', 'deliverd')->count();
        $cancelledOrders = Order::where('status', 'cancel')->count();
        $totalOrders = max(($completedOrders + $cancelledOrders), 1);

        return response()->json([
            'completed' => round(($completedOrders / $totalOrders) * 100, 2) . '%',
            'cancelled' => round(($cancelledOrders / $totalOrders) * 100, 2) . '%'
        ]);
    }

    public function mostViewedProducts()
    {
        $products = Product::orderBy('views', 'desc')->take(10)->get(['name', 'views']);
        return response()->json($products);
    }

    public function visitorStats()
    {
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek(); // Bắt đầu tuần hiện tại (Thứ 2)
        $endOfWeek = Carbon::now()->endOfWeek(); // Kết thúc tuần hiện tại (Chủ nhật)

        // Lấy dữ liệu theo ngày (7 ngày gần nhất)
        $dailyVisitors = DB::table('visitor_logs')
            ->select(DB::raw("DATE(visited_at) as date, COUNT(id) as total_visitors"))
            ->whereDate('visited_at', '>=', Carbon::now()->subDays(6)) // Lấy 7 ngày gần nhất
            ->groupBy(DB::raw("DATE(visited_at)"))
            ->orderBy('date', 'ASC')
            ->get();

        // Lấy dữ liệu theo tuần (gom nhóm theo từng tuần, mỗi tuần gồm 7 ngày)
        $weeklyVisitors = DB::table('visitor_logs')
            ->select(DB::raw("YEARWEEK(visited_at, 1) as week, COUNT(id) as total_visitors"))
            ->where('visited_at', '>=', Carbon::now()->subWeeks(6)) // Lấy dữ liệu của 6 tuần gần nhất
            ->groupBy(DB::raw("YEARWEEK(visited_at, 1)"))
            ->orderBy('week', 'ASC')
            ->get();

        return response()->json([
            'daily_labels' => $dailyVisitors->pluck('date')->map(function ($date) {
                return Carbon::parse($date)->format('d/m'); // Hiển thị định dạng ngày "dd/mm"
            }),
            'daily' => $dailyVisitors->pluck('total_visitors'), // Lượt truy cập theo ngày

            'weekly_labels' => $weeklyVisitors->pluck('week')->map(function ($week) {
                $startOfWeek = Carbon::now()->setISODate(substr($week, 0, 4), substr($week, -2))->startOfWeek()->format('d/m');
                $endOfWeek = Carbon::now()->setISODate(substr($week, 0, 4), substr($week, -2))->endOfWeek()->format('d/m');
                return "$startOfWeek - $endOfWeek"; // Hiển thị tuần dưới dạng "01/02 - 07/02"
            }),

            'weekly' => $weeklyVisitors->pluck('total_visitors'), // Lượt truy cập theo tuần
        ]);
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
