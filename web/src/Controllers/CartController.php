<?php
// src/Controllers/CartController.php
require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Models/ProductModel.php';
require_once __DIR__ . '/../Models/OrderModel.php';

class CartController extends Controller {
    public function __construct() {
        if(!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    // Hiển thị giỏ hàng
    public function index() {
        $this->renderFrontend('cart/index', [
            'page_title' => 'Giỏ Hàng Của Bạn'
        ]);
    }

    // Thêm sản phẩm vào giỏ
    public function add() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = (int)($_POST['product_id'] ?? 0);
            $qty = (int)($_POST['quantity'] ?? 1);

            $productModel = new ProductModel();
            $product = $productModel->getProductById($productId);

            if($product && $qty > 0) {
                // Nếu sản phẩm đã có trong giỏ, tăng số lượng
                if(isset($_SESSION['cart'][$productId])) {
                    $_SESSION['cart'][$productId]['qty'] += $qty;
                } else {
                    // Nếu chưa có, tạo mới phần tử trong mảng session
                    $_SESSION['cart'][$productId] = [
                        'id' => $product['id'],
                        'name' => $product['name'],
                        'price' => $product['price'],
                        'image' => $product['image'],
                        'qty' => $qty
                    ];
                }
            }
        }
        $this->redirect('index.php?controller=cart&action=index');
    }

    // Xóa 1 sản phẩm khỏi giỏ
    public function remove() {
        $productId = (int)($_GET['id'] ?? 0);
        if(isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }
        $this->redirect('index.php?controller=cart&action=index');
    }

    // Cập nhật toàn bộ số lượng trong giỏ
    public function update() {
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['qty'])) {
            foreach($_POST['qty'] as $id => $qty) {
                if(isset($_SESSION['cart'][$id]) && $qty > 0) {
                    $_SESSION['cart'][$id]['qty'] = (int)$qty;
                }
            }
        }
        $this->redirect('index.php?controller=cart&action=index');
    }

    // Xử lý Thanh Toán / Đặt Hàng
    public function checkout() {
        // Bắt buộc đăng nhập
        if(!isset($_SESSION['user_id'])) {
            $this->redirect('index.php?controller=auth&action=login');
        }

        if(empty($_SESSION['cart'])) {
            $this->redirect('index.php?controller=product&action=index');
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $street = trim($_POST['street'] ?? '');
            $district = trim($_POST['district'] ?? '');
            $city = trim($_POST['city'] ?? '');
            $address = $street . ', ' . $district . ', ' . $city;
            $phone = trim($_POST['shipping_phone'] ?? '');

            if(!empty($street) && !empty($phone)) {
                $orderModel = new OrderModel();
                
                // Tính tổng tiền
                $totalPrice = 0;
                foreach($_SESSION['cart'] as $item) {
                    $totalPrice += $item['price'] * $item['qty'];
                }

                // Lưu Order
                $orderId = $orderModel->createOrder($_SESSION['user_id'], $totalPrice, $address, $phone);
                
                if($orderId) {
                    // Lưu Order Items
                    foreach($_SESSION['cart'] as $item) {
                        $orderModel->createOrderItem($orderId, $item['id'], $item['qty'], $item['price']);
                    }
                    
                    // Xóa giỏ hàng sau khi mua thành công
                    $_SESSION['cart'] = []; 
                    
                    // Xóa cart thành công, in script alert và redirect
                    die("<script>alert('Chúc mừng! Đặt hàng thành công!'); window.location.href='index.php';</script>");
                }
            }
        }
    }
}
