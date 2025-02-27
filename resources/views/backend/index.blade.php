@extends('backend.layouts.master')
@section('title',
    'Artisan
    || DASHBOARD')
@section('main-content')
    <div class="container-fluid">
        @include('backend.layouts.notification')
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>

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
                            <canvas id="myBarChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Biểu đồ số người đăng ký -->
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Số người đăng ký trong 7 ngày gần nhất</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="userRegistrationChart"></canvas>
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
            function loadBarChart() {
                axios.get("{{ route('product.order.income.all') }}") // Gọi API Laravel
                    .then(response => {
                        console.log(response.data); // Kiểm tra dữ liệu có đúng không trên console

                        const ctx = document.getElementById("myBarChart");
                        if (!ctx) return;

                        const months = Object.keys(response.data);
                        const revenues = Object.values(response.data);

                        // Kiểm tra dữ liệu có rỗng không
                        if (months.length === 0) {
                            console.log("Không có dữ liệu doanh thu");
                            return;
                        }

                        // Hủy biểu đồ cũ nếu có
                        if (window.barChart) {
                            window.barChart.destroy();
                        }

                        // Vẽ biểu đồ Bar Chart
                        window.barChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: months,
                                datasets: [{
                                    label: "Doanh thu",
                                    backgroundColor: "rgba(78, 115, 223, 0.5)",
                                    borderColor: "rgba(78, 115, 223, 1)",
                                    data: revenues,
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

            // Gọi biểu đồ cột doanh thu
            loadBarChart();

            // Tải Google Charts và gọi biểu đồ tròn
            google.charts.load('current', {
                'packages': ['corechart']
            });
            google.charts.setOnLoadCallback(drawPieChart);

            function drawPieChart() {
                var analytics = @json($users);

                // Kiểm tra nếu dữ liệu không hợp lệ
                if (!Array.isArray(analytics) || analytics.length === 0) {
                    console.log("Dữ liệu biểu đồ tròn không hợp lệ");
                    return;
                }

                var data = google.visualization.arrayToDataTable(analytics);

                var options = {
                    title: 'Tài khoản đăng ký trong 7 ngày gần đây',
                    is3D: true,
                    backgroundColor: 'transparent'
                };

                var chart = new google.visualization.PieChart(document.getElementById('pie_chart'));
                chart.draw(data, options);
            }
        });
        document.addEventListener("DOMContentLoaded", function() {
            function loadBarChart() {
                axios.get("{{ route('product.order.income.all') }}") // Gọi API Laravel
                    .then(response => {
                        console.log(response.data);

                        const ctx = document.getElementById("myBarChart");
                        if (!ctx) return;

                        const months = Object.keys(response.data);
                        const revenues = Object.values(response.data);

                        if (months.length === 0) {
                            console.log("Không có dữ liệu doanh thu");
                            return;
                        }

                        if (window.barChart) {
                            window.barChart.destroy();
                        }

                        window.barChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: months,
                                datasets: [{
                                    label: "Doanh thu",
                                    backgroundColor: "rgba(78, 115, 223, 0.5)",
                                    borderColor: "rgba(78, 115, 223, 1)",
                                    data: revenues,
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

            function loadUserRegistrationChart() {
                axios.get("{{ route('admin.user.registrations') }}")
                    .then(response => {
                        console.log(response.data);

                        const ctx = document.getElementById("userRegistrationChart");
                        if (!ctx) return;

                        const days = response.data.map(item => item[0]); // Lấy tên ngày
                        const counts = response.data.map(item => item[1]); // Lấy số lượng đăng ký

                        if (days.length === 0) {
                            console.log("Không có dữ liệu người đăng ký");
                            return;
                        }

                        if (window.userChart) {
                            window.userChart.destroy();
                        }

                        window.userChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: days,
                                datasets: [{
                                    label: "Số người đăng ký",
                                    backgroundColor: "rgba(54, 162, 235, 0.5)",
                                    borderColor: "rgba(54, 162, 235, 1)",
                                    data: counts,
                                }],
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false, // Cho phép tự điều chỉnh kích thước

                                scales: {
                                    y: {
                                        title: {
                                            display: true,
                                            text: "Số lượng đăng ký"
                                        }
                                    }
                                }
                            }
                        });
                    })
                    .catch(error => console.log("Lỗi tải dữ liệu:", error));
            }

            // Gọi cả hai biểu đồ
            loadBarChart();
            loadUserRegistrationChart();
        });

        google.charts.load('current', {
            'packages': ['corechart']
        });

        google.charts.setOnLoadCallback(drawBarChart);

        function drawBarChart() {
            axios.get("{{ route('admin.user.registrations') }}")
                .then(response => {
                    var data = google.visualization.arrayToDataTable(response.data);

                    var options = {
                        vAxis: {
                            title: 'Số lượng đăng ký'
                        },
                        legend: {
                            position: 'none'
                        },
                        colors: ['#4285F4'] // Màu cột
                    };

                    var chart = new google.visualization.ColumnChart(document.getElementById('bar_chart'));
                    chart.draw(data, options);
                })
                .catch(error => console.log(error));
        }
    </script>
@endpush
