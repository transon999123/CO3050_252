<?php
require_once __DIR__ . '/../Core/AdminController.php';

class AdminNewsController extends AdminController {
    public function index() {
        $db = (new Database())->getConnection();
        $news = $db->query("SELECT news.*, users.full_name as author_name FROM news LEFT JOIN users ON news.author_id = users.id ORDER BY created_at DESC")->fetchAll();
        
        $this->renderAdmin('admin/news/index', [
            'page_title' => 'Quản Lý Tin Tức',
            'news' => $news
        ]);
    }

    public function delete() {
        $id = (int)($_GET['id'] ?? 0);
        $db = (new Database())->getConnection();
        $db->prepare("DELETE FROM news WHERE id = ?")->execute([$id]);
        $this->redirect('index.php?controller=adminNews&action=index');
    }

    public function create() {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $content = trim($_POST['content'] ?? '');
            $author_id = $_SESSION['user_id'];
            $image = 'default_news.jpg';

            if (empty($title)) $errors[] = 'Tiêu đề không được để trống';
            if (empty($content)) $errors[] = 'Nội dung không được để trống';

            // Upload ảnh (nếu có)
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../uploads/news/';
                if (!is_dir($uploadDir)) @mkdir($uploadDir, 0777, true);
                
                $filename = time() . '_' . rand(10,99) . '_' . basename($_FILES['image']['name']);
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $filename)) {
                    $image = $filename;
                }
            }

            if (empty($errors)) {
                $db = (new Database())->getConnection();
                // Bảng news có thể dùng cột 'thumbnail' thay vì 'image' (như tôi thấy ở index.php)
                $sql = "INSERT INTO news (title, content, thumbnail, author_id) VALUES (?, ?, ?, ?)";
                $stmt = $db->prepare($sql);
                if ($stmt->execute([$title, $content, $image, $author_id])) {
                    $this->redirect('index.php?controller=adminNews&action=index');
                } else {
                    $errors[] = 'Lỗi hệ thống, không thể lưu bài viết.';
                }
            }
        }

        $this->renderAdmin('admin/news/create', [
            'page_title' => 'Thêm Bài Viết Mới',
            'errors' => $errors,
            'old' => $_POST
        ]);
    }
}
