<!-- src/Views/admin/news/create.php -->
<div class="row">
    <div class="col-md-12">
        <div class="card shadow border-0">
            <div class="card-body">
                <h4 class="header-title border-bottom pb-2 mb-4"><i class="fa fa-newspaper-o mr-2"></i> Thêm Bài Viết Mới</h4>
                
                <?php if(!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach($errors as $err): ?>
                                <li><?= htmlspecialchars($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="index.php?controller=adminNews&action=create" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="font-weight-bold">Tiêu đề bài viết <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" value="<?= htmlspecialchars($old['title'] ?? '') ?>" placeholder="Nhập tiêu đề..." required>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Ảnh đại diện (Thumbnail)</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="newsImage" name="image" accept="image/*">
                            <label class="custom-file-label" for="newsImage" data-browse="Chọn file">Chọn hình ảnh</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Nội dung bài viết <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="content" rows="15" placeholder="Nhập nội dung bài viết..." required><?= htmlspecialchars($old['content'] ?? '') ?></textarea>
                    </div>

                    <div class="text-center mt-4 border-top pt-3">
                        <button type="submit" class="btn btn-primary px-5"><i class="fa fa-save"></i> Đăng Bài</button>
                        <a href="index.php?controller=adminNews&action=index" class="btn btn-secondary px-4 ml-2">Quay lại</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
// Script nhỏ để hiển thị tên file khi chọn ảnh trên Bootstrap Custom File Input
document.querySelector('.custom-file-input').addEventListener('change',function(e){
  var fileName = document.getElementById("newsImage").files[0].name;
  var nextSibling = e.target.nextElementSibling;
  nextSibling.innerText = fileName;
});
</script>
