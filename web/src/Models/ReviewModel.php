<?php
// src/Models/ReviewModel.php
require_once __DIR__ . '/../Core/Model.php';

class ReviewModel extends Model {
    public function getReviewedProductIdsByOrder($userId, $orderId) {
        $sql = "SELECT product_id FROM product_reviews WHERE user_id = :user_id AND order_id = :order_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId, ':order_id' => $orderId]);
        return array_column($stmt->fetchAll(), 'product_id');
    }

    public function hasReview($userId, $orderId, $productId) {
        $sql = "SELECT COUNT(*) as total FROM product_reviews WHERE user_id = :user_id AND order_id = :order_id AND product_id = :product_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId, ':order_id' => $orderId, ':product_id' => $productId]);
        return $stmt->fetch()['total'] > 0;
    }

    public function createReview($userId, $orderId, $productId, $rating, $comment, $image = null) {
        $sql = "INSERT INTO product_reviews (user_id, order_id, product_id, rating, comment, image) 
                VALUES (:user_id, :order_id, :product_id, :rating, :comment, :image)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':user_id' => $userId,
            ':order_id' => $orderId,
            ':product_id' => $productId,
            ':rating' => $rating,
            ':comment' => $comment,
            ':image' => $image
        ]);
    }
}
