<div class="card shadow border-0">
    <div class="card-body">
        <h4 class="header-title">Danh Sách Đơn Hàng</h4>
        
        <div class="table-responsive mt-3">
            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>Mã Đơn</th>
                        <th>Khách Hàng</th>
                        <th>Ngày Đặt</th>
                        <th>Tổng Tiền</th>
                        <th>Trạng Thái</th>
                        <th>Cập Nhật</th>
                        <th>Chi Tiết</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $o): ?>
                        <tr>
                            <td class="font-weight-bold">#<?= $o['id'] ?></td>
                            <td><?= htmlspecialchars($o['user_name']) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($o['created_at'])) ?></td>
                            <td class="text-danger font-weight-bold"><?= number_format($o['total_price'], 0, ',', '.') ?>đ</td>
                            <td>
                                <?php
                                    $badge = 'secondary';
                                    if($o['status'] == 'pending') $badge = 'warning';
                                    if($o['status'] == 'processing') $badge = 'info';
                                    if($o['status'] == 'shipped') $badge = 'primary';
                                    if($o['status'] == 'delivered') $badge = 'success';
                                    if($o['status'] == 'cancelled') $badge = 'danger';
                                ?>
                                <span class="badge badge-<?= $badge ?> p-2"><?= strtoupper($o['status']) ?></span>
                            </td>
                            <td>
                                <form action="index.php?controller=adminOrder&action=updateStatus" method="POST" class="form-inline justify-content-center">
                                    <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                                    <select name="status" class="form-control form-control-sm mr-2">
                                        <option value="pending" <?= $o['status'] == 'pending' ? 'selected' : '' ?>>Chờ xử lý</option>
                                        <option value="processing" <?= $o['status'] == 'processing' ? 'selected' : '' ?>>Đang xử lý</option>
                                        <option value="shipped" <?= $o['status'] == 'shipped' ? 'selected' : '' ?>>Đang giao</option>
                                        <option value="delivered" <?= $o['status'] == 'delivered' ? 'selected' : '' ?>>Đã giao</option>
                                        <option value="cancelled" <?= $o['status'] == 'cancelled' ? 'selected' : '' ?>>Đã hủy</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i></button>
                                </form>
                            </td>
                            <td>
                                <a href="index.php?controller=adminOrder&action=detail&id=<?= $o['id'] ?>" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
