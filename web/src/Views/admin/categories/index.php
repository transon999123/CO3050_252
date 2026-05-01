<!-- src/Views/admin/categories/index.php -->
<div class="card shadow border-0">
    <div class="card-body">
        <h4 class="header-title">Quản Lý Danh Mục Sản Phẩm</h4>
        
        <div class="row mb-3 mt-3">
            <div class="col-md-6">
                <form action="index.php?controller=adminCategory&action=create" method="POST" class="form-inline">
                    <input type="text" name="name" class="form-control mr-2" placeholder="Tên danh mục mới" required>
                    <button type="submit" class="btn btn-primary"><i class="ti-plus"></i> Thêm Danh Mục</button>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center">
                <thead class="bg-light text-capitalize">
                    <tr>
                        <th>ID</th>
                        <th>Tên Danh Mục</th>
                        <th>Số Sản Phẩm</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($categories) > 0): ?>
                        <?php foreach ($categories as $c): ?>
                            <tr>
                                <td class="align-middle"><?= $c['id'] ?></td>
                                <td class="align-middle text-left font-weight-bold text-primary">
                                    <form action="index.php?controller=adminCategory&action=edit" method="POST" class="d-flex" style="max-width: 300px;">
                                        <input type="hidden" name="id" value="<?= $c['id'] ?>">
                                        <input type="text" name="name" value="<?= htmlspecialchars($c['name']) ?>" class="form-control form-control-sm mr-2" required>
                                        <button type="submit" class="btn btn-sm btn-outline-success">Lưu</button>
                                    </form>
                                </td>
                                <td class="align-middle">
                                    <span class="badge badge-info p-2"><?= $c['product_count'] ?> sản phẩm</span>
                                </td>
                                <td class="align-middle">
                                    <a href="index.php?controller=adminCategory&action=delete&id=<?= $c['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này? Chú ý: Không thể xóa danh mục đang có sản phẩm.');"><i class="fa fa-trash"></i> Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4">Chưa có danh mục nào.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
