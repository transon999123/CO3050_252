<div class="container mt-4 mb-5">
    <h2 class="font-weight-bold border-bottom pb-2 mb-4">Tin Tức Khuyến Mãi & Thời Trang</h2>
    <div class="row">
        <?php if(!empty($newsList)): ?>
            <?php foreach($newsList as $news): ?>
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <img src="uploads/<?= htmlspecialchars($news['thumbnail'] ?? 'default_news.jpg') ?>" class="card-img h-100" style="object-fit: cover;" onerror="this.src='https://via.placeholder.com/300x200?text=News'">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body d-flex flex-column h-100">
                                    <h5 class="card-title font-weight-bold"><?= htmlspecialchars($news['title']) ?></h5>
                                    <p class="card-text text-muted small"><i class="fa fa-calendar-alt"></i> <?= date('d/m/Y', strtotime($news['created_at'])) ?> | <i class="fa fa-eye"></i> <?= $news['views'] ?> lượt xem</p>
                                    <p class="card-text flex-grow-1"><?= htmlspecialchars(mb_substr($news['content'], 0, 100)) ?>...</p>
                                    <a href="index.php?controller=news&action=detail&id=<?= $news['id'] ?>" class="text-primary font-weight-bold mt-auto">Đọc tiếp &rarr;</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center text-muted">Chưa có bài viết nào.</div>
        <?php endif; ?>
    </div>
</div>
