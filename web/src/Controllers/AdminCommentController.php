<?php
require_once __DIR__ . '/../Core/AdminController.php';

class AdminCommentController extends AdminController {
    public function index() {
        $db = (new Database())->getConnection();
        $sql = "SELECT comments.*, users.full_name, news.title as news_title 
                FROM comments 
                JOIN users ON comments.user_id = users.id 
                JOIN news ON comments.news_id = news.id 
                ORDER BY created_at DESC";
        $comments = $db->query($sql)->fetchAll();
        
        $this->renderAdmin('admin/comments/index', [
            'page_title' => 'Quản Lý Bình Luận',
            'comments' => $comments
        ]);
    }

    public function updateStatus() {
        $id = (int)($_GET['id'] ?? 0);
        $status = $_GET['status'] ?? 'approved';
        $db = (new Database())->getConnection();
        $db->prepare("UPDATE comments SET status = ? WHERE id = ?")->execute([$status, $id]);
        $this->redirect('index.php?controller=adminComment&action=index');
    }

    public function delete() {
        $id = (int)($_GET['id'] ?? 0);
        $db = (new Database())->getConnection();
        $db->prepare("DELETE FROM comments WHERE id = ?")->execute([$id]);
        $this->redirect('index.php?controller=adminComment&action=index');
    }
}
