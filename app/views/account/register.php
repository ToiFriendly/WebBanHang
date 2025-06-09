<?php include 'app/views/shares/header.php'; ?>

<!-- Thêm CDN Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<div class="container mt-5">
    <div class="card bg-light">
        <div class="card-body p-5 text-center">
            <h2 class="fw-bold mb-4 text-uppercase">Register</h2>

            <?php
            if (isset($errors)) {
                echo "<div class='alert alert-danger' role='alert'><ul>";
                foreach ($errors as $err) {
                    echo "<li>$err</li>";
                }
                echo "</ul></div>";
            }
            ?>

            <form action="/webbanhang/account/save" method="post" enctype="multipart/form-data" class="row g-3">
                <div class="col-md-6">
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                </div>
                <div class="col-md-6">
                    <label for="fullname" class="form-label">Full Name:</label>
                    <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Full Name" required>
                </div>
                <div class="col-md-6">
                    <label for="gmail" class="form-label">Gmail:</label>
                    <input type="email" class="form-control" id="gmail" name="gmail" placeholder="Gmail">
                </div>
                <div class="col-md-6">
                    <label for="phone" class="form-label">Phone:</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone">
                </div>
                <div class="col-md-6">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                </div>
                <div class="col-md-6">
                    <label for="confirmpassword" class="form-label">Confirm Password:</label>
                    <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password" required>
                </div>
                <div class="col-md-6">
                    <label for="image" class="form-label">Image:</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-lg">Register</button>
                    <a href="/webbanhang/account/login" class="btn btn-secondary btn-lg ms-2">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>