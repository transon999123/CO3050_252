<div class="container mt-4 mb-5">
    <div class="row">
        <div class="col-md-6 mb-4">
            <h3 class="font-weight-bold mb-4">THÔNG TIN LIÊN HỆ</h3>
            <p class="text-muted">Chúng tôi luôn sẵn sàng lắng nghe và giải đáp mọi thắc mắc của bạn về sản phẩm, dịch
                vụ và các vấn đề liên quan. Hãy liên hệ với chúng tôi!</p>

            <ul class="list-unstyled mt-4" style="line-height: 2.5;">
                <li><i class="fa fa-map-marker-alt text-danger mr-3 fa-lg"></i>
                    <?= htmlspecialchars($global_settings['address'] ?? 'Đại học Bách Khoa TP.HCM') ?></li>
                <li><i class="fa fa-phone text-success mr-3 fa-lg"></i> <strong>Điện thoại:</strong>
                    <?= htmlspecialchars($global_settings['phone'] ?? '0123.456.789') ?>
                </li>
                <li><i class="fa fa-envelope text-primary mr-3 fa-lg"></i> <strong>Email:</strong>
                    <?= htmlspecialchars($global_settings['email'] ?? 'cskh@fashionstore.com') ?>
                </li>
                <li><i class="fa fa-clock text-warning mr-3 fa-lg"></i> <strong>Giờ làm việc:</strong> 8:00 AM - 9:00 PM
                    (Tất cả các ngày trong tuần)</li>
            </ul>
        </div>

        <div class="col-md-6">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <h4 class="font-weight-bold mb-4 border-bottom pb-2">GỬI TIN NHẮN CHO CHÚNG TÔI</h4>

                    <?php if (isset($success)): ?>
                        <div class="alert alert-success"><i class="fa fa-check-circle"></i>
                            <?= htmlspecialchars($success) ?></div>
                    <?php endif; ?>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>
                            <?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>

                    <form action="index.php?controller=contact&action=index" method="POST">
                        <div class="form-group">
                            <label class="font-weight-bold">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control"
                                value="<?= htmlspecialchars($old['name'] ?? '') ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control"
                                value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Tiêu đề <span class="text-danger">*</span></label>
                            <input type="text" name="subject" class="form-control"
                                value="<?= htmlspecialchars($old['subject'] ?? '') ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Nội dung tin nhắn <span class="text-danger">*</span></label>
                            <textarea name="message" class="form-control" rows="5"
                                required><?= htmlspecialchars($old['message'] ?? '') ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg mt-4 shadow font-weight-bold"><i
                                class="fa fa-paper-plane"></i> GỬI LIÊN HỆ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>