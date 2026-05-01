<?php
// src/Controllers/ProductController.php
require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Models/ProductModel.php';

class ProductController extends Controller {
    private $productModel;

    public function __construct() {
        $this->productModel = new ProductModel();
    }

    // Danh sách sản phẩm (Frontend)
    public function index() {
        $keyword = $_GET['keyword'] ?? '';
        $categoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
        $size = $_GET['size'] ?? '';
        $minPrice = isset($_GET['min_price']) ? (int)$_GET['min_price'] : 0;
        $maxPrice = isset($_GET['max_price']) ? (int)$_GET['max_price'] : 0;
        
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 12; // Hiển thị 12 sản phẩm trên 1 trang
        
        $totalItems = $this->productModel->countProducts($keyword, $categoryId, $size, $minPrice, $maxPrice);
        $totalPages = ceil($totalItems / $limit);
        
        if ($page < 1) $page = 1;
        if ($page > $totalPages && $totalPages > 0) $page = $totalPages;
        
        $offset = ($page - 1) * $limit;
        $products = $this->productModel->getProducts($limit, $offset, $keyword, $categoryId, $size, $minPrice, $maxPrice);
        
        $categories = $this->productModel->getAllCategories();

        $this->renderFrontend('product/index', [
            'page_title' => 'Cửa Hàng Quần Áo',
            'products' => $products,
            'categories' => $categories,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'keyword' => $keyword,
            'categoryId' => $categoryId,
            'size' => $size,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice
        ]);
    }

    // Chi tiết 1 sản phẩm
    public function detail() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $product = $this->productModel->getProductById($id);
        
        if(!$product) {
            die("<h3 style='text-align:center; margin-top:50px;'>Lỗi 404: Không tìm thấy sản phẩm!</h3>");
        }

        $this->renderFrontend('product/detail', [
            'page_title' => $product['name'],
            'product' => $product
        ]);
    }
}
