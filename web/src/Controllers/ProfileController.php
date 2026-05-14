<?php
// src/Controllers/ProfileController.php
require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Models/UserModel.php';
require_once __DIR__ . '/../Models/OrderModel.php';
require_once __DIR__ . '/../Models/ReviewModel.php';

class ProfileController extends Controller {
    private $userModel;
    private $orderModel;
    private $reviewModel;

    public function __construct() {
        $this->userModel = new UserModel();
        $this->orderModel = new OrderModel();
        $this->reviewModel = new ReviewModel();
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

        $orders = $this->orderModel->getOrdersByUserId($_SESSION['user_id']);

        $this->renderFrontend('profile/orders', [
            'page_title' => 'Lịch Sử Đơn Hàng',
            'orders' => $orders
        ]);
    }

    public function detail() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('index.php?controller=auth&action=login');
        }

        $orderId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $order = $this->orderModel->getOrderById($orderId, $_SESSION['user_id']);

        if (!$order) {
            die('<div class="container mt-5"><div class="alert alert-danger">Không tìm thấy đơn hàng hoặc bạn không có quyền truy cập.</div></div>');
        }

        $items = $this->orderModel->getOrderItems($orderId);
        $reviewedProductIds = $this->reviewModel->getReviewedProductIdsByOrder($_SESSION['user_id'], $orderId);

        $this->renderFrontend('profile/order_detail', [
            'page_title' => 'Chi Tiết Đơn Hàng #' . $order['id'],
            'order' => $order,
            'items' => $items,
            'reviewedProductIds' => $reviewedProductIds
        ]);
    }

    public function cancelOrder() {
        if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php');
        }

        $orderId = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;
        $this->orderModel->cancelOrder($orderId, $_SESSION['user_id']);
        $this->redirect('index.php?controller=profile&action=detail&id=' . $orderId);
    }

    public function confirmOrder() {
        if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php');
        }

        $orderId = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;
        $this->orderModel->confirmOrderReceived($orderId, $_SESSION['user_id']);
        $this->redirect('index.php?controller=profile&action=detail&id=' . $orderId);
    }

    public function submitReview() {
        if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php');
        }

        $orderId = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;
        $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
        $rating = isset($_POST['rating']) ? min(5, max(1, (int)$_POST['rating'])) : 5;
        $comment = trim($_POST['comment'] ?? '');

        if ($comment === '') {
            $this->redirect('index.php?controller=profile&action=detail&id=' . $orderId . '&msg=review_empty');
        }

        $imageName = null;
        if (isset($_FILES['review_image']) && $_FILES['review_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../uploads/reviews/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileType = strtolower(pathinfo($_FILES['review_image']['name'], PATHINFO_EXTENSION));
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($fileType, $allowedTypes)) {
                $imageName = time() . '_' . preg_replace('/[^a-zA-Z0-9-_\.]/', '_', basename($_FILES['review_image']['name']));
                move_uploaded_file($_FILES['review_image']['tmp_name'], $uploadDir . $imageName);
            }
        }

        $this->reviewModel->createReview($_SESSION['user_id'], $orderId, $productId, $rating, $comment, $imageName);
        $this->redirect('index.php?controller=profile&action=detail&id=' . $orderId . '&msg=review_sent');
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