<?php
require_once __DIR__ . '/../Core/AdminController.php';

class AdminOrderController extends AdminController {
    public function index() {
        $db = (new Database())->getConnection();
        // Lấy danh sách đơn hàng kèm tên người mua
        $sql = "SELECT o.*, u.full_name as user_name FROM orders o LEFT JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC";
        $orders = $db->query($sql)->fetchAll();

        $this->renderAdmin('admin/orders/index', [
            'page_title' => 'Quản lý Đơn Hàng',
            'orders' => $orders
        ]);
    }

    public function detail() {
        $id = (int)($_GET['id'] ?? 0);
        $db = (new Database())->getConnection();
        
        // Lấy thông tin chung của đơn hàng
        $sqlOrder = "SELECT o.*, u.full_name, u.email FROM orders o LEFT JOIN users u ON o.user_id = u.id WHERE o.id = :id";
        $stmtOrder = $db->prepare($sqlOrder);
        $stmtOrder->execute([':id' => $id]);
        $order = $stmtOrder->fetch();

        // Lấy chi tiết các sản phẩm trong đơn
        $sqlItems = "SELECT oi.*, p.name as product_name, p.image FROM order_items oi LEFT JOIN products p ON oi.product_id = p.id WHERE oi.order_id = :order_id";
        $stmtItems = $db->prepare($sqlItems);
        $stmtItems->execute([':order_id' => $id]);
        $items = $stmtItems->fetchAll();

        if (!$order) {
            die("Không tìm thấy đơn hàng.");
        }

        $this->renderAdmin('admin/orders/detail', [
            'page_title' => 'Chi Tiết Đơn Hàng #' . $order['id'],
            'order' => $order,
            'items' => $items
        ]);
    }

    public function updateStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['order_id'] ?? 0);
            $status = $_POST['status'] ?? 'pending';
            $db = (new Database())->getConnection();
            $stmt = $db->prepare("UPDATE orders SET status = :status WHERE id = :id");
            $stmt->execute([':status' => $status, ':id' => $id]);
        }
        $this->redirect('index.php?controller=adminOrder&action=index');
    }
}
