<?php
// src/Models/UserModel.php
require_once __DIR__ . '/../Core/Model.php';

class UserModel extends Model {
    
    /**
     * Lấy dữ liệu user qua username
     */
    public function getUserByUsername($username) {
        $query = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        return $stmt->fetch(); // Trả về dạng array nếu tìm thấy, false nếu không thấy
    }

    /**
     * Lấy dữ liệu user qua email
     */
    public function getUserByEmail($email) {
        $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        return $stmt->fetch();
    }

    /**
     * Đăng ký người dùng mới
     */
    public function createUser($username, $email, $password, $fullName) {
        $query = "INSERT INTO users (username, email, password, full_name, role) 
                  VALUES (:username, :email, :password, :full_name, 'member')";
        
        $stmt = $this->db->prepare($query);
        
        // Mã hóa mật khẩu an toàn theo chuẩn bcrypt của PHP
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Gán tham số (bind param) để ngăn chặn SQL Injection
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':full_name', $fullName);
        
        return $stmt->execute();
    }

    /**
     * Cập nhật thông tin cá nhân
     */
    public function updateProfile($id, $fullName, $phone, $address) {
        $query = "UPDATE users SET full_name = :full_name, phone = :phone, address = :address WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':full_name' => $fullName,
            ':phone' => $phone,
            ':address' => $address,
            ':id' => $id
        ]);
    }

    /**
     * Cập nhật Avatar
     */
    public function updateAvatar($id, $avatarName) {
        $query = "UPDATE users SET avatar = :avatar WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':avatar' => $avatarName,
            ':id' => $id
        ]);
    }

    /**
     * Đổi mật khẩu
     */
    public function changePassword($id, $newPassword) {
        $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
        $query = "UPDATE users SET password = :password WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':password' => $hashed_password,
            ':id' => $id
        ]);
    }
}
