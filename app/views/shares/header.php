<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-image {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Quản lý sản phẩm</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/webbanhang">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/webbanhang/Product/">Danh Sách Đĩa Nhạc</a>
                </li>
                <?php if (SessionHelper::isAdmin()) { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Admin Options
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                            <li><a class="dropdown-item" href="/webbanhang/Product/add">Thêm Đĩa Nhạc</a></li>
                            <li><a class="dropdown-item" href="/webbanhang/Category/list">Danh sách thể loại nhạc</a></li>
                            <li><a class="dropdown-item" href="/webbanhang/Account/list">Danh sách người dùng</a></li>
                        </ul>
                    </li>
                <?php } ?>
                <?php if (SessionHelper::isLoggedIn()) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/webbanhang/Product/Cart">Giỏ hàng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/webbanhang/Account/show">Hồ sơ người dùng</a>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <?php
                    if (SessionHelper::isLoggedIn()) {
                        echo "<a class='nav-link'>" . $_SESSION['username'] . "</a>";
                    } else {
                        echo "<a class='nav-link' href='/webbanhang/account/login'>Login</a>";
                    }
                    ?>
                </li>
                <li class="nav-item">
                    <?php
                    if (SessionHelper::isLoggedIn()) {
                        echo "<a class='nav-link' href='/webbanhang/account/logout'>Logout</a>";
                    }
                    ?>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-4">