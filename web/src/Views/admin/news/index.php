<div class="card shadow border-0">
    <div class="card-body">
        <h4 class="header-title">Danh Sách Tin Tức</h4>
        
        <div class="row mb-3 mt-3">
            <div class="col-12">
                <a href="index.php?controller=adminNews&action=create" class="btn btn-primary"><i class="ti-plus"></i> Thêm Bài Viết</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center">
                <thead class="bg-light text-capitalize">
                    <tr>
                        <th>ID</th>
                        <th>Hình Ảnh</th>
                        <th>Tiêu Đề</th>
                        <th>Tác Giả</th>
                        <th>Lượt Xem</th>
                        <th>Ngày Đăng</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($news) > 0): ?>
                        <?php foreach ($news as $n): ?>
                            <tr>
                                <td class="align-middle"><?= $n['id'] ?></td>
                                <td class="align-middle"><img src="uploads/news/<?= htmlspecialchars($n['thumbnail']) ?>" width="80" onerror="this.src='https://via.placeholder.com/80'"></td>
                                <td class="align-middle text-left font-weight-bold text-primary"><?= htmlspecialchars($n['title']) ?></td>
                                <td class="align-middle"><?= htmlspecialchars($n['author_name']) ?></td>
                                <td class="align-middle"><?= $n['views'] ?></td>
                                <td class="align-middle"><?= date('d/m/Y', strtotime($n['created_at'])) ?></td>
                                <td class="align-middle">
                                    <a href="#" class="btn btn-sm btn-outline-primary" onclick="alert('Tính năng Sửa tin tức đang được nâng cấp!');"><i class="fa fa-edit"></i> Sửa</a>
                                    <a href="index.php?controller=adminNews&action=delete&id=<?= $n['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này không?');"><i class="fa fa-trash"></i> Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7">Chưa có bài viết nào.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
