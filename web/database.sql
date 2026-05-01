-- Tạo database nếu chưa có và sử dụng database đó
CREATE DATABASE IF NOT EXISTS `new_cloth_web` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `new_cloth_web`;

SET FOREIGN_KEY_CHECKS = 0; -- Tạm thời tắt kiểm tra khóa ngoại để tránh lỗi khi DROP hoặc INSERT

-- ==============================================
-- BẢNG 1: users
-- Lưu thông tin người dùng (admin, member)
-- ==============================================
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL COMMENT 'Hashed password',
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `full_name` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(20),
  `address` TEXT,
  `role` ENUM('admin', 'member') DEFAULT 'member',
  `avatar` VARCHAR(255) DEFAULT 'default_avatar.jpg',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ==============================================
-- BẢNG 2: categories
-- Danh mục sản phẩm (Áo thun, Quần jean...)
-- ==============================================
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `description` TEXT
) ENGINE=InnoDB;

-- ==============================================
-- BẢNG 3: products
-- Sản phẩm
-- ==============================================
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `category_id` INT NOT NULL,
  `name` VARCHAR(200) NOT NULL,
  `description` TEXT,
  `price` DECIMAL(10,2) NOT NULL,
  `size` VARCHAR(50) DEFAULT 'M',
  `stock` INT DEFAULT 0,
  `image` VARCHAR(255) DEFAULT 'default_product.jpg',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ==============================================
-- BẢNG 4: orders
-- Thông tin đơn hàng (giỏ hàng đã thanh toán/đặt hàng)
-- ==============================================
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `total_price` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `status` ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
  `shipping_address` TEXT NOT NULL,
  `shipping_phone` VARCHAR(20) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ==============================================
-- BẢNG 4.1: order_items
-- Chi tiết từng sản phẩm trong đơn hàng
-- ==============================================
DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `order_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `quantity` INT NOT NULL DEFAULT 1,
  `price` DECIMAL(10,2) NOT NULL COMMENT 'Giá sản phẩm tại thời điểm mua',
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ==============================================
-- BẢNG 5: news
-- Tin tức / Blog
-- ==============================================
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `content` TEXT NOT NULL,
  `author_id` INT,
  `thumbnail` VARCHAR(255) DEFAULT 'default_news.jpg',
  `views` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`author_id`) REFERENCES `users`(`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ==============================================
-- BẢNG 6: comments
-- Bình luận trên bài viết tin tức
-- ==============================================
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `news_id` INT NOT NULL,
  `content` TEXT NOT NULL,
  `status` ENUM('approved', 'pending', 'spam') DEFAULT 'pending',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`news_id`) REFERENCES `news`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ==============================================
-- BẢNG 7: contacts
-- Thông tin liên hệ từ khách hàng
-- ==============================================
DROP TABLE IF EXISTS `contacts`;
CREATE TABLE `contacts` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `subject` VARCHAR(255) NOT NULL,
  `message` TEXT NOT NULL,
  `status` ENUM('unread', 'read', 'replied') DEFAULT 'unread',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ==============================================
-- BẢNG 8: faqs
-- Câu hỏi thường gặp
-- ==============================================
DROP TABLE IF EXISTS `faqs`;
CREATE TABLE `faqs` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `question` TEXT NOT NULL,
  `answer` TEXT NOT NULL
) ENGINE=InnoDB;

SET FOREIGN_KEY_CHECKS = 1; -- Bật lại kiểm tra khóa ngoại


-- ==============================================
-- DỮ LIỆU MẪU (DUMMY DATA)
-- ==============================================

-- 1. Thêm users (Sử dụng bcrypt password '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' đại diện cho chữ 'password')
INSERT INTO `users` (`username`, `password`, `email`, `full_name`, `phone`, `address`, `role`) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@example.com', 'Quản Trị Viên', '0901234567', 'TP.HCM', 'admin'),
('member1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'member1@example.com', 'Nguyễn Văn A', '0987654321', 'Hà Nội', 'member'),
('member2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'member2@example.com', 'Trần Thị B', '0912345678', 'Đà Nẵng', 'member');

-- 2. Thêm categories
INSERT INTO `categories` (`name`, `description`) VALUES
('Áo thun', 'Các loại áo thun nam nữ form rộng, ôm...'),
('Quần Jean', 'Quần Jean cao cấp, ống loe, ống rộng...'),
('Áo Khoác', 'Áo khoác dù, áo khoác kaki chống nắng');

-- 3. Thêm products
INSERT INTO `products` (`category_id`, `name`, `description`, `price`, `stock`, `image`) VALUES
(1, 'Áo thun Basic Nam', 'Áo thun cotton 100% thấm hút mồ hôi tốt', 150000.00, 100, 'ao_thun_1.jpg'),
(1, 'Áo thun Nữ tay dài', 'Áo thun nữ dạo phố', 180000.00, 50, 'ao_thun_2.jpg'),
(2, 'Quần Jean Nam rách gối', 'Quần Jean phong cách bụi bặm', 350000.00, 30, 'quan_jean_1.jpg'),
(3, 'Áo khoác dù Unisex', 'Áo khoác dù form rộng, nhẹ nhàng', 250000.00, 40, 'ao_khoac_1.jpg');

-- 4. Thêm orders
INSERT INTO `orders` (`user_id`, `total_price`, `status`, `shipping_address`, `shipping_phone`) VALUES
(2, 500000.00, 'pending', 'Số 1, Lê Duẩn, Hà Nội', '0987654321'),
(3, 250000.00, 'shipped', 'Quận Hải Châu, Đà Nẵng', '0912345678');

-- 4.1 Thêm order_items
INSERT INTO `order_items` (`order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 1, 150000.00),
(1, 3, 1, 350000.00),
(2, 4, 1, 250000.00);

-- 5. Thêm news
INSERT INTO `news` (`title`, `content`, `author_id`, `views`) VALUES
('Xu hướng thời trang 2026', 'Nội dung bài viết về xu hướng thời trang...', 1, 150),
('Cách phối đồ với quần Jean', 'Những tip phối đồ cực xịn xò...', 1, 300);

-- 6. Thêm comments
INSERT INTO `comments` (`user_id`, `news_id`, `content`, `status`) VALUES
(2, 1, 'Bài viết rất hữu ích, cảm ơn ad!', 'approved'),
(3, 2, 'Mình sẽ thử cách này!', 'approved');

-- 7. Thêm contacts
INSERT INTO `contacts` (`name`, `email`, `subject`, `message`, `status`) VALUES
('Lê Văn C', 'levanc@example.com', 'Hỏi về size áo', 'Cho mình hỏi áo thun Basic Nam size L còn hàng không?', 'unread');

-- 8. Thêm faqs
INSERT INTO `faqs` (`question`, `answer`) VALUES
('Shop có ship COD không?', 'Chào bạn, shop hỗ trợ giao hàng và thu tiền tận nơi (COD) trên toàn quốc nhé.'),
('Thời gian đổi trả là bao lâu?', 'Bạn có thể đổi trả sản phẩm trong vòng 7 ngày kể từ khi nhận hàng, với điều kiện sản phẩm còn nguyên tem mác.');
