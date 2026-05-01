<?php
// src/Core/Model.php

class Model {
    protected $db; // Lưu trữ đối tượng PDO

    public function __construct() {
        // Mỗi khi khởi tạo bất kỳ Model nào (như UserModel, ProductModel)
        // tự động kết nối DB qua PDO và lưu lại vào $this->db
        $database = new Database();
        $this->db = $database->getConnection();
    }
}
