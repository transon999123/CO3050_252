<!-- src/Views/profile/order_detail.php -->
<nav aria-label="breadcrumb">
  <ol class="breadcrumb bg-white shadow-sm mt-3 border">
    <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
    <li class="breadcrumb-item"><a href="index.php?controller=profile&action=orders">Lịch sử đơn hàng</a></li>
    <li class="breadcrumb-item active">Đơn hàng #<?= $order['id'] ?></li>
  </ol>
</nav>

<div class="container mt-5 mb-5">
    <div class="row">
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

        <div class="col-md-9">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="font-weight-bold">Chi Tiết Đơn Hàng #<?= $order['id'] ?></h4>
                            <p class="text-muted mb-0">Ngày đặt: <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></p>
                        </div>
                        <div>
                            <?php
                                $status = $order['status'];
                                if ($status == 'pending') echo '<span class="badge badge-warning p-2">Chờ xử lý</span>';
                                elseif ($status == 'processing') echo '<span class="badge badge-info p-2">Đang xử lý</span>';
                                elseif ($status == 'shipped') echo '<span class="badge badge-primary p-2">Đang giao hàng</span>';
                                elseif ($status == 'delivered') echo '<span class="badge badge-success p-2">Đã giao thành công</span>';
                                elseif ($status == 'cancelled') echo '<span class="badge badge-danger p-2">Đã hủy</span>';
                            ?>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <h5 class="font-weight-bold">Thông tin giao hàng</h5>
                            <p class="mb-1"><strong>Địa chỉ:</strong><br><?= nl2br(htmlspecialchars($order['shipping_address'])) ?></p>
                            <p class="mb-1"><strong>Số điện thoại:</strong> <?= htmlspecialchars($order['shipping_phone']) ?></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h5 class="font-weight-bold">Tổng đơn hàng</h5>
                            <p class="text-danger font-weight-bold" style="font-size: 1.7rem;"><?= number_format($order['total_price'], 0, ',', '.') ?>đ</p>
                        </div>
                    </div>

                    <div class="table-responsive mb-4">
                        <table class="table table-bordered table-hover text-center">
                            <thead class="bg-light">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Hình ảnh</th>
                                    <th>Số lượng</th>
                                    <th>Đơn giá</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $item): ?>
                                    <tr>
                                        <td class="align-middle text-left">
                                            <a href="index.php?controller=product&action=detail&id=<?= $item['product_id'] ?>" class="font-weight-bold text-dark"><?= htmlspecialchars($item['product_name']) ?></a>
                                        </td>
                                        <td class="align-middle">
                                            <?php $img = explode(',', $item['product_image'])[0] ?? 'default.jpg'; ?>
                                            <img src="uploads/products/<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>" style="width: 80px; height: 80px; object-fit: cover;" onerror="this.src='https://via.placeholder.com/80'">
                                        </td>
                                        <td class="align-middle"><?= $item['quantity'] ?></td>
                                        <td class="align-middle text-danger font-weight-bold"><?= number_format($item['price'], 0, ',', '.') ?>đ</td>
                                        <td class="align-middle text-danger font-weight-bold"><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>đ</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if ($order['status'] == 'pending'): ?>
                        <form action="index.php?controller=profile&action=cancelOrder" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?');">
                            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                            <button type="submit" class="btn btn-danger mr-2">Hủy đơn</button>
                        </form>
                    <?php endif; ?>

                    <?php if ($order['status'] == 'shipped'): ?>
                        <form action="index.php?controller=profile&action=confirmOrder" method="POST" onsubmit="return confirm('Xác nhận đã nhận hàng?');">
                            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                            <button type="submit" class="btn btn-success">Xác nhận đã nhận hàng</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ($order['status'] == 'delivered'): ?>
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h4 class="font-weight-bold border-bottom pb-3 mb-4">Đánh giá sản phẩm</h4>
                        <?php foreach ($items as $item): ?>
                            <?php if (!in_array($item['product_id'], $reviewedProductIds)): ?>
                                <div class="border rounded p-3 mb-4">
                                    <h5 class="font-weight-bold"><?= htmlspecialchars($item['product_name']) ?></h5>
                                    <form action="index.php?controller=profile&action=submitReview" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                        <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">

                                        <div class="form-group">
                                            <label for="rating_<?= $item['product_id'] ?>">Đánh giá sao</label>
                                            <select id="rating_<?= $item['product_id'] ?>" name="rating" class="form-control" style="width: 120px;">
                                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                                    <option value="<?= $i ?>"><?= $i ?> sao</option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="comment_<?= $item['product_id'] ?>">Nhận xét</label>
                                            <textarea id="comment_<?= $item['product_id'] ?>" name="comment" class="form-control" rows="3" required></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="review_image_<?= $item['product_id'] ?>">Ảnh đánh giá (tùy chọn)</label>
                                            <input type="file" id="review_image_<?= $item['product_id'] ?>" name="review_image" accept="image/*" class="form-control-file">
                                        </div>

                                        <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php if (count($items) === 0 || count($reviewedProductIds) === count($items)): ?>
                            <div class="alert alert-info">Bạn đã đánh giá tất cả sản phẩm trong đơn hàng này.</div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
