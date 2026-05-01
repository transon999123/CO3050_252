<?php
// src/Controllers/AdminProductController.php
require_once __DIR__ . '/../Core/AdminController.php';
require_once __DIR__ . '/../Models/ProductModel.php';

class AdminProductController extends AdminController {
    private $productModel;

    public function __construct() {
        parent::__construct(); // Kiểm tra Admin Middleware
        $this->productModel = new ProductModel();
    }

    // Danh sách sản phẩm (Có phân trang & tìm kiếm)
    public function index() {
        $keyword = $_GET['keyword'] ?? '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 5; // Số sản phẩm trên 1 trang
        
        $totalItems = $this->productModel->countProducts($keyword);
        $totalPages = ceil($totalItems / $limit);
        
        // Tránh page < 1 hoặc > totalPages
        if ($page < 1) $page = 1;
        if ($page > $totalPages && $totalPages > 0) $page = $totalPages;
        
        $offset = ($page - 1) * $limit;
        
        $products = $this->productModel->getProducts($limit, $offset, $keyword);

        // Truyền dữ liệu sang View (View sẽ được bọc bởi Admin Layout)
        $this->renderAdmin('admin/products/index', [
            'page_title' => 'Quản lý Sản Phẩm',
            'products' => $products,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'keyword' => $keyword
        ]);
    }

    // Hiển thị Form Thêm và Xử lý Thêm (Server-side Validation)
    public function create() {
        $categories = $this->productModel->getAllCategories();
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $price = trim($_POST['price'] ?? '');
            $category_id = trim($_POST['category_id'] ?? '');
            $size = trim($_POST['size'] ?? 'M');
            $stock = trim($_POST['stock'] ?? '');
            $description = trim($_POST['description'] ?? '');

            // Server-side Validation
            if (empty($name)) $errors[] = "Tên sản phẩm không được để trống.";
            if (empty($price) || !is_numeric($price) || $price <= 0) $errors[] = "Giá sản phẩm phải là một số lớn hơn 0.";
            if (empty($category_id)) $errors[] = "Vui lòng chọn danh mục.";
            if (empty($size)) $errors[] = "Kích cỡ không được để trống.";
            if (!is_numeric($stock) || $stock < 0) $errors[] = "Số lượng tồn kho không hợp lệ.";

            // Upload ảnh
            $imageNames = [];
            $uploadDir = __DIR__ . '/../../uploads/products/';
            if (!is_dir($uploadDir)) @mkdir($uploadDir, 0777, true);

            for ($i = 0; $i < 6; $i++) {
                $inputName = "image_$i";
                if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] === UPLOAD_ERR_OK) {
                    $tmpName = $_FILES[$inputName]['tmp_name'];
                    if ($tmpName != "") {
                        $filename = time() . '_' . rand(100,999) . '_' . basename($_FILES[$inputName]['name']);
                        if (move_uploaded_file($tmpName, $uploadDir . $filename)) {
                            $imageNames[] = $filename;
                        }
                    }
                }
            }
            $image = !empty($imageNames) ? implode(',', $imageNames) : 'default_product.jpg';

            if (empty($errors)) {
                if ($this->productModel->createProduct($category_id, $name, $description, $price, $size, $stock, $image)) {
                    $this->redirect('index.php?controller=adminProduct&action=index');
                } else {
                    $errors[] = "Có lỗi xảy ra khi lưu vào CSDL.";
                }
            }
        }

        $this->renderAdmin('admin/products/create', [
            'page_title' => 'Thêm Sản Phẩm Mới',
            'categories' => $categories,
            'errors' => $errors,
            'old' => $_POST
        ]);
    }

    // Hiển thị Form Sửa và Xử lý Cập Nhật
    public function edit() {
        $id = (int)($_GET['id'] ?? 0);
        $product = $this->productModel->getProductById($id);
        
        if (!$product) {
            die("Lỗi 404: Không tìm thấy sản phẩm.");
        }

        $categories = $this->productModel->getAllCategories();
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $price = trim($_POST['price'] ?? '');
            $category_id = trim($_POST['category_id'] ?? '');
            $size = trim($_POST['size'] ?? 'M');
            $stock = trim($_POST['stock'] ?? '');
            $description = trim($_POST['description'] ?? '');

            if (empty($name)) $errors[] = "Tên sản phẩm không được để trống.";
            if (empty($price) || !is_numeric($price)) $errors[] = "Giá sản phẩm không hợp lệ.";
            if (empty($size)) $errors[] = "Kích cỡ không được để trống.";

            // Upload ảnh mới
            $imageNames = [];
            $uploadDir = __DIR__ . '/../../uploads/products/';
            if (!is_dir($uploadDir)) @mkdir($uploadDir, 0777, true);

            for ($i = 0; $i < 6; $i++) {
                $oldImg = $_POST['old_images'][$i] ?? '';
                $inputName = "image_$i";
                
                if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] === UPLOAD_ERR_OK) {
                    $tmpName = $_FILES[$inputName]['tmp_name'];
                    if ($tmpName != "") {
                        $filename = time() . '_' . rand(100,999) . '_' . basename($_FILES[$inputName]['name']);
                        if (move_uploaded_file($tmpName, $uploadDir . $filename)) {
                            $imageNames[] = $filename;
                        } else {
                            if ($oldImg) $imageNames[] = $oldImg;
                        }
                    } else {
                        if ($oldImg) $imageNames[] = $oldImg;
                    }
                } else {
                    if ($oldImg) {
                        $imageNames[] = $oldImg;
                    }
                }
            }
            
            $image = !empty($imageNames) ? implode(',', $imageNames) : null;

            if (empty($errors)) {
                if ($this->productModel->updateProduct($id, $category_id, $name, $description, $price, $size, $stock, $image)) {
                    $this->redirect('index.php?controller=adminProduct&action=index');
                } else {
                    $errors[] = "Lỗi khi lưu vào Database.";
                }
            }
        }

        $this->renderAdmin('admin/products/edit', [
            'page_title' => 'Sửa Sản Phẩm',
            'categories' => $categories,
            'product' => $product,
            'errors' => $errors
        ]);
    }

    // Xóa sản phẩm
    public function delete() {
        $id = $_GET['id'] ?? 0;
        if ($id) {
            $this->productModel->deleteProduct($id);
        }
        $this->redirect('index.php?controller=adminProduct&action=index');
    }
}
