<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RevenueReportExport implements FromView
{
    protected $from_date;
    protected $to_date;

    public function __construct($from_date = null, $to_date = null)
    {
        $this->from_date = $from_date;
        $this->to_date = $to_date;
    }

    public function view(): View
    {
        // Lọc theo khoảng thời gian
        $orderQuery = Order::query();
        if ($this->from_date && $this->to_date) {
            $orderQuery->whereBetween('orders.created_at', [$this->from_date, $this->to_date]);
        }

        // Tổng doanh thu theo ngày
        $orders = $orderQuery->selectRaw('DATE(orders.created_at) as date, SUM(orders.total_amount) as total_revenue')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get()
            ->keyBy('date'); // Chuyển thành mảng với key là ngày

        // Doanh thu theo danh mục
        $categoryRevenue = Order::join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('categories', 'products.cat_id', '=', 'categories.id')
            ->selectRaw('categories.title as category_name, SUM(orders.total_amount) as revenue')
            ->groupBy('categories.title');

        // Doanh thu theo khách hàng
        $customerRevenue = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->selectRaw('users.name as customer_name, SUM(orders.total_amount) as revenue')
            ->groupBy('users.name');

        // Doanh thu theo sản phẩm
        $productRevenue = Order::join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->selectRaw('products.title as product_name, SUM(order_details.quantity * products.price) as revenue')
            ->groupBy('products.title');

        // Sản phẩm bán chạy nhất (top 5)
        $topSellingProducts = Order::join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->selectRaw('products.title as product_name, SUM(order_details.quantity) as quantity_sold')
            ->groupBy('products.title')
            ->orderByDesc('quantity_sold')
            ->limit(5);

        // Nếu có bộ lọc ngày, áp dụng vào tất cả truy vấn
        if ($this->from_date && $this->to_date) {
            $categoryRevenue->whereBetween('orders.created_at', [$this->from_date, $this->to_date]);
            $customerRevenue->whereBetween('orders.created_at', [$this->from_date, $this->to_date]);
            $productRevenue->whereBetween('orders.created_at', [$this->from_date, $this->to_date]);
            $topSellingProducts->whereBetween('orders.created_at', [$this->from_date, $this->to_date]);
        }

        return view('backend.exports.index', [
            'orders'          => $orders,
            'allDates'        => $allDates,
            'categoryRevenue' => $categoryRevenue->get(),
            'customerRevenue' => $customerRevenue->get(),
            'productRevenue'  => $productRevenue->get(),
            'topSellingProducts' => $topSellingProducts->get(),
        ]);
    }
}
