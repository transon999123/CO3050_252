<?php
// src/Core/AdminController.php
require_once __DIR__ . '/Controller.php';

class AdminController extends Controller {
    public function __construct() {
        // Middleware bảo mật: Kiểm tra xem đã đăng nhập và có phải Admin không
        // Giả sử AuthController trước đó đã lưu $_SESSION['role']
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            // Không có quyền, đẩy về trang chủ hoặc trang đăng nhập
            $this->redirect('index.php?controller=auth&action=login');
        }
    }

    /**
     * Render giao diện cho các trang Admin
     * Thay vì dùng view() bình thường, ta dùng renderAdmin để bọc bên trong admin_layout
     */
    protected function renderAdmin($viewPath, $data = []) {
        extract($data);
        
        // Đường dẫn file view chứa nội dung chính (ví dụ: danh sách sản phẩm)
        $view_content = __DIR__ . '/../Views/' . $viewPath . '.php';
        
        // File layout chung chứa header, sidebar, footer
        $layout = __DIR__ . '/../Views/admin/layout/admin_layout.php';
        
        if (file_exists($layout) && file_exists($view_content)) {
            require_once $layout;
        } else {
            die("Lỗi 404: Không tìm thấy giao diện (Template) tại {$viewPath}.");
        }
    }
}