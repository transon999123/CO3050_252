<div class="header-area">
    <div class="row align-items-center">
        <!-- Nút thu nhỏ Sidebar -->
        <div class="col-md-6 col-sm-8 clearfix">
            <div class="nav-btn pull-left">
                <span></span><span></span><span></span>
            </div>
        </div>
        <!-- Mở rộng Fullscreen -->
        <div class="col-md-6 col-sm-4 clearfix">
            <ul class="notification-area pull-right">
                <li id="full-view"><i class="ti-fullscreen"></i></li>
                <li id="full-view-exit"><i class="ti-zoom-out"></i></li>
            </ul>
        </div>
    </div>
</div>

<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left"><?= isset($page_title) ? $page_title : 'Trang Quản Trị' ?></h4>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
            <div class="user-profile pull-right">
                <img class="avatar user-thumb" src="assets/images/author/avatar.png" alt="avatar">
                <h4 class="user-name dropdown-toggle" data-toggle="dropdown">
                    <?= htmlspecialchars($_SESSION['full_name'] ?? 'Admin') ?> <i class="fa fa-angle-down"></i>
                </h4>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="index.php?controller=auth&action=logout">Đăng xuất</a>
                </div>
            </div>
        </div>
    </div>
</div>
