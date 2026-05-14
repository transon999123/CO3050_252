<footer class="text-center text-md-left">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5 class="text-uppercase font-weight-bold text-warning"><?= htmlspecialchars($global_settings['site_name'] ?? 'FASHION STORE') ?></h5>
                <p><?= htmlspecialchars($global_settings['about_text'] ?? 'Website thương mại điện tử chuyên cung cấp các mặt hàng thời trang nam nữ cao cấp, mang lại phong cách hiện đại và trẻ trung.') ?></p>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="text-uppercase font-weight-bold">Chính Sách & Hỗ Trợ</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white">Chính sách giao hàng</a></li>
                    <li><a href="#" class="text-white">Chính sách đổi trả</a></li>
                    <li><a href="#" class="text-white">Hướng dẫn chọn size</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="text-uppercase font-weight-bold">Liên Hệ</h5>
                <p><i class="fa fa-map-marker-alt mr-2"></i> <?= htmlspecialchars($global_settings['address'] ?? 'Đại học Bách Khoa TP.HCM') ?></p>
                <p><i class="fa fa-phone mr-2"></i> <?= htmlspecialchars($global_settings['phone'] ?? '0123.456.789') ?></p>
                <p><i class="fa fa-envelope mr-2"></i> <?= htmlspecialchars($global_settings['email'] ?? 'cskh@fashionstore.com') ?></p>
            </div>
        </div>
        <hr class="bg-secondary">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-left">
                <p class="mb-0">&copy; 2026 Fashion Store. Thực hiện bởi Nhóm Lập Trình Web HCMUT.</p>
            </div>
            <div class="col-md-6 text-center text-md-right mt-3 mt-md-0">
                <a href="#" class="text-white mr-3 h4"><i class="fab fa-facebook"></i></a>
                <a href="#" class="text-white mr-3 h4"><i class="fab fa-instagram"></i></a>
                <a href="#" class="text-white h4"><i class="fab fa-twitter"></i></a>
            </div>
        </div>
    </div>
</footer>