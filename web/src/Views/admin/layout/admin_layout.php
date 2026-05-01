<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?= isset($page_title) ? $page_title . ' - Admin Dashboard' : 'Admin Dashboard' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <!-- Load CSS từ template srtdash -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <!-- JS Validator (Có thể chèn các thư viện custom nếu cần) -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>
<body>
    <!-- Đã tắt preloader vì nó gây lỗi che màn hình trắng
    <div id="preloader">
        <div class="loader"></div>
    </div>
    -->
    
    <div class="page-container">
        <!-- Sidebar Menu -->
        <?php include __DIR__ . '/sidebar.php'; ?>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Header (Topbar) -->
            <?php include __DIR__ . '/topbar.php'; ?>
            
            <div class="main-content-inner mt-4">
                <!-- Nội dung Body (View tương ứng với Controller) sẽ được nhúng vào đây -->
                <?php include $view_content; ?>
            </div>
        </div>
        
        <!-- Footer -->
        <footer>
            <div class="footer-area">
                <p>© Copyright 2026. All right reserved. HCMUT Web Project.</p>
            </div>
        </footer>
    </div>

    <!-- Tải các thư viện JS cốt lõi -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/metisMenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>
    
    <!-- Các script chính của Srtdash -->
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>
</html>
