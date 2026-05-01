<div class="card shadow border-0">
    <div class="card-body">
        <h4 class="header-title">Danh Sách Thành Viên</h4>
        
        <div class="table-responsive mt-3">
            <table class="table table-bordered table-striped text-center">
                <thead class="bg-light text-capitalize">
                    <tr>
                        <th>ID</th>
                        <th>Avatar</th>
                        <th>Username</th>
                        <th>Họ Tên</th>
                        <th>Email</th>
                        <th>Vai Trò</th>
                        <th>Trạng thái</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                        <tr class="<?= isset($u['status']) && $u['status'] === 'banned' ? 'bg-light text-muted' : '' ?>">
                            <td class="align-middle"><?= $u['id'] ?></td>
                            <td class="align-middle"><img src="uploads/avatars/<?= htmlspecialchars($u['avatar']) ?>" width="40" height="40" class="rounded-circle shadow-sm" onerror="this.src='https://via.placeholder.com/40'"></td>
                            <td class="font-weight-bold align-middle">@<?= htmlspecialchars($u['username']) ?></td>
                            <td class="align-middle"><?= htmlspecialchars($u['full_name']) ?></td>
                            <td class="align-middle"><?= htmlspecialchars($u['email']) ?></td>
                            <td class="align-middle">
                                <?= $u['role'] === 'admin' ? '<span class="badge badge-danger">Admin</span>' : '<span class="badge badge-info">Member</span>' ?>
                            </td>
                            <td class="align-middle">
                                <?php if(isset($u['status']) && $u['status'] === 'banned'): ?>
                                    <span class="badge badge-warning">Đã khóa</span>
                                <?php else: ?>
                                    <span class="badge badge-success">Hoạt động</span>
                                <?php endif; ?>
                            </td>
                            <td class="align-middle">
                                <?php if($u['id'] !== $_SESSION['user_id']): ?>
                                    
                                    <!-- Nút đổi quyền -->
                                    <?php if($u['role'] === 'admin'): ?>
                                        <a href="index.php?controller=adminUser&action=setRole&role=member&id=<?= $u['id'] ?>" class="btn btn-sm btn-outline-secondary mb-1" title="Hủy quyền Admin" onclick="return confirm('Hạ cấp người này xuống Thành Viên?');"><i class="fa fa-arrow-down"></i> Hủy Admin</a>
                                    <?php else: ?>
                                        <a href="index.php?controller=adminUser&action=setRole&role=admin&id=<?= $u['id'] ?>" class="btn btn-sm btn-outline-info mb-1" title="Cấp quyền Admin" onclick="return confirm('Thăng cấp người này làm Quản Trị Viên?');"><i class="fa fa-arrow-up"></i> Cấp Admin</a>
                                    <?php endif; ?>

                                    <!-- Nút Khóa/Mở khóa (chỉ áp dụng nếu không phải admin, hoặc có thể khóa admin tùy ý) -->
                                    <?php if($u['role'] !== 'admin'): ?>
                                        <?php if(isset($u['status']) && $u['status'] === 'banned'): ?>
                                            <a href="index.php?controller=adminUser&action=ban&type=unban&id=<?= $u['id'] ?>" class="btn btn-sm btn-outline-success mx-1 mb-1" title="Mở khóa"><i class="fa fa-unlock"></i> Mở khóa</a>
                                        <?php else: ?>
                                            <a href="index.php?controller=adminUser&action=ban&type=ban&id=<?= $u['id'] ?>" class="btn btn-sm btn-outline-warning mx-1 mb-1" title="Khóa tài khoản" onclick="return confirm('Bạn có chắc chắn muốn khóa tài khoản này?');"><i class="fa fa-ban"></i> Khóa</a>
                                        <?php endif; ?>
                                        <!-- Nút Xóa -->
                                        <a href="index.php?controller=adminUser&action=delete&id=<?= $u['id'] ?>" class="btn btn-sm btn-outline-danger mb-1" title="Xóa" onclick="return confirm('Bạn có muốn xóa thành viên này vĩnh viễn?');"><i class="fa fa-trash"></i> Xóa</a>
                                    <?php endif; ?>
                                    
                                <?php else: ?>
                                    <span class="badge badge-success px-3 py-2"><i class="fa fa-user"></i> Bạn (Đang đăng nhập)</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
