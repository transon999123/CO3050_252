<!-- src/Views/home/index.php -->
<!-- Banner / Jumbotron -->
<div class="jumbotron text-center bg-white shadow-sm border mt-3" style="background: url('https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?auto=format&fit=crop&w=1200&q=80') center/cover no-repeat; color: white;">
    <div style="background-color: rgba(0,0,0,0.5); padding: 50px; border-radius: 10px;">
        <h1 class="display-4 font-weight-bold">BỘ SƯU TẬP MỚI 2026</h1>
        <p class="lead">Khám phá phong cách thời trang, hiện đại và đậm chất riêng.</p>
        <a class="btn btn-warning btn-lg font-weight-bold mt-3" href="index.php?controller=product&action=index" role="button">MUA SẮM NGAY</a>
    </div>
</div>

<!-- Sản phẩm mới -->
<h3 class="text-center mb-4 mt-5 font-weight-bold border-bottom pb-2">🔥 SẢN PHẨM MỚI NHẤT</h3>
<div class="row">
    <?php if(!empty($latestProducts)): ?>
        <?php foreach($latestProducts as $p): ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card h-100 shadow-sm border-0 product-card">
                    <?php $firstImg = explode(',', $p['image'])[0] ?? 'default.jpg'; ?>
                    <img src="uploads/products/<?= htmlspecialchars($firstImg) ?>" class="card-img-top product-img" alt="Product" onerror="this.src='https://via.placeholder.com/300x300?text=No+Image'">
                    <div class="card-body text-center d-flex flex-column">
                        <h6 class="card-title text-dark"><?= htmlspecialchars($p['name']) ?></h6>
                        <p class="card-text text-danger font-weight-bold mt-auto h5"><?= number_format($p['price'], 0, ',', '.') ?>đ</p>
                        <a href="index.php?controller=product&action=detail&id=<?= $p['id'] ?>" class="btn btn-outline-dark btn-sm mt-3 w-100">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12 text-center text-muted">Chưa có sản phẩm nào.</div>
    <?php endif; ?>
</div>
<div class="text-center mt-3 mb-5">
    <a href="index.php?controller=product&action=index" class="btn btn-outline-primary px-4">Xem tất cả sản phẩm <i class="fa fa-arrow-right"></i></a>
</div>

<!-- Tin tức nổi bật -->
<h3 class="text-center mb-4 mt-5 font-weight-bold border-bottom pb-2">📰 TIN TỨC THỜI TRANG</h3>
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title font-weight-bold">Xu hướng thời trang Mùa Hè 2026</h5>
                <p class="card-text text-muted">Điểm qua những phong cách thời trang sẽ làm mưa làm gió trong mùa hè năm nay với các chất liệu thoáng mát...</p>
                <a href="#" class="text-primary font-weight-bold">Đọc tiếp &rarr;</a>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title font-weight-bold">Cách phối đồ với Quần Jean cực chất</h5>
                <p class="card-text text-muted">Khám phá bí kíp phối đồ chuẩn không cần chỉnh cùng chiếc quần jean quen thuộc phù hợp với mọi vóc dáng...</p>
                <a href="#" class="text-primary font-weight-bold">Đọc tiếp &rarr;</a>
            </div>
        </div>
    </div>
</div>
