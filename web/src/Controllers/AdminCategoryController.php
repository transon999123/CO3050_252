<?php
// src/Controllers/AdminCategoryController.php
require_once __DIR__ . '/../Core/AdminController.php';

class AdminCategoryController extends AdminController {
    public function index() {
        $db = (new Database())->getConnection();
        $categories = $db->query("SELECT c.*, (SELECT COUNT(*) FROM products p WHERE p.category_id = c.id) as product_count FROM categories c ORDER BY c.id DESC")->fetchAll();
        
        $this->renderAdmin('admin/categories/index', [
            'page_title' => 'Quản Lý Danh Mục',
            'categories' => $categories
        ]);
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            if ($name) {
                $db = (new Database())->getConnection();
                $db->prepare("INSERT INTO categories (name) VALUES (?)")->execute([$name]);
            }
        }
        $this->redirect('index.php?controller=adminCategory&action=index');
    }
    
    public function edit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)$_POST['id'];
            $name = trim($_POST['name'] ?? '');
            if ($name) {
                $db = (new Database())->getConnection();
                $db->prepare("UPDATE categories SET name = ? WHERE id = ?")->execute([$name, $id]);
            }
        }
        $this->redirect('index.php?controller=adminCategory&action=index');
    }
    
    public function delete() {
        $id = (int)($_GET['id'] ?? 0);
        $db = (new Database())->getConnection();
        
        // Cần kiểm tra xem có sản phẩm thuộc danh mục này không
        $check = $db->prepare("SELECT COUNT(*) as count FROM products WHERE category_id = ?");
        $check->execute([$id]);
        if ($check->fetch()['count'] > 0) {
            echo "<script>alert('Không thể xóa danh mục đang có sản phẩm!'); window.location.href='index.php?controller=adminCategory&action=index';</script>";
            exit;
        }
        
        $db->prepare("DELETE FROM categories WHERE id = ?")->execute([$id]);
        $this->redirect('index.php?controller=adminCategory&action=index');
    }
}
