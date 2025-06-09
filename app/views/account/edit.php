<?php include 'app/views/shares/header.php'; ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<div class="container mt-5">
    <h2 class="mb-4">Cập Nhật Thông Tin Người Dùng</h2>

    <?php if (isset($account)): ?>
        <form method="POST" action="/webbanhang/account/update" class="row g-3" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($account->id); ?>">
            <div class="col-md-6">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($account->username); ?>" required>
            </div>
            <div class="col-md-6">
                <label for="fullname" class="form-label">Full Name:</label>
                <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo htmlspecialchars($account->fullname); ?>" required>
            </div>
            <div class="col-md-6">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Nhập password mới (không bắt buộc)">
            </div>
            <div class="col-md-6">
                <label for="role" class="form-label">Role:</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="user" <?php echo $account->role === 'user' ? 'selected' : ''; ?>>User</option>
                    <option value="admin" <?php echo $account->role === 'admin' ? 'selected' : ''; ?>>Admin</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="gmail" class="form-label">Gmail:</label>
                <input type="email" class="form-control" id="gmail" name="gmail" value="<?php echo htmlspecialchars($account->gmail ?? ''); ?>">
            </div>
            <div class="col-md-6">
                <label for="phone" class="form-label">Phone:</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($account->phone ?? ''); ?>">
            </div>
            <div class="col-md-6">
                <label for="image" class="form-label">Image:</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                <?php if ($account->image && $account->image !== 'default-avt.jpg'): ?>
                    <p>Hình hiện tại: <img src="<?php echo htmlspecialchars($account->image); ?>" width="100"></p>
                <?php endif; ?>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-success">Cập Nhật</button>
                <a href="/webbanhang/account/index" class="btn btn-secondary">Quay Lại</a>
            </div>
        </form>
    <?php else: ?>
        <p class="alert alert-danger">Không tìm thấy thông tin người dùng.</p>
    <?php endif; ?>
</div>

<?php include 'app/views/shares/footer.php'; ?>