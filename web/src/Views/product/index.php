<!-- src/Views/product/index.php -->
<nav aria-label="breadcrumb">
  <ol class="breadcrumb bg-white shadow-sm mt-3 border">
    <li class="breadcrumb-item"><a href="index.php?controller=home&action=index">Trang chủ</a></li>
    <li class="breadcrumb-item active">Sản phẩm</li>
  </ol>
</nav>

<div class="row mt-4 mb-4">
    <div class="col-12">
        <h4 class="font-weight-bold border-bottom pb-2">
            <?= !empty($keyword) ? 'Kết quả tìm kiếm: "' . htmlspecialchars($keyword) . '"' : 'TẤT CẢ SẢN PHẨM' ?>
        </h4>
    </div>
</div>

<div class="row">
    <!-- Cột Bộ Lọc -->
    <div class="col-lg-3 col-md-4 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white font-weight-bold">Bộ Lọc Sản Phẩm</div>
            <div class="card-body bg-light">
                <form action="index.php" method="GET">
                    <input type="hidden" name="controller" value="product">
                    <input type="hidden" name="action" value="index">
                    
                    <div class="form-group">
                        <label class="font-weight-bold">Từ khóa</label>
                        <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm..." value="<?= htmlspecialchars($keyword ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Danh mục</label>
                        <select name="category_id" class="form-control">
                            <option value="0">Tất cả danh mục</option>
                            <?php foreach($categories ?? [] as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= (isset($categoryId) && $categoryId == $cat['id']) ? 'selected' : '' ?>><?= htmlspecialchars($cat['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Đánh giá tối thiểu</label>
                        <select name="min_rating" class="form-control">
                            <option value="0">Tất cả</option>
                            <option value="1" <?= (isset($minRating) && $minRating == 1) ? 'selected' : '' ?>>1 sao trở lên</option>
                            <option value="2" <?= (isset($minRating) && $minRating == 2) ? 'selected' : '' ?>>2 sao trở lên</option>
                            <option value="3" <?= (isset($minRating) && $minRating == 3) ? 'selected' : '' ?>>3 sao trở lên</option>
                            <option value="4" <?= (isset($minRating) && $minRating == 4) ? 'selected' : '' ?>>4 sao trở lên</option>
                            <option value="5" <?= (isset($minRating) && $minRating == 5) ? 'selected' : '' ?>>5 sao</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Kích cỡ</label>
                        <select name="size" class="form-control">
                            <option value="">Tất cả kích cỡ</option>
                            <option value="S" <?= (isset($size) && $size == 'S') ? 'selected' : '' ?>>S</option>
                            <option value="M" <?= (isset($size) && $size == 'M') ? 'selected' : '' ?>>M</option>
                            <option value="L" <?= (isset($size) && $size == 'L') ? 'selected' : '' ?>>L</option>
                            <option value="XL" <?= (isset($size) && $size == 'XL') ? 'selected' : '' ?>>XL</option>
                            <option value="XXL" <?= (isset($size) && $size == 'XXL') ? 'selected' : '' ?>>XXL</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Sắp xếp theo</label>
                        <select name="sort_by" class="form-control">
                            <option value="created_at" <?= (isset($sortBy) && $sortBy == 'created_at') ? 'selected' : '' ?>>Mới nhất</option>
                            <option value="price" <?= (isset($sortBy) && $sortBy == 'price') ? 'selected' : '' ?>>Giá</option>
                            <option value="rating" <?= (isset($sortBy) && $sortBy == 'rating') ? 'selected' : '' ?>>Đánh giá</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Thứ tự</label>
                        <select name="sort_order" class="form-control">
                            <option value="DESC" <?= (isset($sortOrder) && $sortOrder == 'DESC') ? 'selected' : '' ?>>Giảm dần</option>
                            <option value="ASC" <?= (isset($sortOrder) && $sortOrder == 'ASC') ? 'selected' : '' ?>>Tăng dần</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Khoảng giá (VNĐ)</label>
                        <input type="number" name="min_price" class="form-control mb-2" placeholder="Giá tối thiểu" value="<?= isset($minPrice) && $minPrice > 0 ? $minPrice : '' ?>">
                        <input type="number" name="max_price" class="form-control" placeholder="Giá tối đa" value="<?= isset($maxPrice) && $maxPrice > 0 ? $maxPrice : '' ?>">
                    </div>

                    <button type="submit" class="btn btn-primary w-100 font-weight-bold"><i class="fa fa-filter"></i> Áp Dụng Lọc</button>
                    <a href="index.php?controller=product&action=index" class="btn btn-outline-secondary w-100 mt-2">Xóa Lọc</a>
                </form>
            </div>
        </div>
    </div>

    <!-- Cột Danh Sách Sản Phẩm -->
    <div class="col-lg-9 col-md-8">
        <div class="row">
            <?php if(count($products) > 0): ?>
                <?php foreach($products as $p): ?>
                    <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                        <div class="card product-card h-100 shadow-sm border-0">
                            <?php $firstImg = explode(',', $p['image'])[0] ?? 'default.jpg'; ?>
                            <img src="uploads/products/<?= htmlspecialchars($firstImg) ?>" class="card-img-top product-img" alt="..." onerror="this.src='https://via.placeholder.com/300x300?text=No+Image'">
                            <div class="card-body text-center flex-column d-flex">
                                <h6 class="card-title text-dark"><?= htmlspecialchars($p['name']) ?></h6>
                                
                                <!-- Hiển thị rating -->
                                <?php if (isset($p['avg_rating']) && $p['avg_rating'] > 0): ?>
                                    <div class="mb-2">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="fa fa-star <?= $i <= round($p['avg_rating']) ? 'text-warning' : 'text-muted' ?> small"></i>
                                        <?php endfor; ?>
                                        <small class="text-muted ml-1">(<?= $p['review_count'] ?? 0 ?>)</small>
                                    </div>
                                <?php endif; ?>
                                
                                <p class="card-text text-danger font-weight-bold mt-auto h5"><?= number_format($p['price'], 0, ',', '.') ?>đ</p>
                                <a href="index.php?controller=product&action=detail&id=<?= $p['id'] ?>" class="btn btn-outline-dark btn-sm mt-3 w-100">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5 mt-5 bg-white shadow-sm rounded">
                    <h5 class="text-muted"><i class="fa fa-box-open fa-3x mb-3"></i><br>Không tìm thấy sản phẩm nào phù hợp!</h5>
                    <a href="index.php?controller=product&action=index" class="btn btn-primary mt-3">Quay lại danh sách</a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Phân trang -->
        <?php if ($totalPages > 1): ?>
        <nav aria-label="Page navigation" class="mt-4">
            <ul class="pagination justify-content-center">
                <li class="page-item <?= ($currentPage <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="index.php?controller=product&action=index&page=<?= $currentPage - 1 ?>&keyword=<?= urlencode($keyword) ?>&category_id=<?= $categoryId ?>&size=<?= $size ?>&min_price=<?= $minPrice ?>&max_price=<?= $maxPrice ?>&min_rating=<?= $minRating ?>&sort_by=<?= $sortBy ?>&sort_order=<?= $sortOrder ?>">Trước</a>
                </li>
                <?php for($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                        <a class="page-link" href="index.php?controller=product&action=index&page=<?= $i ?>&keyword=<?= urlencode($keyword) ?>&category_id=<?= $categoryId ?>&size=<?= $size ?>&min_price=<?= $minPrice ?>&max_price=<?= $maxPrice ?>&min_rating=<?= $minRating ?>&sort_by=<?= $sortBy ?>&sort_order=<?= $sortOrder ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?= ($currentPage >= $totalPages) ? 'disabled' : '' ?>">
                    <a class="page-link" href="index.php?controller=product&action=index&page=<?= $currentPage + 1 ?>&keyword=<?= urlencode($keyword) ?>&category_id=<?= $categoryId ?>&size=<?= $size ?>&min_price=<?= $minPrice ?>&max_price=<?= $maxPrice ?>&min_rating=<?= $minRating ?>&sort_by=<?= $sortBy ?>&sort_order=<?= $sortOrder ?>">Tiếp</a>
                </li>
            </ul>
        </nav>
        <?php endif; ?>
    </div>
</div>
