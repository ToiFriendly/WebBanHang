<?php include 'app/views/shares/header.php'; ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<div class="container mt-5">
    <h2 class="mb-4">Thêm Người Dùng Mới</h2>

    <form method="POST" action="/webbanhang/account/save" class="row g-3" enctype="multipart/form-data">
        <div class="col-md-6">
            <label for="username" class="form-label">Username:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="col-md-6">
            <label for="fullname" class="form-label">Full Name:</label>
            <input type="text" class="form-control" id="fullname" name="fullname" required>
        </div>
        <div class="col-md-6">
            <label for="password" class="form-label">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="col-md-6">
            <label for="confirmpassword" class="form-label">Confirm Password:</label>
            <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" required>
        </div>
        <div class="col-md-6">
            <label for="role" class="form-label">Role:</label>
            <select class="form-select" id="role" name="role" required>
                <option value="user" selected>User</option>
                <option value="admin" disabled>Admin</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="gmail" class="form-label">Gmail:</label>
            <input type="email" class="form-control" id="gmail" name="gmail">
        </div>
        <div class="col-md-6">
            <label for="phone" class="form-label">Phone:</label>
            <input type="text" class="form-control" id="phone" name="phone">
        </div>
        <div class="col-md-6">
            <label for="image" class="form-label">Image:</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Thêm Người Dùng</button>
            <a href="/webbanhang/account/index" class="btn btn-secondary">Quay Lại</a>
        </div>
    </form>
</div>

<?php include 'app/views/shares/footer.php'; ?>