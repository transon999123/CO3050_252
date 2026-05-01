<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow border-0">
            <div class="card-body p-4">
                <h4 class="font-weight-bold border-bottom pb-3 mb-4"><i class="fa fa-cogs text-primary"></i> Quản Lý Thông Tin Chung</h4>
                
                <?php if(isset($_GET['msg']) && $_GET['msg'] === 'success'): ?>
                    <div class="alert alert-success">Đã lưu cấu hình trang web thành công!</div>
                <?php endif; ?>

                <form action="index.php?controller=adminSetting&action=index" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="font-weight-bold">Tên Website / Thương hiệu</label>
                        <input type="text" name="site_name" class="form-control" value="<?= htmlspecialchars($settings['site_name'] ?? '') ?>" required>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Hotline / Số điện thoại</label>
                            <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($settings['phone'] ?? '') ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Email hỗ trợ</label>
                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($settings['email'] ?? '') ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="font-weight-bold">Địa chỉ Công ty</label>
                        <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($settings['address'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Đoạn giới thiệu ngắn (Footer)</label>
                        <textarea name="about_text" class="form-control" rows="4"><?= htmlspecialchars($settings['about_text'] ?? '') ?></textarea>
                    </div>

                    <div class="form-group border p-3 bg-light rounded mt-4">
                        <label class="font-weight-bold">Logo Website mới (Tùy chọn)</label>
                        <input type="file" name="logo" class="form-control-file" accept="image/*">
                        <small class="text-muted">Chức năng upload demo.</small>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg px-5 mt-3 shadow font-weight-bold"><i class="fa fa-save"></i> LƯU THAY ĐỔI</button>
                </form>
            </div>
        </div>
    </div>
</div>
