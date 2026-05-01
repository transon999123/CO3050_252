<div class="container mt-4 mb-5">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-white shadow-sm border">
        <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="index.php?controller=news&action=index">Tin tức</a></li>
        <li class="breadcrumb-item active"><?= htmlspecialchars($news['title']) ?></li>
      </ol>
    </nav>

    <div class="card shadow border-0 mt-4">
        <div class="card-body p-5">
            <h2 class="font-weight-bold mb-3"><?= htmlspecialchars($news['title']) ?></h2>
            <div class="text-muted mb-4 border-bottom pb-3">
                <i class="fa fa-user-edit mr-1"></i> Tác giả: <span class="font-weight-bold text-dark"><?= htmlspecialchars($news['author_name'] ?? 'Admin') ?></span> | 
                <i class="fa fa-calendar-alt ml-3 mr-1"></i> <?= date('d/m/Y H:i', strtotime($news['created_at'])) ?> | 
                <i class="fa fa-eye ml-3 mr-1"></i> <?= $news['views'] ?> lượt xem
            </div>
            
            <div class="text-center mb-5">
                <img src="uploads/<?= htmlspecialchars($news['thumbnail'] ?? 'default_news.jpg') ?>" class="img-fluid rounded shadow-sm" alt="Thumbnail" onerror="this.src='https://via.placeholder.com/800x400?text=News+Cover'">
            </div>

            <div class="news-content" style="font-size: 1.1rem; line-height: 1.8;">
                <!-- Sử dụng nl2br để hiển thị xuống dòng của bài viết -->
                <?= nl2br(htmlspecialchars($news['content'])) ?>
            </div>
            
            <div class="mt-5 pt-4 border-top">
                <h5 class="font-weight-bold"><i class="fa fa-comments text-primary"></i> Bình luận</h5>
                <div class="alert alert-info mt-3">Chức năng bình luận đang được xây dựng...</div>
            </div>
        </div>
    </div>
</div>
