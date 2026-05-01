<?php
// src/Models/OrderModel.php
require_once __DIR__ . '/../Core/Model.php';

class OrderModel extends Model {
    
    // Lưu Đơn hàng (Orders) và trả về ID đơn hàng vừa tạo
    public function createOrder($userId, $totalPrice, $address, $phone) {
        $sql = "INSERT INTO orders (user_id, total_price, shipping_address, shipping_phone, status) 
                VALUES (:user_id, :total, :address, :phone, 'pending')";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':user_id' => $userId,
            ':total' => $totalPrice,
            ':address' => $address,
            ':phone' => $phone
        ]);
        
        // PDO lastInsertId giúp lấy ra ID của record vừa INSERT xong
        return $this->db->lastInsertId();
    }

    // Lưu Chi tiết Đơn hàng (Order Items)
    public function createOrderItem($orderId, $productId, $qty, $price) {
        $sql = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                VALUES (:order_id, :product_id, :qty, :price)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':order_id' => $orderId,
            ':product_id' => $productId,
            ':qty' => $qty,
            ':price' => $price
        ]);
    }
}
