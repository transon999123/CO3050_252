<?php
// src/Controllers/ProfileController.php
require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Models/UserModel.php';

class ProfileController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function index() {
        // Kiểm tra xem đã đăng nhập chưa
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('index.php?controller=auth&action=login');
        }

        $user = $this->userModel->getUserByUsername($_SESSION['username']);
        
        $this->renderFrontend('profile/index', [
            'page_title' => 'Trang Cá Nhân',
            'user' => $user
        ]);
    }

    // Hiển thị lịch sử đơn hàng
    public function orders() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('index.php?controller=auth&action=login');
        }

        require_once __DIR__ . '/../../config/db.php';
        $db = (new Database())->getConnection();
        
        $userId = $_SESSION['user_id'];
        $orders = $db->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
        $orders->execute([$userId]);
        $orders = $orders->fetchAll();

        $this->renderFrontend('profile/orders', [
            'page_title' => 'Lịch Sử Đơn Hàng',
            'orders' => $orders
        ]);
    }

    // Xử lý cập nhật thông tin
    public function update() {
        if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php');
        }

        $userId = $_SESSION['user_id'];
        $fullName = trim($_POST['full_name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $street = trim($_POST['street'] ?? '');
        $district = trim($_POST['district'] ?? '');
        $city = trim($_POST['city'] ?? '');
        $address = $street . ', ' . $district . ', ' . $city;

        if ($this->userModel->updateProfile($userId, $fullName, $phone, $address)) {
            $_SESSION['full_name'] = $fullName; // Cập nhật lại session
            $this->redirect('index.php?controller=profile&action=index&msg=success');
        } else {
            $this->redirect('index.php?controller=profile&action=index&msg=error');
        }
    }

    // Xử lý upload avatar (Lưu vào thư mục public/uploads/avatars)
    public function uploadAvatar() {
        if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php');
        }

        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../uploads/avatars/';
            
            // Tạo thư mục nếu chưa có
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = time() . '_' . basename($_FILES['avatar']['name']);
            $targetPath = $uploadDir . $fileName;

            // Kiểm tra file ảnh
            $fileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            
            if (in_array($fileType, $allowedTypes)) {
                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $targetPath)) {
                    $this->userModel->updateAvatar($_SESSION['user_id'], $fileName);
                    $this->redirect('index.php?controller=profile&action=index&msg=avatar_success');
                } else {
                    $this->redirect('index.php?controller=profile&action=index&msg=avatar_error');
                }
            } else {
                $this->redirect('index.php?controller=profile&action=index&msg=invalid_file');
            }
        }
        $this->redirect('index.php?controller=profile&action=index');
    }
    // Xử lý đổi mật khẩu
    public function changePassword() {
        if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php');
        }

        $userId = $_SESSION['user_id'];
        $oldPassword = $_POST['old_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if ($newPassword !== $confirmPassword) {
            $this->redirect('index.php?controller=profile&action=index&msg=pwd_mismatch');
            return;
        }

        $user = $this->userModel->getUserByUsername($_SESSION['username']);
        
        // Kiểm tra mật khẩu cũ
        if (password_verify($oldPassword, $user['password'])) {
            // Hash pass mới
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            if ($this->userModel->changePassword($userId, $hashedPassword)) {
                $this->redirect('index.php?controller=profile&action=index&msg=pwd_success');
            } else {
                $this->redirect('index.php?controller=profile&action=index&msg=pwd_error');
            }
        } else {
            $this->redirect('index.php?controller=profile&action=index&msg=pwd_wrong');
        }
    }
}
