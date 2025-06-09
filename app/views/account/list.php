<?php include 'app/views/shares/header.php'; ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<div class="container mt-5">
    <h2 class="mb-4">Danh Sách Người Dùng</h2>

    <?php if (isset($account) && is_array($account) && count($account) > 0): ?>
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Role</th>
                    <th>Gmail</th>
                    <th>Phone</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($account as $acc): ?>
                    <?php if ($acc->role === 'user'): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($acc->id); ?></td>
                            <td><?php echo htmlspecialchars($acc->username); ?></td>
                            <td><?php echo htmlspecialchars($acc->fullname); ?></td>
                            <td><?php echo htmlspecialchars($acc->role); ?></td>
                            <td><?php echo htmlspecialchars($acc->gmail ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($acc->phone ?? ''); ?></td>
                            <td>
                                <a href="/webbanhang/account/edit?id=<?php echo $acc->id; ?>" class="btn btn-warning btn-sm">Sửa</a>
                                <a href="/webbanhang/account/delete?id=<?php echo $acc->id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="alert alert-warning">Không có người dùng nào với role 'user'.</p>
    <?php endif; ?>

    <a href="/webbanhang/account/add" class="btn btn-primary mt-3">Thêm Người Dùng</a>
</div>

<?php include 'app/views/shares/footer.php'; ?>