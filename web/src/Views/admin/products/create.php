<!-- src/Views/admin/products/create.php -->
<div class="card">
    <div class="card-body">
        <h4 class="header-title">Thêm Sản Phẩm Mới</h4>

        <!-- Hiển thị lỗi từ Server-side -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Form Validate Client-side bằng Javascript onsubmit -->
        <form action="index.php?controller=adminProduct&action=create" method="POST" enctype="multipart/form-data" onsubmit="return validateProductForm()">
            <div class="form-group">
                <label>Tên sản phẩm <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name" id="product_name" value="<?= htmlspecialchars($old['name'] ?? '') ?>" placeholder="Nhập tên sản phẩm">
                <small class="text-danger" id="err_name"></small>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Danh mục <span class="text-danger">*</span></label>
                    <select class="form-control" name="category_id" id="category_id">
                        <option value="">-- Chọn danh mục --</option>
                        <?php foreach($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= (isset($old['category_id']) && $old['category_id'] == $cat['id']) ? 'selected' : '' ?>><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <small class="text-danger" id="err_category"></small>
                </div>
                <div class="form-group col-md-3">
                    <label>Kích cỡ (Size) <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="size" value="<?= htmlspecialchars($old['size'] ?? 'M') ?>" placeholder="VD: S, M, L, XL" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Giá bán (VNĐ) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="price" id="product_price" value="<?= htmlspecialchars($old['price'] ?? '') ?>" placeholder="Ví dụ: 150000">
                    <small class="text-danger" id="err_price"></small>
                </div>
                <div class="form-group col-md-3">
                    <label>Số lượng tồn kho <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="stock" id="product_stock" value="<?= htmlspecialchars($old['stock'] ?? 0) ?>">
                    <small class="text-danger" id="err_stock"></small>
                </div>
            </div>

            <div class="form-group border p-3 bg-light rounded mb-4">
                <label class="font-weight-bold">Quản lý Hình Ảnh (Tối đa 6 ảnh) <span class="text-danger">* Yêu cầu ít nhất có Ảnh 1</span></label>
                <div class="row">
                    <?php for($i=0; $i<6; $i++): ?>
                        <div class="col-md-2 text-center mb-3">
                            <label class="small font-weight-bold text-muted d-block">Ảnh <?= $i+1 ?><?= $i == 0 ? ' (Chính)' : '' ?></label>
                            
                            <!-- Khung chứa ảnh (Trống mặc định) -->
                            <div class="border rounded bg-white mb-2 d-flex align-items-center justify-content-center" style="height: 120px; overflow: hidden;">
                                <span class="text-muted"><i class="fa fa-image fa-2x"></i><br><small>Trống</small></span>
                            </div>
                            
                            <!-- Input upload -->
                            <input type="file" name="image_<?= $i ?>" accept="image/*" style="font-size: 11px; width: 100%;" class="border bg-white p-1" <?= $i == 0 ? 'required' : '' ?> title="Tải ảnh lên">
                        </div>
                    <?php endfor; ?>
                </div>
                <small class="text-primary mt-2 d-block"><i class="fa fa-info-circle"></i> Hãy tải lên ít nhất một tấm ảnh ở ô "Ảnh 1". Các ô khác có thể để trống.</small>
            </div>

            <div class="form-group">
                <label>Mô tả chi tiết</label>
                <textarea class="form-control" name="description" rows="5" placeholder="Nhập mô tả sản phẩm..."><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Lưu Sản Phẩm</button>
            <a href="index.php?controller=adminProduct&action=index" class="btn btn-secondary mt-4 pr-4 pl-4 ml-2">Quay lại</a>
        </form>
    </div>
</div>

<script>
// Client-side Validation bằng Javascript thuần
function validateProductForm() {
    let isValid = true;
    
    let name = document.getElementById('product_name').value.trim();
    let category = document.getElementById('category_id').value;
    let price = document.getElementById('product_price').value.trim();
    let stock = document.getElementById('product_stock').value.trim();

    // Reset error messages
    document.getElementById('err_name').innerText = '';
    document.getElementById('err_category').innerText = '';
    document.getElementById('err_price').innerText = '';
    document.getElementById('err_stock').innerText = '';

    if (name === '') {
        document.getElementById('err_name').innerText = 'Tên sản phẩm không được để trống.';
        isValid = false;
    }
    
    if (category === '') {
        document.getElementById('err_category').innerText = 'Vui lòng chọn danh mục.';
        isValid = false;
    }
    
    if (price === '' || isNaN(price) || Number(price) <= 0) {
        document.getElementById('err_price').innerText = 'Giá bán phải là số hợp lệ lớn hơn 0.';
        isValid = false;
    }
    
    if (stock === '' || isNaN(stock) || Number(stock) < 0) {
        document.getElementById('err_stock').innerText = 'Số lượng tồn không hợp lệ.';
        isValid = false;
    }

    return isValid; // Trả về false sẽ chặn form submit
}
</script>
