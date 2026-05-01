<!-- src/Views/admin/products/edit.php -->
<div class="card shadow border-0">
    <div class="card-body">
        <h4 class="header-title border-bottom pb-2 mb-4">Chỉnh Sửa Sản Phẩm: <span class="text-primary"><?= htmlspecialchars($product['name']) ?></span></h4>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="index.php?controller=adminProduct&action=edit&id=<?= $product['id'] ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label class="font-weight-bold">Tên sản phẩm <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label class="font-weight-bold">Danh mục <span class="text-danger">*</span></label>
                    <select class="form-control" name="category_id" required>
                        <?php foreach($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= ($product['category_id'] == $cat['id']) ? 'selected' : '' ?>><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label class="font-weight-bold">Kích cỡ (Size) <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="size" value="<?= htmlspecialchars($product['size'] ?? 'M') ?>" placeholder="VD: S, M, L, XL hoặc 39, 40, 41" required>
                </div>
                <div class="form-group col-md-3">
                    <label class="font-weight-bold">Giá bán (VNĐ) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="price" value="<?= htmlspecialchars($product['price']) ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label class="font-weight-bold">Số lượng tồn kho <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="stock" value="<?= htmlspecialchars($product['stock']) ?>" required>
                </div>
            </div>

            <div class="form-group border p-3 bg-light rounded mb-4">
                <label class="font-weight-bold">Quản lý Hình Ảnh (Tối đa 6 ảnh) <span class="text-danger">* Yêu cầu ít nhất có Ảnh 1</span></label>
                <div class="row">
                    <?php 
                        $images = explode(',', $product['image']);
                        for($i=0; $i<6; $i++): 
                            $img = isset($images[$i]) && trim($images[$i]) !== '' ? trim($images[$i]) : '';
                    ?>
                        <div class="col-md-2 text-center mb-3">
                            <label class="small font-weight-bold text-muted d-block">Ảnh <?= $i+1 ?><?= $i == 0 ? ' (Chính)' : '' ?></label>
                            
                            <!-- Khung chứa ảnh -->
                            <div class="border rounded bg-white mb-2 d-flex align-items-center justify-content-center" style="height: 120px; overflow: hidden;">
                                <?php if($img): ?>
                                    <img src="uploads/products/<?= htmlspecialchars($img) ?>" style="max-height: 100%; max-width: 100%; object-fit: cover;">
                                    <input type="hidden" name="old_images[<?= $i ?>]" value="<?= htmlspecialchars($img) ?>">
                                <?php else: ?>
                                    <span class="text-muted"><i class="fa fa-image fa-2x"></i><br><small>Trống</small></span>
                                    <input type="hidden" name="old_images[<?= $i ?>]" value="">
                                <?php endif; ?>
                            </div>
                            
                            <!-- Input upload đè -->
                            <input type="file" name="image_<?= $i ?>" accept="image/*" style="font-size: 11px; width: 100%;" class="border bg-white p-1" title="Tải ảnh lên">
                        </div>
                    <?php endfor; ?>
                </div>
                <small class="text-primary mt-2 d-block"><i class="fa fa-info-circle"></i> Khi bạn tải lên ảnh mới vào một ô, nó sẽ thay thế ảnh cũ ở ô đó (nếu có). Nếu không tải lên, ảnh cũ được giữ nguyên.</small>
            </div>

            <div class="form-group">
                <label class="font-weight-bold">Mô tả chi tiết</label>
                <textarea class="form-control" name="description" rows="5"><?= htmlspecialchars($product['description']) ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary mt-3 pr-4 pl-4 font-weight-bold shadow"><i class="fa fa-save"></i> Cập Nhật Lưu Trữ</button>
            <a href="index.php?controller=adminProduct&action=index" class="btn btn-secondary mt-3 pr-4 pl-4 ml-2"><i class="fa fa-arrow-left"></i> Quay lại</a>
        </form>
    </div>
</div>
