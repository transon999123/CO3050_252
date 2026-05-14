<!-- src/Views/profile/orders.php -->
<div class="container mt-5 mb-5">
    <div class="row">
        <!-- Sidebar Menu Profile -->
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="index.php?controller=profile&action=index" class="list-group-item list-group-item-action"><i class="fa fa-user mr-2"></i> Thông Tin Cá Nhân</a>
                        <a href="index.php?controller=profile&action=orders" class="list-group-item list-group-item-action active text-white bg-primary"><i class="fa fa-shopping-bag mr-2"></i> Lịch Sử Đơn Hàng</a>
                        <a href="index.php?controller=auth&action=logout" class="list-group-item list-group-item-action text-danger"><i class="fa fa-sign-out mr-2"></i> Đăng Xuất</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order List Content -->
        <div class="col-md-9">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="font-weight-bold border-bottom pb-3 mb-4">Trạng Thái Đơn Hàng Của Bạn</h4>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center">
                            <thead class="bg-light">
                                <tr>
                                    <th>Mã Đơn</th>
                                    <th>Ngày Đặt</th>
                                    <th>Tổng Tiền</th>
                                    <th>Trạng Thái</th>
                                    <th>Chi Tiết</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(count($orders) > 0): ?>
                                    <?php foreach($orders as $o): ?>
                                        <tr>
                                            <td class="align-middle font-weight-bold">#<?= $o['id'] ?></td>
                                            <td class="align-middle"><?= date('d/m/Y H:i', strtotime($o['created_at'])) ?></td>
                                            <td class="align-middle text-danger font-weight-bold"><?= number_format($o['total_price'], 0, ',', '.') ?>đ</td>
                                            <td class="align-middle">
                                                <?php 
                                                    $status = $o['status'];
                                                    if ($status == 'pending') echo '<span class="badge badge-warning p-2">Chờ xử lý</span>';
                                                    elseif ($status == 'processing') echo '<span class="badge badge-info p-2">Đang xử lý</span>';
                                                    elseif ($status == 'shipped') echo '<span class="badge badge-primary p-2">Đang giao hàng</span>';
                                                    elseif ($status == 'delivered') echo '<span class="badge badge-success p-2">Đã giao thành công</span>';
                                                    elseif ($status == 'cancelled') echo '<span class="badge badge-danger p-2">Đã hủy</span>';
                                                ?>
                                            </td>
                                            <td class="align-middle">
                                                <a href="index.php?controller=profile&action=detail&id=<?= $o['id'] ?>" class="btn btn-sm btn-outline-dark">Xem chi tiết</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="py-5">
                                            <h5 class="text-muted"><i class="fa fa-box-open fa-2x mb-3"></i><br>Bạn chưa có đơn hàng nào!</h5>
                                            <a href="index.php?controller=product&action=index" class="btn btn-primary mt-3">Tiếp tục mua sắm</a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
