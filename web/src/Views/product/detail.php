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

<!-- Phần đánh giá và nhận xét -->
<div class="row mt-5">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h4 class="font-weight-bold mb-4">
                    <i class="fa fa-star text-warning"></i> Đánh giá sản phẩm
                    <?php if ($avgRating > 0): ?>
                        <span class="badge badge-warning ml-2">
                            <?= number_format($avgRating, 1) ?>/5
                            <small class="text-muted"> (<?= $totalReviews ?> đánh giá)</small>
                        </span>
                    <?php else: ?>
                        <small class="text-muted">Chưa có đánh giá</small>
                    <?php endif; ?>
                </h4>

                <!-- Hiển thị sao trung bình -->
                <?php if ($avgRating > 0): ?>
                    <div class="mb-4">
                        <div class="d-flex align-items-center">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="fa fa-star <?= $i <= round($avgRating) ? 'text-warning' : 'text-muted' ?> mr-1"></i>
                            <?php endfor; ?>
                            <span class="ml-2 font-weight-bold"><?= number_format($avgRating, 1) ?>/5</span>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Danh sách đánh giá -->
                <?php if (count($reviews) > 0): ?>
                    <div class="reviews-section">
                        <h5 class="mb-3">Nhận xét từ khách hàng (<?= $totalReviews ?>)</h5>
                        <?php foreach ($reviews as $review): ?>
                            <div class="border rounded p-3 mb-3 bg-light">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <strong class="text-dark"><?= htmlspecialchars($review['user_name']) ?></strong>
                                        <small class="text-muted ml-2">
                                            <?= date('d/m/Y', strtotime($review['created_at'])) ?>
                                        </small>
                                    </div>
                                    <div class="text-warning">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="fa fa-star <?= $i <= $review['rating'] ? 'text-warning' : 'text-muted' ?>"></i>
                                        <?php endfor; ?>
                                        <span class="ml-1 font-weight-bold"><?= $review['rating'] ?>/5</span>
                                    </div>
                                </div>
                                <p class="mb-2 text-dark"><?= nl2br(htmlspecialchars($review['comment'])) ?></p>
                                <?php if ($review['image']): ?>
                                    <div class="mt-2">
                                        <img src="uploads/reviews/<?= htmlspecialchars($review['image']) ?>" 
                                             alt="Review image" 
                                             class="img-thumbnail" 
                                             style="max-width: 200px; max-height: 200px; cursor: pointer;"
                                             onclick="window.open(this.src)">
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>

                        <?php if ($totalReviews > 10): ?>
                            <div class="text-center mt-3">
                                <button class="btn btn-outline-primary" onclick="alert('Tính năng xem thêm đánh giá đang được phát triển')">Xem thêm đánh giá</button>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fa fa-comments fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Chưa có đánh giá nào cho sản phẩm này.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
