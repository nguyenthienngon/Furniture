@extends('backend.layouts.master')
@section('title',
    'Artisan
    || DASHBOARD')
@section('main-content')
    <div class="container-fluid">
        @include('backend.layouts.notification')
        <!-- Page Heading -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <button class="btn btn-success btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#dateRangeModal">
                <i class="fas fa-download fa-sm text-white-50"></i> Xuất báo cáo
            </button>
        </div>

        <!-- Modal Chọn Ngày -->
        <div class="modal fade" id="dateRangeModal" tabindex="-1" role="dialog" aria-labelledby="dateRangeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="dateRangeModalLabel">Chọn khoảng thời gian</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('export.revenue') }}" method="GET">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="start_date">Từ ngày:</label>
                                <input type="date" class="form-control" name="start_date" id="start_date" required>
                            </div>
                            <div class="form-group">
                                <label for="end_date">Đến ngày:</label>
                                <input type="date" class="form-control" name="end_date" id="end_date" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Xuất báo cáo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            // Lấy ngày hiện tại
            let today = new Date().toISOString().split('T')[0];

            // Gán ngày tối đa cho input
            document.getElementById("start_date").setAttribute("max", today);
            document.getElementById("end_date").setAttribute("max", today);
        </script>





        <!-- Content Row -->
        <div class="row">

            <!-- Category -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Danh mục sản phẩm
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ \App\Models\Category::countActiveCategory() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-sitemap fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Sản phẩm</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ \App\Models\Product::countActiveProduct() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-cubes fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Đơn hàng</div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                            {{ \App\Models\Order::countActiveOrder() }}</div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--Posts-->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Bài viết</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    0</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-folder fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <!-- Số lượng khách hàng -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Khách Hàng</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\User::countActiveUser() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hàng tồn -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Hàng tồn kho</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ \App\Models\Product::sumActiveProduct() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-cubes fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Đơn hàng chưa duyệt -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Đơn hàng chưa duyệt
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                            {{ \App\Models\Order::countNewOrder() }}</div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--Đơn hàng đã hủy-->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Đơn hàng đã hủy</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ \App\Models\Order::countCancelOrder() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-trash-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <!-- Tổng doanh thu -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Tổng doanh thu</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ number_format(\App\Models\Order::totalOfSales(), 0) }}đ</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Biểu đồ cột doanh thu -->
            <!-- Biểu đồ doanh thu -->
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Tổng doanh thu các tháng</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="myLineChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <!-- Biểu đồ số người đăng ký -->
                    <div class="col-md-6 p-1">
                        <div class="card">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Số người đăng ký trong 7 ngày gần nhất</h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-area d-flex justify-content-center">
                                    <canvas id="userRegistrationChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Biểu đồ tỷ lệ đơn hàng -->
                    <div class="col-md-6 p-1">
                        <div class="card">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Tỷ lệ đơn hàng</h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-area d-flex justify-content-center">
                                    <canvas id="orderStatsChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>






            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Số lượng sản phẩm đã bán theo danh mục</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="productSalesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Lượng truy cập</h6>
                        <select id="dataFilter" class="form-select w-auto">
                            <option value="daily">Ngày</option>
                            <option value="weekly">Tuần</option>

                        </select>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="visitorChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>

@endsection
@push('scripts')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch("{{ route('admin.orderStats') }}")
                .then(response => response.json())
                .then(data => {
                    console.log("Dữ liệu đơn hàng:", data);

                    let ctx = document.getElementById('orderStatsChart');
                    if (!ctx) {
                        console.error("Không tìm thấy phần tử orderStatsChart");
                        return;
                    }
                    ctx = ctx.getContext('2d');

                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Thành công', 'Đã hủy', 'Tổng đơn'],
                            datasets: [{
                                data: [data.success, data.canceled, data.total],
                                backgroundColor: ['#28a745', '#dc3545', '#ffc107'],
                                hoverOffset: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            return tooltipItem.raw + " đơn";
                                        }
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error("Lỗi khi tải dữ liệu biểu đồ đơn hàng:", error));
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function loadLineChart() {
                axios.get("{{ route('product.order.income.all') }}")
                    .then(response => {
                        console.log(response.data);

                        const ctx = document.getElementById("myLineChart");
                        if (!ctx) return;

                        const months = Object.keys(response.data);
                        const revenues = Object.values(response.data);

                        if (months.length === 0) {
                            console.log("Không có dữ liệu doanh thu");
                            return;
                        }

                        if (window.lineChart) {
                            window.lineChart.destroy();
                        }

                        window.lineChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: months,
                                datasets: [{
                                    label: "Doanh thu",
                                    backgroundColor: "rgba(78, 115, 223, 0.2)",
                                    borderColor: "rgba(78, 115, 223, 1)",
                                    data: revenues,
                                    fill: true,
                                    tension: 0.3
                                }],
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    x: {
                                        title: {
                                            display: true,
                                            text: "Tháng"
                                        }
                                    },
                                    y: {
                                        title: {
                                            display: true,
                                            text: "Doanh thu"
                                        }
                                    }
                                }
                            }
                        });
                    })
                    .catch(error => console.log("Lỗi tải dữ liệu:", error));
            }

            loadLineChart();
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function drawPieChart() {
                axios.get("{{ route('admin.user.registrations') }}")
                    .then(response => {
                        console.log(response.data);

                        if (!Array.isArray(response.data) || response.data.length === 0) {
                            console.log("Không có dữ liệu đăng ký");
                            return;
                        }

                        const labels = response.data.map(item => item[0]); // Lấy tên ngày
                        const values = response.data.map(item => item[1]); // Lấy số lượng đăng ký

                        const ctx = document.getElementById("userRegistrationChart");
                        if (!ctx) return;

                        // Hủy biểu đồ cũ nếu có
                        if (window.pieChart) {
                            window.pieChart.destroy();
                        }

                        // Vẽ biểu đồ tròn với Chart.js
                        window.pieChart = new Chart(ctx, {
                            type: 'pie',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: "Số người đăng ký",
                                    backgroundColor: [
                                        "#FF6384", "#36A2EB", "#FFCE56", "#4BC0C0",
                                        "#9966FF", "#FF9F40", "#66BB6A"
                                    ],
                                    data: values
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    },

                                }
                            }
                        });
                    })
                    .catch(error => console.log("Lỗi tải dữ liệu:", error));
            }

            drawPieChart();
        });
    </script>
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gauge-chart.js"></script>




    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function loadProductSalesChart() {
                axios.get("{{ route('admin.product.sales.category') }}")
                    .then(response => {
                        const ctx = document.getElementById("productSalesChart");
                        if (!ctx) return;

                        // Lấy danh mục sản phẩm
                        const categories = response.data.map(item => item.category);
                        // Lấy số lượng sản phẩm đã bán trong tháng hiện tại và tháng trước
                        const currentMonthSales = response.data.map(item => item.current_month_sales);
                        const previousMonthSales = response.data.map(item => item.previous_month_sales);

                        if (window.salesChart) {
                            window.salesChart.destroy();
                        }

                        window.salesChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: categories,
                                datasets: [{
                                        label: "Tháng này",
                                        backgroundColor: "rgba(75, 192, 192, 0.5)",
                                        borderColor: "rgba(75, 192, 192, 1)",
                                        data: currentMonthSales
                                    },
                                    {
                                        label: "Tháng trước",
                                        backgroundColor: "rgba(255, 99, 132, 0.5)",
                                        borderColor: "rgba(255, 99, 132, 1)",
                                        data: previousMonthSales
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        title: {
                                            display: true,
                                            text: "Số lượng sản phẩm"
                                        }
                                    },
                                    x: {
                                        title: {
                                            display: true,
                                            text: "Danh mục sản phẩm"
                                        }
                                    }
                                }
                            }
                        });
                    })
                    .catch(error => console.log("Lỗi tải dữ liệu:", error));
            }

            loadProductSalesChart();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/gauge-chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById("visitorChart").getContext("2d");
            const dataFilter = document.getElementById("dataFilter");
            let visitorChart;

            function fetchData(filterType) {
                axios.get("{{ route('admin.visitor.stats') }}")
                    .then(response => {
                        const data = response.data;
                        let labels = [];
                        let selectedData = [];
                        let titleText = "";

                        if (filterType === "daily") {
                            labels = data.daily_labels || []; // Hiển thị 7 ngày gần nhất
                            selectedData = data.daily || [];
                            titleText = "Thống kê lượt truy cập theo ngày (7 ngày gần nhất)";
                        } else if (filterType === "weekly") {
                            labels = data.weekly_labels || []; // Hiển thị khoảng thời gian tuần
                            selectedData = data.weekly || [];
                            titleText = "Thống kê lượt truy cập theo tuần";
                        }

                        // Xóa biểu đồ cũ nếu có
                        if (visitorChart) {
                            visitorChart.destroy();
                        }

                        // Vẽ biểu đồ mới
                        visitorChart = new Chart(ctx, {
                            type: "bar",
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: "Lượt truy cập",
                                    data: selectedData,
                                    backgroundColor: "rgba(54, 162, 235, 0.6)",
                                    borderColor: "rgba(54, 162, 235, 1)",
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    title: {
                                        display: true,
                                        text: titleText
                                    }
                                },
                                scales: {
                                    x: {
                                        title: {
                                            display: true,
                                            text: filterType === "daily" ? "Ngày" :
                                                "Khoảng thời gian tuần"
                                        }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: "Số lượt truy cập"
                                        }
                                    }
                                }
                            }
                        });
                    })
                    .catch(error => console.log("Lỗi tải dữ liệu:", error));
            }

            // Gọi API khi thay đổi dropdown
            dataFilter.addEventListener("change", function() {
                fetchData(this.value);
            });

            // Tải dữ liệu ban đầu
            fetchData("daily");
        });
    </script>
@endpush
