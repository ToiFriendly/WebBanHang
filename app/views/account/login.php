<?php include 'app/views/shares/header.php'; ?>

<!-- Thêm CDN Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-dark text-white" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                        <p class="text-white-50 mb-5">Please enter your username and password!</p>

                        <?php
                        // Hiển thị lỗi nếu có (được truyền từ checkLogin trong AccountController)
                        if (isset($error)) {
                            echo "<div class='alert alert-danger' role='alert'>{$error}</div>";
                        }
                        ?>

                        <form action="/webbanhang/account/checklogin" method="post">
                            <div class="form-outline form-white mb-4">
                                <input type="text" name="username" class="form-control form-control-lg" required />
                                <label class="form-label" for="username">Username</label>
                            </div>
                            <div class="form-outline form-white mb-4">
                                <input type="password" name="password" class="form-control form-control-lg" required />
                                <label class="form-label" for="password">Password</label>
                            </div>
                            <p class="small mb-5 pb-lg-2"><a class="text-white-50" href="#!">Forgot password?</a></p>
                            <button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>
                            <div class="d-flex justify-content-center text-center mt-4 pt-1">
                                <a href="#!" class="text-white"><i class="fab fa-facebook-f fa-lg"></i></a>
                                <a href="#!" class="text-white"><i class="fab fa-twitter fa-lg mx-4 px-2"></i></a>
                                <a href="#!" class="text-white"><i class="fab fa-google fa-lg"></i></a>
                            </div>
                        </form>

                        <div class="mt-4">
                            <p class="mb-0">Don't have an account? <a href="/webbanhang/account/register" class="text-white-50 fw-bold">Sign Up</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'app/views/shares/footer.php'; ?>