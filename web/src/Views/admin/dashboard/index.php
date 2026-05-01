<div class="row">
    <!-- Thẻ thống kê 1 -->
    <div class="col-xl-3 col-md-6 mt-4">
        <div class="card bg-primary text-white shadow h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="font-weight-bold mb-0">Thành Viên</h4>
                    <i class="fa fa-users fa-2x opacity-50"></i>
                </div>
                <h2 class="font-weight-bold"><?= number_format($stats['users']) ?></h2>
                <p class="mb-0 text-white-50">Tổng số tài khoản</p>
            </div>
        </div>
    </div>

    <!-- Thẻ thống kê 2 -->
    <div class="col-xl-3 col-md-6 mt-4">
        <div class="card bg-success text-white shadow h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="font-weight-bold mb-0">Đơn Hàng</h4>
                    <i class="fa fa-shopping-cart fa-2x opacity-50"></i>
                </div>
                <h2 class="font-weight-bold"><?= number_format($stats['orders']) ?></h2>
                <p class="mb-0 text-white-50">Tổng số giao dịch</p>
            </div>
        </div>
    </div>

    <!-- Thẻ thống kê 3 -->
    <div class="col-xl-3 col-md-6 mt-4">
        <div class="card bg-warning text-white shadow h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="font-weight-bold mb-0">Sản Phẩm</h4>
                    <i class="fa fa-box fa-2x opacity-50"></i>
                </div>
                <h2 class="font-weight-bold"><?= number_format($stats['products']) ?></h2>
                <p class="mb-0 text-white-50">Mặt hàng đang bán</p>
            </div>
        </div>
    </div>

    <!-- Thẻ thống kê 4 -->
    <div class="col-xl-3 col-md-6 mt-4">
        <div class="card bg-danger text-white shadow h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="font-weight-bold mb-0">Doanh Thu</h4>
                    <i class="fa fa-chart-line fa-2x opacity-50"></i>
                </div>
                <h2 class="font-weight-bold"><?= number_format($stats['revenue'], 0, ',', '.') ?>đ</h2>
                <p class="mb-0 text-white-50">Từ đơn hàng thành công</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5 mb-5">
    <!-- Biểu đồ Đơn hàng -->
    <div class="col-lg-6 mt-4">
        <div class="card shadow border-0">
            <div class="card-body">
                <h4 class="header-title border-bottom pb-2">Số lượng đơn hàng theo tuần (Tháng <?= date('m/Y') ?>)</h4>
                <canvas id="ordersChart" height="200"></canvas>
            </div>
        </div>
    </div>
    <!-- Biểu đồ Doanh thu -->
    <div class="col-lg-6 mt-4">
        <div class="card shadow border-0">
            <div class="card-body">
                <h4 class="header-title border-bottom pb-2">Doanh thu theo tuần (Tháng <?= date('m/Y') ?>)</h4>
                <canvas id="revenueChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Tải thư viện Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const labels = <?= $weekLabels ?>;
        const orderData = <?= $orderData ?>;
        const revenueData = <?= $revenueData ?>;

        // Cấu hình Biểu đồ Đơn hàng (Bar Chart)
        const ctxOrder = document.getElementById('ordersChart').getContext('2d');
        new Chart(ctxOrder, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Số đơn hàng',
                    data: orderData,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });

        // Cấu hình Biểu đồ Doanh thu (Line Chart)
        const ctxRev = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctxRev, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: revenueData,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                scales: { y: { beginAtZero: true } }
            }
        });
    });
</script>
