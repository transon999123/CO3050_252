<?php
require_once __DIR__ . '/../Core/AdminController.php';

class AdminContactController extends AdminController {
    public function index() {
        $db = (new Database())->getConnection();
        $sql = "SELECT * FROM contacts ORDER BY created_at DESC";
        $contacts = $db->query($sql)->fetchAll();

        $this->renderAdmin('admin/contacts/index', [
            'page_title' => 'Quản lý Liên Hệ / Phản Hồi',
            'contacts' => $contacts
        ]);
    }

    public function updateStatus() {
        $id = (int)($_GET['id'] ?? 0);
        $status = $_GET['status'] ?? 'unread'; // unread, read, replied
        $db = (new Database())->getConnection();
        $stmt = $db->prepare("UPDATE contacts SET status = :status WHERE id = :id");
        $stmt->execute([':status' => $status, ':id' => $id]);
        $this->redirect('index.php?controller=adminContact&action=index');
    }

    public function delete() {
        $id = (int)($_GET['id'] ?? 0);
        $db = (new Database())->getConnection();
        $stmt = $db->prepare("DELETE FROM contacts WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $this->redirect('index.php?controller=adminContact&action=index');
    }
}
