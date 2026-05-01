<?php
// src/Controllers/ContactController.php
require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Models/ContactModel.php';

class ContactController extends Controller {
    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $subject = trim($_POST['subject'] ?? '');
            $message = trim($_POST['message'] ?? '');

            if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
                $contactModel = new ContactModel();
                if ($contactModel->saveContact($name, $email, $subject, $message)) {
                    $this->renderFrontend('contact/index', [
                        'page_title' => 'Liên Hệ',
                        'success' => 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất.'
                    ]);
                    return;
                }
            }
            $this->renderFrontend('contact/index', [
                'page_title' => 'Liên Hệ',
                'error' => 'Vui lòng điền đầy đủ thông tin.',
                'old' => $_POST
            ]);
            return;
        }

        $this->renderFrontend('contact/index', [
            'page_title' => 'Liên Hệ'
        ]);
    }
}
