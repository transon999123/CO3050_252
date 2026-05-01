<!-- src/Views/product/detail.php -->
<nav aria-label="breadcrumb">
  <ol class="breadcrumb bg-white shadow-sm mt-3 border">
    <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
    <li class="breadcrumb-item"><a href="index.php?controller=product&action=index">Sản phẩm</a></li>
    <li class="breadcrumb-item active"><?= htmlspecialchars($product['name']) ?></li>
  </ol>
</nav>

<div class="row mt-4 bg-white p-4 rounded shadow-sm border mb-5">
    <!-- Hình ảnh -->
    <div class="col-md-5 text-center mb-4">
        <?php 
            $images = explode(',', $product['image']);
            $firstImg = $images[0] ?? 'default.jpg'; 
        ?>
        <!-- Ảnh chính -->
        <img id="mainImage" src="uploads/products/<?= htmlspecialchars($firstImg) ?>" class="img-fluid rounded border mb-3" style="max-height: 400px; width: 100%; object-fit: contain;" alt="Product Image" onerror="this.src='https://via.placeholder.com/500x500?text=No+Image'">
        
        <!-- Ảnh nhỏ (Thumbnail) -->
        <?php if(count($images) > 1): ?>
        <div class="d-flex justify-content-center flex-wrap">
            <?php foreach($images as $img): ?>
                <?php if(trim($img) !== ''): ?>
                <img src="uploads/products/<?= htmlspecialchars(trim($img)) ?>" class="img-thumbnail mr-2 mb-2" style="width: 80px; height: 80px; cursor: pointer; object-fit: cover;" onclick="document.getElementById('mainImage').src=this.src" onerror="this.style.display='none'">
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
    
    <!-- Thông tin -->
    <div class="col-md-7">
        <h2 class="font-weight-bold text-dark"><?= htmlspecialchars($product['name']) ?></h2>
        
        <p class="text-muted mb-2 border-bottom pb-3">Tình trạng: 
            <?= $product['stock'] > 0 ? '<span class="badge badge-success px-2 py-1">Còn hàng ('.$product['stock'].')</span>' : '<span class="badge badge-danger px-2 py-1">Hết hàng</span>' ?>
        </p>
        
        <h3 class="text-danger font-weight-bold my-4" style="font-size: 2.5rem;"><?= number_format($product['price'], 0, ',', '.') ?> VNĐ</h3>
        
        <div class="mb-5 bg-light p-3 rounded">
            <h5 class="font-weight-bold">Mô tả sản phẩm:</h5>
            <p class="mb-0" style="line-height: 1.8;"><?= nl2br(htmlspecialchars($product['description'] ?? 'Chưa có mô tả chi tiết.')) ?></p>
        </div>

        <!-- Form Add to Cart -->
        <?php if($product['stock'] > 0): ?>
            <form action="index.php?controller=cart&action=add" method="POST" class="form-inline bg-white p-3 border rounded">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                
                <div class="form-group mb-0">
                    <label for="qty" class="mr-2 font-weight-bold">Số lượng:</label>
                    <input type="number" id="qty" name="quantity" class="form-control form-control-lg mr-4 text-center" value="1" min="1" max="<?= $product['stock'] ?>" style="width: 100px;">
                </div>
                
                <button type="submit" class="btn btn-danger btn-lg"><i class="fa fa-cart-plus mr-2"></i> THÊM VÀO GIỎ HÀNG</button>
            </form>
        <?php else: ?>
            <button class="btn btn-secondary btn-lg btn-block" disabled><i class="fa fa-ban mr-2"></i> ĐÃ HẾT HÀNG</button>
        <?php endif; ?>
    </div>
</div>
