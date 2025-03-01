<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RevenueReportExport implements FromView
{
    public function view(): View
    {
        $orders = Order::selectRaw('DATE(created_at) as date, SUM(total_amount) as total_revenue')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();

        $categoryRevenue = Product::join('order_details', 'products.id', '=', 'order_details.product_id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('categories', 'products.cat_id', '=', 'categories.id')
            ->selectRaw('categories.title as category_name, SUM(orders.total_amount) as revenue')
            ->groupBy('categories.title')
            ->get();

        $customerRevenue = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->selectRaw('users.name as customer_name, SUM(orders.total_amount) as revenue')
            ->groupBy('users.name')
            ->get();

        $productRevenue = Product::join('order_details', 'products.id', '=', 'order_details.product_id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->selectRaw('products.title as product_name, SUM(orders.total_amount) as revenue')
            ->groupBy('products.title')
            ->get();

        $topSellingProducts = Product::join('order_details', 'products.id', '=', 'order_details.product_id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->selectRaw('products.title as product_name, SUM(order_details.quantity) as quantity_sold')
            ->groupBy('products.title')
            ->orderBy('quantity_sold', 'desc')
            ->limit(5)
            ->get();

        $productSales = Product::join('order_details', 'products.id', '=', 'order_details.product_id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->selectRaw('products.title as product_name, SUM(order_details.quantity) as quantity_sold')
            ->groupBy('products.title')
            ->get();

        return view('backend.exports.index', compact('orders', 'categoryRevenue', 'customerRevenue', 'productRevenue', 'topSellingProducts', 'productSales'));
    }
}
