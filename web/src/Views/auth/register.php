<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0 rounded-lg">
                <div class="card-body p-5">
                    <h3 class="text-center mb-4 font-weight-bold"><i class="fa fa-user-plus text-success"></i> TẠO TÀI KHOẢN</h3>
                    
                    <?php if(!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0 pl-3">
                                <?php foreach($errors as $err): ?>
                                    <li><?= htmlspecialchars($err) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="index.php?controller=auth&action=register" method="POST">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Tên đăng nhập <span class="text-danger">*</span></label>
                                <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($old['username'] ?? '') ?>" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <label class="font-weight-bold">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($old['full_name'] ?? '') ?>" required>
                        </div>
                        <div class="form-row mt-2">
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Mật khẩu <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" required minlength="6">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Nhập lại Mật khẩu <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirm" class="form-control" required minlength="6">
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-success btn-block btn-lg mt-5 font-weight-bold shadow">ĐĂNG KÝ NGAY</button>
                    </form>
                    <div class="text-center mt-4">
                        <p class="mb-0">Đã có tài khoản? <a href="index.php?controller=auth&action=login" class="font-weight-bold text-primary">Đăng nhập</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
