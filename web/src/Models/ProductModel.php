<?php
// src/Models/ProductModel.php
require_once __DIR__ . '/../Core/Model.php';

class ProductModel extends Model {
    
    // Đếm tổng số sản phẩm (hỗ trợ phân trang và filter)
    public function countProducts($keyword = "", $categoryId = 0, $size = "", $minPrice = 0, $maxPrice = 0) {
        $sql = "SELECT COUNT(*) as total FROM products WHERE name LIKE :keyword";
        $params = [':keyword' => "%$keyword%"];

        if ($categoryId > 0) {
            $sql .= " AND category_id = :cat_id";
            $params[':cat_id'] = $categoryId;
        }
        if ($size !== "") {
            $sql .= " AND size = :size";
            $params[':size'] = $size;
        }
        if ($minPrice > 0) {
            $sql .= " AND price >= :min_price";
            $params[':min_price'] = $minPrice;
        }
        if ($maxPrice > 0) {
            $sql .= " AND price <= :max_price";
            $params[':max_price'] = $maxPrice;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch()['total'];
    }

    // Lấy danh sách sản phẩm có phân trang và filter
    public function getProducts($limit, $offset, $keyword = "", $categoryId = 0, $size = "", $minPrice = 0, $maxPrice = 0) {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id
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

        $sql .= " ORDER BY p.created_at DESC LIMIT :limit OFFSET :offset";
                
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
}
