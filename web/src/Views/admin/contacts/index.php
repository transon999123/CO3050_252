<div class="card shadow border-0">
    <div class="card-body">
        <h4 class="header-title">Danh Sách Tin Nhắn Liên Hệ</h4>
        
        <div class="table-responsive mt-3">
            <table class="table table-bordered table-hover">
                <thead class="bg-light text-center">
                    <tr>
                        <th>Ngày gửi</th>
                        <th>Người gửi</th>
                        <th>Email</th>
                        <th>Tiêu đề</th>
                        <th>Nội dung</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contacts as $c): ?>
                        <tr>
                            <td class="text-center align-middle"><?= date('d/m/Y H:i', strtotime($c['created_at'])) ?></td>
                            <td class="font-weight-bold align-middle"><?= htmlspecialchars($c['name']) ?></td>
                            <td class="align-middle"><?= htmlspecialchars($c['email']) ?></td>
                            <td class="align-middle font-weight-bold text-primary"><?= htmlspecialchars($c['subject']) ?></td>
                            <td class="align-middle"><small><?= nl2br(htmlspecialchars($c['message'])) ?></small></td>
                            <td class="text-center align-middle">
                                <?php if($c['status'] == 'unread'): ?>
                                    <span class="badge badge-danger">Chưa đọc</span>
                                <?php elseif($c['status'] == 'read'): ?>
                                    <span class="badge badge-info">Đã đọc</span>
                                <?php else: ?>
                                    <span class="badge badge-success">Đã phản hồi</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center align-middle">
                                <a href="mailto:<?= htmlspecialchars($c['email']) ?>?subject=Phản hồi: <?= htmlspecialchars($c['subject']) ?>" class="btn btn-sm btn-primary mb-1" title="Trả lời qua Email"><i class="fa fa-reply"></i> Trả lời</a>
                                <br>
                                <?php if($c['status'] == 'unread'): ?>
                                    <a href="index.php?controller=adminContact&action=updateStatus&id=<?= $c['id'] ?>&status=read" class="btn btn-sm btn-outline-info mb-1" title="Đánh dấu đã đọc"><i class="fa fa-check"></i> Đã đọc</a>
                                <?php else: ?>
                                    <a href="index.php?controller=adminContact&action=updateStatus&id=<?= $c['id'] ?>&status=unread" class="btn btn-sm btn-outline-secondary mb-1" title="Đánh dấu chưa đọc"><i class="fa fa-eye-slash"></i> Chưa đọc</a>
                                <?php endif; ?>
                                <br>
                                <a href="index.php?controller=adminContact&action=updateStatus&id=<?= $c['id'] ?>&status=replied" class="btn btn-sm btn-outline-success mb-1" title="Tick Đã Phản Hồi"><i class="fa fa-check-circle"></i> Tick Phản hồi</a>
                                <a href="index.php?controller=adminContact&action=delete&id=<?= $c['id'] ?>" class="btn btn-sm btn-outline-danger mb-1" title="Xóa" onclick="return confirm('Xóa liên hệ này?');"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
