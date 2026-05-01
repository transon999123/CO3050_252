<?php
require_once __DIR__ . '/../Core/AdminController.php';

class AdminSettingController extends AdminController {
    public function index() {
        $configFile = __DIR__ . '/../../config/settings.json';
        
        // Đọc cài đặt hoặc tạo mặc định nếu chưa có
        $settings = file_exists($configFile) ? json_decode(file_get_contents($configFile), true) : [
            'site_name' => 'Fashion Store',
            'phone' => '0123.456.789',
            'email' => 'cskh@fashionstore.com',
            'address' => 'Đại học Bách Khoa TP.HCM',
            'about_text' => 'Website thương mại điện tử chuyên cung cấp các mặt hàng thời trang nam nữ cao cấp, mang lại phong cách hiện đại và trẻ trung.'
        ];

        // Xử lý Form Lưu Cài Đặt
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $settings['site_name'] = $_POST['site_name'] ?? '';
            $settings['phone'] = $_POST['phone'] ?? '';
            $settings['email'] = $_POST['email'] ?? '';
            $settings['address'] = $_POST['address'] ?? '';
            $settings['about_text'] = $_POST['about_text'] ?? '';
            
            // Xử lý upload logo (nếu có)
            if (!empty($_FILES['logo']['name'])) {
                // Bạn có thể xử lý lưu file ảnh logo vào public/assets/images/logo.png tại đây
                // Giả lập lưu tên file:
                // $settings['logo'] = $_FILES['logo']['name'];
            }

            // Ghi đè vào file json
            file_put_contents($configFile, json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            $this->redirect('index.php?controller=adminSetting&action=index&msg=success');
        }

        $this->renderAdmin('admin/settings/index', [
            'page_title' => 'Cài Đặt Thông Tin Website',
            'settings' => $settings
        ]);
    }
}
