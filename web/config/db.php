<?php
// config/db.php

class Database {
    private $host = "localhost";
    private $db_name = "new_cloth_web";
    private $username = "root"; // Thay bằng username MySQL của bạn
    private $password = "";     // Thay bằng mật khẩu MySQL của bạn
    public $conn;

    /**
     * Tạo và trả về đối tượng kết nối PDO
     * @return PDO|null
     */
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4", $this->username, $this->password);
            // Thiết lập chế độ báo lỗi exception để dễ dàng debug
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Trả kết quả về dạng mảng liên hợp mặc định
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $exception) {
            die("Lỗi kết nối CSDL: " . $exception->getMessage());
        }

        return $this->conn;
    }
}
