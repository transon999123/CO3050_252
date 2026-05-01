<?php
// index.php
session_start(); // Khởi tạo session cho hệ thống Auth và Cart

// Nạp file kết nối cơ sở dữ liệu
require_once __DIR__ . '/config/db.php';

// Lấy thông tin Controller và Action từ URL
// URL dạng: index.php?controller=product&action=detail&id=1
$controllerName = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$actionName = isset($_GET['action']) ? $_GET['action'] : 'index';

// Chuẩn hóa tên class Controller (vd: adminProduct -> AdminProductController)
$controllerClass = ucfirst($controllerName) . 'Controller';

// Đường dẫn trỏ tới file Controller tương ứng
$controllerFile = __DIR__ . '/src/Controllers/' . $controllerClass . '.php';

// Kiểm tra xem file Controller có tồn tại không
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    
    // Kiểm tra xem class Controller có được định nghĩa bên trong file không
    if (class_exists($controllerClass)) {
        $controllerObj = new $controllerClass();
        
        // Kiểm tra xem method (action) có tồn tại trong class Controller không
        if (method_exists($controllerObj, $actionName)) {
            // Thực thi action
            $controllerObj->$actionName();
        } else {
            die("Lỗi 404: Không tìm thấy phương thức (Action) '{$actionName}' trong Controller '{$controllerClass}'.");
        }
    } else {
        die("Lỗi 404: Không tìm thấy lớp '{$controllerClass}' bên trong file.");
    }
} else {
    die("Lỗi 404: Không tìm thấy file Controller '{$controllerName}' tại hệ thống.");
}
