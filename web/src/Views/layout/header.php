<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand font-weight-bold" href="index.php?controller=home&action=index">
            <?= htmlspecialchars($global_settings['site_name'] ?? 'FASHION STORE') ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="index.php?controller=home&action=index">Trang chủ</a>
                </li>
                <li class="nav-item"><a class="nav-link" href="index.php?controller=product&action=index">Sản phẩm</a>
                </li>
                <li class="nav-item"><a class="nav-link" href="index.php?controller=news&action=index">Tin tức</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?controller=contact&action=index">Liên hệ</a>
                </li>
            </ul>
            <!-- Thanh Tìm Kiếm -->
            <form class="form-inline my-2 my-lg-0 mr-3" action="index.php" method="GET">
                <input type="hidden" name="controller" value="product">
                <input type="hidden" name="action" value="index">
                <input class="form-control mr-sm-2" type="search" name="keyword" placeholder="Tìm quần áo..." required>
                <button class="btn btn-outline-light my-2 my-sm-0" type="submit"><i class="fa fa-search"></i></button>
            </form>
            <!-- Giỏ hàng và User -->
            <ul class="navbar-nav">
                <li class="nav-item mr-3">
                    <a class="nav-link text-warning font-weight-bold" href="index.php?controller=cart&action=index">
                        <i class="fa fa-shopping-cart"></i> Giỏ hàng
                        <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                            <span class="badge badge-danger ml-1"><?= count($_SESSION['cart']) ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle font-weight-bold text-white" href="#" id="userDropdown"
                            role="button" data-toggle="dropdown">
                            <i class="fa fa-user-circle"></i> <?= htmlspecialchars($_SESSION['full_name']) ?>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="index.php?controller=profile&action=index">Trang cá nhân</a>
                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                <a class="dropdown-item text-danger"
                                    href="index.php?controller=adminDashboard&action=index">Trang quản trị (Admin)</a>
                            <?php endif; ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="index.php?controller=auth&action=logout">Đăng xuất</a>
                        </div>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link btn btn-outline-primary text-white"
                            href="index.php?controller=auth&action=login">Đăng nhập</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>