<?php
// src/Models/ContactModel.php
require_once __DIR__ . '/../Core/Model.php';

class ContactModel extends Model {
    public function saveContact($name, $email, $subject, $message) {
        $sql = "INSERT INTO contacts (name, email, subject, message, status) VALUES (:name, :email, :subject, :message, 'unread')";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':subject' => $subject,
            ':message' => $message
        ]);
    }
}
