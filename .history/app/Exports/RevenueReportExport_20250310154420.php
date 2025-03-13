<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
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
        // Áp dụng bộ lọc thời gian
        $query = Order::query();
        if ($this->from_date && $this->to_date) {
            $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
        }

        // Tổng doanh thu theo ngày
        $orders = $query->selectRaw('DATE(created_at) as date, SUM(total_amount) as total_revenue')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();

        // Doanh thu theo danh mục
        $categoryRevenue = $query->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('categories', 'products.cat_id', '=', 'categories.id')
            ->selectRaw('categories.title as category_name, SUM(order_details.quantity * order_details.price) as revenue')
            ->groupBy('categories.title')
            ->get();

        // Doanh thu theo khách hàng
        $customerRevenue = $query->join('users', 'orders.user_id', '=', 'users.id')
            ->selectRaw('users.name as customer_name, SUM(total_amount) as revenue')
            ->groupBy('users.name')
            ->get();

        // Doanh thu theo sản phẩm
        $productRevenue = $query->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->selectRaw('products.title as product_name, SUM(order_details.quantity * order_details.price) as revenue')
            ->groupBy('products.title')
            ->get();

        // Sản phẩm bán chạy nhất (top 5)
        $topSellingProducts = $query->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->selectRaw('products.title as product_name, SUM(order_details.quantity) as quantity_sold')
            ->groupBy('products.title')
            ->orderByDesc('quantity_sold')
            ->limit(5)
            ->get();

        return view('backend.exports.index', compact('orders', 'categoryRevenue', 'customerRevenue', 'productRevenue', 'topSellingProducts'));
    }
}
