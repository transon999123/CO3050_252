<div class="card shadow border-0">
    <div class="card-body">
        <h4 class="header-title">Danh Sách Bình Luận</h4>
        
        <div class="table-responsive mt-3">
            <table class="table table-bordered table-hover text-center">
                <thead class="bg-light text-capitalize">
                    <tr>
                        <th>ID</th>
                        <th>Người Bình Luận</th>
                        <th>Bài Viết</th>
                        <th>Nội Dung</th>
                        <th>Trạng Thái</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($comments) > 0): ?>
                        <?php foreach ($comments as $c): ?>
                            <tr class="<?= $c['status'] == 'pending' ? 'bg-light' : '' ?>">
                                <td class="align-middle"><?= $c['id'] ?></td>
                                <td class="align-middle font-weight-bold"><?= htmlspecialchars($c['full_name']) ?></td>
                                <td class="align-middle text-left text-primary"><?= htmlspecialchars($c['news_title']) ?></td>
                                <td class="align-middle text-left"><?= nl2br(htmlspecialchars($c['content'])) ?></td>
                                <td class="align-middle">
                                    <?php if($c['status'] == 'approved'): ?>
                                        <span class="badge badge-success">Đã duyệt</span>
                                    <?php elseif($c['status'] == 'pending'): ?>
                                        <span class="badge badge-warning">Chờ duyệt</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">Spam</span>
                                    <?php endif; ?>
                                </td>
                                <td class="align-middle">
                                    <?php if($c['status'] == 'pending' || $c['status'] == 'spam'): ?>
                                        <a href="index.php?controller=adminComment&action=updateStatus&id=<?= $c['id'] ?>&status=approved" class="btn btn-sm btn-outline-success mb-1" title="Duyệt"><i class="fa fa-check"></i></a>
                                    <?php endif; ?>
                                    
                                    <?php if($c['status'] == 'approved' || $c['status'] == 'pending'): ?>
                                        <a href="index.php?controller=adminComment&action=updateStatus&id=<?= $c['id'] ?>&status=spam" class="btn btn-sm btn-outline-warning mb-1" title="Đánh dấu Spam"><i class="fa fa-ban"></i></a>
                                    <?php endif; ?>
                                    
                                    <a href="index.php?controller=adminComment&action=delete&id=<?= $c['id'] ?>" class="btn btn-sm btn-outline-danger mb-1" title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này?');"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6">Chưa có bình luận nào.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
