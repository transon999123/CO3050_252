<?php
require_once __DIR__ . '/../Core/AdminController.php';

class AdminDashboardController extends AdminController {
    public function index() {
        $db = (new Database())->getConnection();
        
        // Thống kê tổng quan
        $totalUsers = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
        $totalOrders = $db->query("SELECT COUNT(*) FROM orders")->fetchColumn();
        $totalProducts = $db->query("SELECT COUNT(*) FROM products")->fetchColumn();
        $totalRevenue = $db->query("SELECT SUM(total_price) FROM orders WHERE status = 'delivered'")->fetchColumn() ?: 0;
        
        // Thống kê cho biểu đồ theo tuần trong tháng hiện tại (4 tuần)
        $currentMonth = date('m');
        $currentYear = date('Y');
        
        $weekLabels = ['Tuần 1', 'Tuần 2', 'Tuần 3', 'Tuần 4'];
        $orderData = [0, 0, 0, 0];
        $revenueData = [0, 0, 0, 0];

        $sqlStats = "SELECT 
            DAY(created_at) as day, 
            COUNT(*) as total_orders, 
            SUM(total_price) as total_revenue, 
            status 
            FROM orders 
            WHERE MONTH(created_at) = :month AND YEAR(created_at) = :year 
            GROUP BY DAY(created_at), status";
            
        $stmt = $db->prepare($sqlStats);
        $stmt->execute([':month' => $currentMonth, ':year' => $currentYear]);
        $monthlyStats = $stmt->fetchAll();

        foreach($monthlyStats as $stat) {
            $day = (int)$stat['day'];
            if($day <= 7) $weekIdx = 0;
            elseif($day <= 14) $weekIdx = 1;
            elseif($day <= 21) $weekIdx = 2;
            else $weekIdx = 3;

            $orderData[$weekIdx] += $stat['total_orders'];
            
            if($stat['status'] !== 'cancelled') {
                $revenueData[$weekIdx] += (float)$stat['total_revenue'];
            }
        }

        $this->renderAdmin('admin/dashboard/index', [
            'page_title' => 'Dashboard Thống Kê',
            'stats' => [
                'users' => $totalUsers,
                'orders' => $totalOrders,
                'products' => $totalProducts,
                'revenue' => $totalRevenue
            ],
            'weekLabels' => json_encode($weekLabels),
            'orderData' => json_encode($orderData),
            'revenueData' => json_encode($revenueData)
        ]);
    }
}
