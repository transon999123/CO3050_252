<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? $page_title . ' - Fashion Store' : 'Fashion Store' ?></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa; }
        .product-card { transition: 0.3s; border-radius: 10px; overflow: hidden; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .product-img { height: 250px; object-fit: cover; }
        footer { background: #343a40; color: #fff; padding: 40px 0; margin-top: 50px; }
        .avatar-preview { width: 120px; height: 120px; object-fit: cover; border-radius: 50%; border: 3px solid #dee2e6; }
    </style>
</head>
<body>
    <!-- HEADER -->
    <?php include __DIR__ . '/header.php'; ?>
    
    <!-- MAIN CONTENT -->
    <main class="container mt-4 min-vh-100">
        <?php include $view_content; ?>
    </main>
    
    <!-- FOOTER -->
    <?php include __DIR__ . '/footer.php'; ?>

    <!-- JS Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
