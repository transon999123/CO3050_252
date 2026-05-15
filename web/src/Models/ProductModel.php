<?php
// src/Models/ProductModel.php
require_once __DIR__ . '/../Core/Model.php';

class ProductModel extends Model {
    
    // Đếm tổng số sản phẩm (hỗ trợ phân trang và filter)
    public function countProducts($keyword = "", $categoryId = 0, $size = "", $minPrice = 0, $maxPrice = 0, $minRating = 0) {
        $sql = "SELECT COUNT(DISTINCT p.id) as total FROM products p 
                LEFT JOIN product_reviews pr ON p.id = pr.product_id
                WHERE p.name LIKE :keyword";
        $params = [':keyword' => "%$keyword%"];

        if ($categoryId > 0) {
            $sql .= " AND p.category_id = :cat_id";
            $params[':cat_id'] = $categoryId;
        }
        if ($size !== "") {
            $sql .= " AND p.size = :size";
            $params[':size'] = $size;
        }
        if ($minPrice > 0) {
            $sql .= " AND p.price >= :min_price";
            $params[':min_price'] = $minPrice;
        }
        if ($maxPrice > 0) {
            $sql .= " AND p.price <= :max_price";
            $params[':max_price'] = $maxPrice;
        }
        if ($minRating > 0) {
            $sql .= " AND (SELECT AVG(pr2.rating) FROM product_reviews pr2 WHERE pr2.product_id = p.id) >= :min_rating";
            $params[':min_rating'] = $minRating;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch()['total'];
    }

    // Lấy danh sách sản phẩm có phân trang và filter, hỗ trợ sort theo rating
    public function getProducts($limit, $offset, $keyword = "", $categoryId = 0, $size = "", $minPrice = 0, $maxPrice = 0, $minRating = 0, $sortBy = 'created_at', $sortOrder = 'DESC') {
        $sql = "SELECT p.*, c.name as category_name,
                COALESCE(AVG(pr.rating), 0) as avg_rating,
                COUNT(pr.id) as review_count
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN product_reviews pr ON p.id = pr.product_id
                WHERE p.name LIKE :keyword";
        
        $params = [];
        $params[':keyword'] = "%$keyword%";

        if ($categoryId > 0) {
            $sql .= " AND p.category_id = :cat_id";
            $params[':cat_id'] = $categoryId;
        }
        if ($size !== "") {
            $sql .= " AND p.size = :size";
            $params[':size'] = $size;
        }
        if ($minPrice > 0) {
            $sql .= " AND p.price >= :min_price";
            $params[':min_price'] = $minPrice;
        }
        if ($maxPrice > 0) {
            $sql .= " AND p.price <= :max_price";
            $params[':max_price'] = $maxPrice;
        }

        $sql .= " GROUP BY p.id, c.name";

        if ($minRating > 0) {
            $sql .= " HAVING avg_rating >= :min_rating";
            $params[':min_rating'] = $minRating;
        }

        // Sort theo rating hoặc các trường khác
        if ($sortBy === 'rating') {
            $sql .= " ORDER BY avg_rating $sortOrder, review_count $sortOrder";
        } else {
            $sql .= " ORDER BY p.$sortBy $sortOrder";
        }

        $sql .= " LIMIT :limit OFFSET :offset";
                
        $stmt = $this->db->prepare($sql);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        // Bind integer (rất quan trọng với LIMIT)
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Lấy danh sách tất cả Categories dùng cho dropdown form Thêm/Sửa
    public function getAllCategories() {
        $sql = "SELECT * FROM categories ORDER BY name ASC";
        return $this->db->query($sql)->fetchAll();
    }

    // Lấy 1 sản phẩm theo ID
    public function getProductById($id) {
        $sql = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Thêm sản phẩm mới
    public function createProduct($category_id, $name, $description, $price, $size, $stock, $image) {
        $sql = "INSERT INTO products (category_id, name, description, price, size, stock, image) 
                VALUES (:cat, :name, :desc, :price, :size, :stock, :img)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':cat' => $category_id,
            ':name' => $name,
            ':desc' => $description,
            ':price' => $price,
            ':size' => $size,
            ':stock' => $stock,
            ':img' => $image
        ]);
    }

    // Cập nhật sản phẩm
    public function updateProduct($id, $category_id, $name, $description, $price, $size, $stock, $image = null) {
        if ($image) {
            $sql = "UPDATE products SET category_id=:cat, name=:name, description=:desc, price=:price, size=:size, stock=:stock, image=:img WHERE id=:id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':cat' => $category_id, ':name' => $name, ':desc' => $description, 
                ':price' => $price, ':size' => $size, ':stock' => $stock, ':img' => $image, ':id' => $id
            ]);
        } else {
            $sql = "UPDATE products SET category_id=:cat, name=:name, description=:desc, price=:price, size=:size, stock=:stock WHERE id=:id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':cat' => $category_id, ':name' => $name, ':desc' => $description, 
                ':price' => $price, ':size' => $size, ':stock' => $stock, ':id' => $id
            ]);
        }
    }

    // Xóa sản phẩm
    public function deleteProduct($id) {
        $sql = "DELETE FROM products WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // Lấy reviews của sản phẩm
    public function getProductReviews($productId, $limit = 10, $offset = 0) {
        $sql = "SELECT pr.*, u.full_name as user_name, o.created_at as order_date
                FROM product_reviews pr
                LEFT JOIN users u ON pr.user_id = u.id
                LEFT JOIN orders o ON pr.order_id = o.id
                WHERE pr.product_id = :product_id
                ORDER BY pr.created_at DESC
                LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Đếm số reviews của sản phẩm
    public function countProductReviews($productId) {
        $sql = "SELECT COUNT(*) as total FROM product_reviews WHERE product_id = :product_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':product_id' => $productId]);
        return $stmt->fetch()['total'];
    }

    // Lấy rating trung bình của sản phẩm
    public function getProductAverageRating($productId) {
        $sql = "SELECT AVG(rating) as avg_rating, COUNT(*) as total_reviews FROM product_reviews WHERE product_id = :product_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':product_id' => $productId]);
        return $stmt->fetch();
    }
}
