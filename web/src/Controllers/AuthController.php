<?php
// src/Controllers/AuthController.php
require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Models/UserModel.php';

class AuthController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    /**
     * Đăng nhập
     * URL: index.php?controller=auth&action=login
     */
    public function login() {
        // Nếu user nộp form bằng POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            
            // Tìm user từ cơ sở dữ liệu
            $user = $this->userModel->getUserByUsername($username);
            
            // Dùng password_verify để kiểm tra mật khẩu gõ vào với hash lưu trong DB
            if ($user) {
                // Kiểm tra trạng thái bị khóa
                if (isset($user['status']) && $user['status'] === 'banned') {
                    $error = "Tài khoản của bạn đã bị khóa. Vui lòng liên hệ Admin.";
                    $this->renderFrontend('auth/login', ['error' => $error, 'username' => $username, 'page_title' => 'Đăng nhập']);
                } else if (password_verify($password, $user['password'])) {
                    // Đăng nhập thành công -> Lưu dữ liệu lên Session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['full_name'] = $user['full_name'];
                    
                    // Chuyển hướng sang trang chủ (tạo sẵn action tương ứng hoặc đổi path sau)
                    $this->redirect('index.php?controller=home&action=index');
                } else {
                    // Đăng nhập thất bại
                    $error = "Tên đăng nhập hoặc mật khẩu không chính xác.";
                    $this->renderFrontend('auth/login', ['error' => $error, 'username' => $username, 'page_title' => 'Đăng nhập']);
                }
            } else {
                // Đăng nhập thất bại
                $error = "Tên đăng nhập hoặc mật khẩu không chính xác.";
                $this->renderFrontend('auth/login', ['error' => $error, 'username' => $username, 'page_title' => 'Đăng nhập']);
            }
        } else {
            // Mở trang đăng nhập GET
            $this->renderFrontend('auth/login', ['page_title' => 'Đăng nhập']);
        }
    }

    /**
     * Đăng ký
     * URL: index.php?controller=auth&action=register
     */
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $password_confirm = $_POST['password_confirm'] ?? '';
            $fullName = trim($_POST['full_name'] ?? '');
            
            $errors = [];
            
            // Validate dữ liệu trống
            if (empty($username) || empty($password) || empty($email) || empty($fullName)) {
                $errors[] = "Vui lòng nhập đầy đủ thông tin.";
            } else {
                if ($password !== $password_confirm) {
                    $errors[] = "Mật khẩu nhập lại không khớp.";
                }
                // Validate trùng lặp
                if ($this->userModel->getUserByUsername($username)) {
                    $errors[] = "Tên đăng nhập đã tồn tại.";
                }
                if ($this->userModel->getUserByEmail($email)) {
                    $errors[] = "Email này đã được sử dụng.";
                }
            }

            if (empty($errors)) {
                // Tạo user mới
                if ($this->userModel->createUser($username, $email, $password, $fullName)) {
                    // Thành công, điều hướng quay lại login với param success
                    $this->redirect('index.php?controller=auth&action=login&success=1');
                } else {
                    $errors[] = "Có lỗi xảy ra trong quá trình đăng ký, vui lòng thử lại sau.";
                    $this->renderFrontend('auth/register', ['errors' => $errors, 'old' => $_POST, 'page_title' => 'Đăng ký']);
                }
            } else {
                // Lỗi validate
                $this->renderFrontend('auth/register', ['errors' => $errors, 'old' => $_POST, 'page_title' => 'Đăng ký']);
            }
        } else {
            // Mở trang đăng ký GET
            $this->renderFrontend('auth/register', ['page_title' => 'Đăng ký']);
        }
    }

    /**
     * Đăng xuất
     * URL: index.php?controller=auth&action=logout
     */
    public function logout() {
        // Xóa sạch session
        session_unset();
        session_destroy();
        
        // Trở về trang đăng nhập
        $this->redirect('index.php?controller=auth&action=login');
    }
}
