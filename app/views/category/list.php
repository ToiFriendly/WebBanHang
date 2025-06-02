<?php include 'app/views/shares/header.php'; ?>
<div class="container mt-5">
    <h1 class="text-center mb-4">Danh sách danh mục</h1>
    <a href="/webbanhang/Category/add" class="btn btn-primary mb-3">➕ Thêm danh mục</a>

    <table class="table table-bordered table-hover bg-white shadow-sm">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Tên danh mục</th>
                <th>Mô tả</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?php echo $category->id; ?></td>
                    <td><?php echo htmlspecialchars($category->name); ?></td>
                    <td><?php echo htmlspecialchars($category->description); ?></td>
                    <td>
                        <a href="/webbanhang/Category/edit?id=<?php echo $category->id; ?>" class="btn btn-sm btn-warning">Sửa</a>
                        <a href="/webbanhang/Category/delete?id=<?php echo $category->id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include 'app/views/shares/footer.php'; ?>