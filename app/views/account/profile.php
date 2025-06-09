<?php include 'app/views/shares/header.php'; ?>

<!-- Thêm CDN Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="mb-0">Hồ Sơ Người Dùng</h3>
                </div>
                <div class="card-body text-center">
                    <?php if (isset($account)): ?>
                        <div class="mb-4">
                            <img src="/webbanhang/uploads/<?php echo htmlspecialchars($account->image ?? 'default-avt.jpg') . '?v=' . time(); ?>"
                                class="rounded-circle"
                                alt="Avatar"
                                width="150"
                                height="150"
                                style="object-fit: cover;">
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-bold">Username:</div>
                            <div class="col-sm-8"><?php echo htmlspecialchars($account->username); ?></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-bold">Full Name:</div>
                            <div class="col-sm-8"><?php echo htmlspecialchars($account->fullname); ?></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-bold">Role:</div>
                            <div class="col-sm-8"><?php echo htmlspecialchars($account->role); ?></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-bold">Gmail:</div>
                            <div class="col-sm-8"><?php echo htmlspecialchars($account->gmail ?? 'N/A'); ?></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-bold">Phone:</div>
                            <div class="col-sm-8"><?php echo htmlspecialchars($account->phone ?? 'N/A'); ?></div>
                        </div>
                        <div class="mt-4">
                            <a href="/webbanhang/account/editProfile" class="btn btn-primary me-2">Chỉnh Sửa</a>
                            <a href="/webbanhang/account/index" class="btn btn-secondary">Quay Lại</a>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-danger" role="alert">
                            Không thấy thông tin người dùng.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>