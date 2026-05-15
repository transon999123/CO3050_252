<!-- src/Views/admin/products/index.php -->
<div class="card">
    <div class="card-body">
        <h4 class="header-title">Danh Sách Sản Phẩm</h4>
        
        <div class="row mb-3">
            <div class="col-md-4">
                <a href="index.php?controller=adminProduct&action=create" class="btn btn-primary"><i class="ti-plus"></i> Thêm Sản Phẩm</a>
            </div>
            <div class="col-md-8 text-right">
                <form action="index.php" method="GET" class="form-inline float-right">
                    <input type="hidden" name="controller" value="adminProduct">
                    <input type="hidden" name="action" value="index">
                    
                    <select name="sort_by" class="form-control mr-2">
                        <option value="created_at" <?= (isset($sortBy) && $sortBy == 'created_at') ? 'selected' : '' ?>>Sắp xếp theo: Mới nhất</option>
                        <option value="price" <?= (isset($sortBy) && $sortBy == 'price') ? 'selected' : '' ?>>Sắp xếp theo: Giá</option>
                        <option value="rating" <?= (isset($sortBy) && $sortBy == 'rating') ? 'selected' : '' ?>>Sắp xếp theo: Đánh giá</option>
                    </select>
                    
                    <select name="sort_order" class="form-control mr-2">
                        <option value="DESC" <?= (isset($sortOrder) && $sortOrder == 'DESC') ? 'selected' : '' ?>>Giảm dần</option>
                        <option value="ASC" <?= (isset($sortOrder) && $sortOrder == 'ASC') ? 'selected' : '' ?>>Tăng dần</option>
                    </select>
                    
                    <input type="text" name="keyword" class="form-control mr-2" placeholder="Tìm theo tên..." value="<?= htmlspecialchars($keyword) ?>">
                    <button type="submit" class="btn btn-success">Tìm kiếm</button>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center">
                <thead class="bg-light text-capitalize">
                    <tr>
                        <th>ID</th>
                        <th>Hình Ảnh</th>
                        <th>Tên Sản Phẩm</th>
                        <th>Danh Mục</th>
                        <th>Giá</th>
                        <th>Đánh giá</th>
                        <th>Tồn Kho</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($products) > 0): ?>
                        <?php foreach ($products as $p): ?>
                            <tr>
                                <td><?= $p['id'] ?></td>
                                <td>
                                    <?php $firstImage = explode(',', $p['image'])[0] ?? 'default_product.jpg'; ?>
                                    <img src="uploads/products/<?= htmlspecialchars($firstImage) ?>" alt="" width="50" height="50" onerror="this.src='https://via.placeholder.com/50'">
                                </td>
                                <td class="text-left"><?= htmlspecialchars($p['name']) ?></td>
                                <td><?= htmlspecialchars($p['category_name']) ?></td>
                                <td class="text-danger font-weight-bold"><?= number_format($p['price'], 0, ',', '.') ?>đ</td>
                                <td>
                                    <?php if (isset($p['avg_rating']) && $p['avg_rating'] > 0): ?>
                                        <div class="text-center">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <i class="fa fa-star <?= $i <= round($p['avg_rating']) ? 'text-warning' : 'text-muted' ?>"></i>
                                            <?php endfor; ?>
                                            <br><small class="text-muted">(<?= number_format($p['avg_rating'], 1) ?>/5 - <?= $p['review_count'] ?? 0 ?> đánh giá)</small>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted">Chưa có đánh giá</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= $p['stock'] ?></td>
                                <td>
                                    <!-- Nút Sửa -->
                                    <a href="index.php?controller=adminProduct&action=edit&id=<?= $p['id'] ?>" class="btn btn-sm btn-primary mr-1" title="Sửa"><i class="fa fa-edit"></i> Sửa</a>
                                    <!-- Nút Xóa (Kèm Client-side confirm) -->
                                    <a href="index.php?controller=adminProduct&action=delete&id=<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?');"><i class="fa fa-trash"></i> Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7">Không có sản phẩm nào.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Phân trang -->
        <?php if ($totalPages > 1): ?>
        <div class="pagination-wrapper mt-3">
            <ul class="pagination justify-content-center">
                <?php for($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                        <a class="page-link" href="index.php?controller=adminProduct&action=index&page=<?= $i ?>&keyword=<?= urlencode($keyword) ?>&sort_by=<?= $sortBy ?>&sort_order=<?= $sortOrder ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </div>
        <?php endif; ?>

    </div>
</div>
