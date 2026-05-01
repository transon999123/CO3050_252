<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow border-0 rounded-lg">
                <div class="card-body p-5">
                    <h3 class="text-center mb-4 font-weight-bold"><i class="fa fa-sign-in-alt text-primary"></i> ĐĂNG NHẬP</h3>
                    
                    <?php if(isset($_GET['success'])): ?>
                        <div class="alert alert-success text-center">Đăng ký thành công! Vui lòng đăng nhập.</div>
                    <?php endif; ?>
                    
                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger text-center"><?= $error ?></div>
                    <?php endif; ?>

                    <form action="index.php?controller=auth&action=login" method="POST">
                        <div class="form-group">
                            <label class="font-weight-bold">Tên đăng nhập</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-user"></i></span></div>
                                <input type="text" name="username" class="form-control form-control-lg" value="<?= htmlspecialchars($username ?? '') ?>" required placeholder="Nhập username...">
                            </div>
                        </div>
                        <div class="form-group mt-4">
                            <label class="font-weight-bold">Mật khẩu</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-lock"></i></span></div>
                                <input type="password" name="password" class="form-control form-control-lg" required placeholder="Nhập mật khẩu...">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg mt-5 font-weight-bold shadow">ĐĂNG NHẬP</button>
                    </form>
                    <div class="text-center mt-4">
                        <p class="mb-0">Chưa có tài khoản? <a href="index.php?controller=auth&action=register" class="font-weight-bold text-danger">Đăng ký ngay</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
