<?php
require_once __DIR__ . '/../Core/AdminController.php';

class AdminUserController extends AdminController {
    public function __construct() {
        parent::__construct();
        // Đảm bảo cột status tồn tại
        try {
            $db = (new Database())->getConnection();
            $db->exec("ALTER TABLE users ADD COLUMN status ENUM('active', 'banned') DEFAULT 'active'");
        } catch (\PDOException $e) {
            // Đã tồn tại, bỏ qua
        }
    }

    public function index() {
        $db = (new Database())->getConnection();
        $sql = "SELECT * FROM users ORDER BY role ASC, created_at DESC";
        $users = $db->query($sql)->fetchAll();

        $this->renderAdmin('admin/users/index', [
            'page_title' => 'Quản Lý Thành Viên',
            'users' => $users
        ]);
    }

    public function ban() {
        $id = (int)($_GET['id'] ?? 0);
        $action = $_GET['type'] ?? 'ban'; // ban hoặc unban
        $status = ($action === 'ban') ? 'banned' : 'active';
        
        if ($id && $id !== $_SESSION['user_id']) {
            $db = (new Database())->getConnection();
            $sql = "UPDATE users SET status = :status WHERE id = :id AND role != 'admin'";
            $stmt = $db->prepare($sql);
            $stmt->execute([':status' => $status, ':id' => $id]);
        }
        $this->redirect('index.php?controller=adminUser&action=index');
    }

    public function delete() {
        $id = (int)($_GET['id'] ?? 0);
        // Không cho phép xóa chính mình hoặc admin gốc
        if ($id && $id !== $_SESSION['user_id']) {
            $db = (new Database())->getConnection();
            $sql = "DELETE FROM users WHERE id = :id AND role != 'admin'";
            $stmt = $db->prepare($sql);
            $stmt->execute([':id' => $id]);
        }
        $this->redirect('index.php?controller=adminUser&action=index');
    }

    public function setRole() {
        $id = (int)($_GET['id'] ?? 0);
        $role = $_GET['role'] ?? 'member'; // admin hoặc member
        
        // Không cho đổi quyền của chính mình
        if ($id && $id !== $_SESSION['user_id']) {
            $db = (new Database())->getConnection();
            $sql = "UPDATE users SET role = :role WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->execute([':role' => $role, ':id' => $id]);
        }
        $this->redirect('index.php?controller=adminUser&action=index');
    }
}
