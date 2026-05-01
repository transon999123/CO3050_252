<!-- src/Views/profile/index.php -->
<div class="row mt-4 mb-5">
    <!-- Sidebar Menu Profile -->
    <div class="col-md-3 mb-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <a href="index.php?controller=profile&action=index" class="list-group-item list-group-item-action active text-white bg-primary"><i class="fa fa-user mr-2"></i> Thông Tin Cá Nhân</a>
                    <a href="index.php?controller=profile&action=orders" class="list-group-item list-group-item-action"><i class="fa fa-shopping-bag mr-2"></i> Lịch Sử Đơn Hàng</a>
                    <a href="index.php?controller=auth&action=logout" class="list-group-item list-group-item-action text-danger"><i class="fa fa-sign-out mr-2"></i> Đăng Xuất</a>
                </div>
            </div>
        </div>

        <!-- Panel Avatar -->
        <div class="card shadow-sm border-0 text-center py-4">
            <div class="card-body">
                <img src="<?= !empty($user['avatar']) ? 'uploads/avatars/' . htmlspecialchars($user['avatar']) : 'https://via.placeholder.com/150' ?>" class="avatar-preview mb-3" alt="Avatar" onerror="this.src='https://via.placeholder.com/150'">
                
                <h5 class="font-weight-bold"><?= htmlspecialchars($user['full_name']) ?></h5>
                <p class="text-muted mb-4">@<?= htmlspecialchars($user['username']) ?> | <?= $user['role'] === 'admin' ? '<span class="badge badge-danger">Quản Trị Viên</span>' : '<span class="badge badge-info">Thành Viên</span>' ?></p>

                <!-- Form Upload Ảnh -->
                <form action="index.php?controller=profile&action=uploadAvatar" method="POST" enctype="multipart/form-data">
                    <div class="custom-file mb-3 text-left">
                        <input type="file" class="custom-file-input" id="avatarInput" name="avatar" accept="image/*" required>
                        <label class="custom-file-label" for="avatarInput" data-browse="Chọn file">Đổi ảnh đại diện</label>
                    </div>
                    <button type="submit" class="btn btn-outline-primary btn-sm btn-block"><i class="fa fa-upload"></i> Tải ảnh lên</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <!-- Thông báo Trạng thái -->
        <?php if(isset($_GET['msg'])): ?>
            <?php if($_GET['msg'] === 'success'): ?>
                <div class="alert alert-success">Cập nhật thông tin thành công!</div>
            <?php elseif($_GET['msg'] === 'avatar_success'): ?>
                <div class="alert alert-success">Đã thay đổi ảnh đại diện!</div>
            <?php elseif($_GET['msg'] === 'invalid_file'): ?>
                <div class="alert alert-danger">File không hợp lệ. Chỉ chấp nhận ảnh JPG, PNG, GIF.</div>
            <?php else: ?>
                <div class="alert alert-danger">Có lỗi xảy ra, vui lòng thử lại!</div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Panel Cập nhật thông tin -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom font-weight-bold">
                <i class="fa fa-user-edit mr-2 text-primary"></i> Thông Tin Cá Nhân
            </div>
            <div class="card-body p-4">
                <form action="index.php?controller=profile&action=update" method="POST">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Tên đăng nhập (Username)</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Địa chỉ Email</label>
                            <input type="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" disabled>
                        </div>
                    </div>
                    
                    <div class="form-group mt-2">
                        <label class="font-weight-bold">Họ và Tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="full_name" value="<?= htmlspecialchars($user['full_name']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Số điện thoại</label>
                        <input type="text" class="form-control" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" placeholder="Ví dụ: 0912345678">
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Tỉnh/Thành phố</label>
                            <select name="city" class="form-control">
                                <option value="TP.HCM">Hồ Chí Minh</option>
                                <option value="Hà Nội">Hà Nội</option>
                                <option value="Đà Nẵng">Đà Nẵng</option>
                                <option value="Cần Thơ">Cần Thơ</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Quận/Huyện</label>
                            <input type="text" class="form-control" name="district" placeholder="VD: Quận Thủ Đức">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Số nhà, Tên đường</label>
                        <input type="text" class="form-control" name="street" value="<?= htmlspecialchars($user['address'] ?? '') ?>" placeholder="VD: KTX Khu A ĐHQG...">
                    </div>

                    <button type="submit" class="btn btn-primary px-4 mt-3">Lưu Thay Đổi</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Script nhỏ để hiển thị tên file khi chọn ảnh trên Bootstrap Custom File Input
document.querySelector('.custom-file-input').addEventListener('change',function(e){
  var fileName = document.getElementById("avatarInput").files[0].name;
  var nextSibling = e.target.nextElementSibling;
  nextSibling.innerText = fileName;
});
</script>
