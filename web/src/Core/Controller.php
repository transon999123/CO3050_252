<?php
// src/Core/Controller.php

class Controller {
    /**
     * Render giao diện (View) và truyền dữ liệu cho View
     * 
     * @param string $viewPath Đường dẫn tương đối của view (ví dụ: 'auth/login')
     * @param array $data Mảng dữ liệu truyền sang View (ví dụ: ['title' => 'Login'])
     */
    protected function view($viewPath, $data = []) {
        // Chuyển key của mảng thành biến độc lập (vd: $data['title'] sẽ trở thành biến $title)
        extract($data);
        
        // File view phải nằm trong thư mục src/Views/
        $file = __DIR__ . '/../Views/' . $viewPath . '.php';
        
        if (file_exists($file)) {
            require_once $file;
        } else {
            die("Lỗi: Không tìm thấy file view tại đường dẫn 'src/Views/{$viewPath}.php'.");
        }
    }
    
    /**
     * Render giao diện cho Frontend (dùng chung main_layout)
     */
    protected function renderFrontend($viewPath, $data = []) {
        extract($data);
        $view_content = __DIR__ . '/../Views/' . $viewPath . '.php';
        $layout = __DIR__ . '/../Views/layout/main_layout.php';
        
        if (file_exists($layout) && file_exists($view_content)) {
            require_once $layout;
        } else {
            die("Lỗi: Không tìm thấy file giao diện {$viewPath} hoặc main_layout.php.");
        }
    }
    
    /**
     * Chuyển hướng người dùng (Redirect)
     * 
     * @param string $url Đường dẫn đích đến (ví dụ: 'index.php?controller=auth&action=login')
     */
    protected function redirect($url) {
        header("Location: " . $url);
        exit;
    }
}
