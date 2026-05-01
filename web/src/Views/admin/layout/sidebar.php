<?php $ctrl = $_GET['controller'] ?? 'adminDashboard'; ?>
<!-- sidebar menu area start -->
<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo">
            <a href="index.php?controller=adminDashboard&action=index"><h3 class="text-white">FASHION ADMIN</h3></a>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">
                    <!-- Nút Quay lại Home -->
                    <li class="mt-3 mb-3">
                        <a href="index.php" target="_blank" class="text-warning"><i class="ti-home"></i> <span>Về Trang Khách Mua</span></a>
                    </li>
                    <li class="<?= $ctrl == 'adminDashboard' ? 'active' : '' ?>">
                        <a href="index.php?controller=adminDashboard&action=index"><i class="ti-dashboard"></i> <span>Dashboard</span></a>
                    </li>
                    <li class="<?= $ctrl == 'adminOrder' ? 'active' : '' ?>">
                        <a href="index.php?controller=adminOrder&action=index"><i class="ti-shopping-cart-full"></i> <span>Quản lý Đơn Hàng</span></a>
                    </li>
                    <li class="<?= $ctrl == 'adminUser' ? 'active' : '' ?>">
                        <a href="index.php?controller=adminUser&action=index"><i class="ti-user"></i> <span>Quản lý Người Dùng</span></a>
                    </li>
                    <li class="<?= $ctrl == 'adminProduct' ? 'active' : '' ?>">
                        <a href="index.php?controller=adminProduct&action=index"><i class="ti-package"></i> <span>Quản lý Sản Phẩm</span></a>
                    </li>
                    <li class="<?= $ctrl == 'adminCategory' ? 'active' : '' ?>">
                        <a href="index.php?controller=adminCategory&action=index"><i class="ti-list"></i> <span>Quản lý Danh Mục</span></a>
                    </li>
                    <li class="<?= $ctrl == 'adminContact' ? 'active' : '' ?>">
                        <a href="index.php?controller=adminContact&action=index"><i class="ti-email"></i> <span>Quản lý Liên Hệ</span></a>
                    </li>
                    <li class="<?= $ctrl == 'adminNews' ? 'active' : '' ?>">
                        <a href="index.php?controller=adminNews&action=index"><i class="ti-write"></i> <span>Quản lý Tin Tức</span></a>
                    </li>
                    <li class="<?= $ctrl == 'adminComment' ? 'active' : '' ?>">
                        <a href="index.php?controller=adminComment&action=index"><i class="ti-comment"></i> <span>Quản lý Bình luận</span></a>
                    </li>
                    <li class="<?= $ctrl == 'adminSetting' ? 'active' : '' ?>">
                        <a href="index.php?controller=adminSetting&action=index"><i class="ti-settings"></i> <span>Cài đặt Website</span></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
<!-- sidebar menu area end -->
