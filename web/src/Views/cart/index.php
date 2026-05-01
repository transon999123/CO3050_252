<!-- src/Views/cart/index.php -->
<nav aria-label="breadcrumb">
  <ol class="breadcrumb bg-white shadow-sm mt-3 border">
    <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
    <li class="breadcrumb-item active">Giỏ hàng của bạn</li>
  </ol>
</nav>

<div class="row mt-4 mb-5">
    <div class="col-md-8 mb-4">
        <div class="card shadow border-0">
            <div class="card-body">
                <h4 class="font-weight-bold mb-4 border-bottom pb-3"><i class="fa fa-shopping-cart text-danger"></i> Chi Tiết Giỏ Hàng</h4>
                
                <?php if(empty($_SESSION['cart'])): ?>
                    <div class="text-center py-5">
                        <i class="fa fa-box-open fa-4x text-muted mb-3 opacity-50"></i>
                        <h5 class="text-muted">Giỏ hàng của bạn đang trống!</h5>
                        <a href="index.php?controller=product&action=index" class="btn btn-primary mt-4 px-4 py-2">Tiếp tục mua sắm</a>
                    </div>
                <?php else: ?>
                    <form action="index.php?controller=cart&action=update" method="POST">
                        <div class="table-responsive">
                            <table class="table align-middle text-center border">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-left">Sản phẩm</th>
                                        <th>Đơn giá</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                        <th>Xóa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total = 0; foreach($_SESSION['cart'] as $id => $item): ?>
                                    <?php $subtotal = $item['price'] * $item['qty']; $total += $subtotal; ?>
                                    <tr>
                                        <td class="text-left d-flex align-items-center">
                                            <?php $firstImg = explode(',', $item['image'])[0] ?? 'default.jpg'; ?>
                                            <img src="uploads/products/<?= htmlspecialchars($firstImg) ?>" width="60" class="rounded mr-3 border" onerror="this.src='https://via.placeholder.com/60'">
                                            <span class="font-weight-bold"><?= htmlspecialchars($item['name']) ?></span>
                                        </td>
                                        <td class="text-danger font-weight-bold align-middle"><?= number_format($item['price'], 0, ',', '.') ?>đ</td>
                                        <td class="align-middle">
                                            <input type="number" name="qty[<?= $id ?>]" value="<?= $item['qty'] ?>" min="1" class="form-control text-center mx-auto" style="width: 80px;">
                                        </td>
                                        <td class="text-danger font-weight-bold align-middle"><?= number_format($subtotal, 0, ',', '.') ?>đ</td>
                                        <td class="align-middle">
                                            <a href="index.php?controller=cart&action=remove&id=<?= $id ?>" class="text-danger border p-2 rounded hover-shadow" title="Xóa"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-between mt-4">
                            <a href="index.php?controller=product&action=index" class="btn btn-outline-secondary"><i class="fa fa-arrow-left"></i> Chọn thêm đồ</a>
                            <button type="submit" class="btn btn-outline-info"><i class="fa fa-sync"></i> Cập nhật thay đổi</button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <?php if(!empty($_SESSION['cart'])): ?>
    <div class="col-md-4">
        <div class="card shadow border-0 bg-light">
            <div class="card-body p-4">
                <h4 class="font-weight-bold mb-4 border-bottom pb-2">Hóa Đơn</h4>
                
                <div class="d-flex justify-content-between mb-3 text-muted">
                    <span>Tạm tính:</span>
                    <span class="font-weight-bold text-dark"><?= number_format($total, 0, ',', '.') ?> đ</span>
                </div>
                <div class="d-flex justify-content-between mb-3 text-muted">
                    <span>Phí vận chuyển (COD):</span>
                    <span class="font-weight-bold text-success">Miễn phí</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-4">
                    <span class="font-weight-bold h5">Thanh toán:</span>
                    <span class="font-weight-bold text-danger h4"><?= number_format($total, 0, ',', '.') ?> đ</span>
                </div>
                
                <h5 class="font-weight-bold mt-5 mb-3">Thông Tin Giao Hàng</h5>
                
                <?php if(!isset($_SESSION['user_id'])): ?>
                    <div class="alert alert-warning text-center rounded shadow-sm">
                        Bạn phải <a href="index.php?controller=auth&action=login" class="font-weight-bold alert-link">Đăng Nhập</a> để đặt hàng!
                    </div>
                <?php else: ?>
                    <form action="index.php?controller=cart&action=checkout" method="POST">
                        <div class="form-group">
                            <label class="font-weight-bold">Tên người nhận</label>
                            <input type="text" class="form-control bg-white" value="<?= htmlspecialchars($_SESSION['full_name']) ?>" disabled>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Tỉnh/Thành phố <span class="text-danger">*</span></label>
                                <select name="city" class="form-control bg-white" required>
                                    <option value="TP.HCM">Hồ Chí Minh</option>
                                    <option value="Hà Nội">Hà Nội</option>
                                    <option value="Đà Nẵng">Đà Nẵng</option>
                                    <option value="Cần Thơ">Cần Thơ</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold">Quận/Huyện <span class="text-danger">*</span></label>
                                <input type="text" name="district" class="form-control bg-white" placeholder="VD: Quận 1..." required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Số nhà, Tên đường <span class="text-danger">*</span></label>
                            <input type="text" name="street" class="form-control bg-white" placeholder="VD: 268 Lý Thường Kiệt..." required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="text" name="shipping_phone" class="form-control bg-white" placeholder="SĐT liên lạc..." required>
                        </div>
                        <button type="submit" class="btn btn-danger btn-block btn-lg mt-4 shadow font-weight-bold"><i class="fa fa-paper-plane mr-2"></i> ĐẶT HÀNG NGAY</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
