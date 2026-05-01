<div class="row mt-4">
    <div class="col-md-4">
        <div class="card shadow border-0">
            <div class="card-body">
                <h5 class="font-weight-bold border-bottom pb-2 mb-3">Thông tin Đơn hàng #<?= $order['id'] ?></h5>
                <p><strong>Khách hàng:</strong> <?= htmlspecialchars($order['full_name']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($order['email']) ?></p>
                <p><strong>SĐT:</strong> <?= htmlspecialchars($order['shipping_phone']) ?></p>
                <p><strong>Địa chỉ giao hàng:</strong> <?= htmlspecialchars($order['shipping_address']) ?></p>
                <p><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i:s', strtotime($order['created_at'])) ?></p>
                <p><strong>Trạng thái:</strong> <span class="badge badge-info p-2"><?= strtoupper($order['status']) ?></span></p>
                <a href="index.php?controller=adminOrder&action=index" class="btn btn-secondary mt-3"><i class="fa fa-arrow-left"></i> Quay lại Danh sách</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card shadow border-0">
            <div class="card-body">
                <h5 class="font-weight-bold border-bottom pb-2 mb-3">Chi tiết Sản phẩm trong đơn</h5>
                <div class="table-responsive">
                    <table class="table text-center align-middle table-striped">
                        <thead class="bg-light">
                            <tr>
                                <th>Ảnh</th>
                                <th>Tên SP</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($items as $i): ?>
                            <tr>
                                <?php $firstImg = explode(',', $i['image'])[0] ?? 'default.jpg'; ?>
                                <td><img src="uploads/products/<?= htmlspecialchars($firstImg) ?>" width="60" class="rounded" onerror="this.src='https://via.placeholder.com/60'"></td>
                                <td class="text-left font-weight-bold"><?= htmlspecialchars($i['product_name']) ?></td>
                                <td><?= $i['quantity'] ?></td>
                                <td class="text-danger"><?= number_format($i['price'], 0, ',', '.') ?>đ</td>
                                <td class="text-danger font-weight-bold"><?= number_format($i['price'] * $i['quantity'], 0, ',', '.') ?>đ</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="bg-light">
                            <tr>
                                <td colspan="4" class="text-right font-weight-bold">Tổng thanh toán:</td>
                                <td class="text-danger font-weight-bold h4"><?= number_format($order['total_price'], 0, ',', '.') ?>đ</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
