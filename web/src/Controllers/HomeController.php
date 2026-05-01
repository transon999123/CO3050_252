<?php
// src/Controllers/HomeController.php
require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Models/ProductModel.php';

class HomeController extends Controller {
    public function index() {
        $productModel = new ProductModel();
        // Lấy 8 sản phẩm mới nhất để hiển thị ở trang chủ
        $latestProducts = $productModel->getProducts(8, 0, ""); 
        
        $this->renderFrontend('home/index', [
            'page_title' => 'Trang Chủ',
            'latestProducts' => $latestProducts
        ]);
    }
}
