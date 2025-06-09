<?php include 'app/views/shares/header.php'; ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="mb-0">Chỉnh Sửa Hồ Sơ</h3>
                </div>
                <div class="card-body">
                    <?php if (isset($account)): ?>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="fullname" class="form-control" value="<?php echo htmlspecialchars($account->fullname); ?>">
                                <?php if (isset($errors['fullname'])) echo "<p class='text-danger'>{$errors['fullname']}</p>"; ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password (Để trống nếu không đổi)</label>
                                <input type="password" name="password" class="form-control">
                                <?php if (isset($errors['password'])) echo "<p class='text-danger'>{$errors['password']}</p>"; ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Gmail</label>
                                <input type="email" name="gmail" class="form-control" value="<?php echo htmlspecialchars($account->gmail ?? ''); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($account->phone ?? ''); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Image</label>
                                <input type="file" name="image" class="form-control">
                                <?php if (isset($errors['image'])) echo "<p class='text-danger'>{$errors['image']}</p>"; ?>
                                <img src="<?php echo htmlspecialchars($account->image ?? 'uploads/default-avt.jpg'); ?>" class="rounded-circle mt-2" alt="Avatar" width="100" height="100" style="object-fit: cover;">
                            </div>
                            <button type="submit" class="btn btn-primary">Lưu Thay Đổi</button>
                            <a href="/webbanhang/account/show" class="btn btn-secondary">Hủy</a>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-danger" role="alert">
                            Không tìm thấy thông tin người dùng.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>