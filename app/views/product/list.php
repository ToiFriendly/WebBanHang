<?php include 'app/views/shares/header.php'; ?>
<style>
    .product-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
        border-radius: 10px;
        overflow: hidden;
        background: #fff;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .product-card img {
        height: 200px;
        object-fit: cover;
        border-bottom: 1px solid #e0e0e0;
    }

    .product-card .card-body {
        padding: 15px;
    }

    .product-card .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 10px;
        display: -webkit-box;
        /*-webkit-line-clamp: 2;*/
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .product-card .card-text {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 10px;
        display: -webkit-box;
        /*-webkit-line-clamp: 3;*/
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-card .price {
        font-size: 1.2rem;
        font-weight: bold;
        color: #e44d26;
    }

    .product-card .category-badge {
        font-size: 0.85rem;
        padding: 5px 10px;
        border-radius: 12px;
    }

    .btn-add-cart {
        background-color: #ff6f61;
        color: #fff;
        border: none;
        transition: background-color 0.3s ease;
    }

    .btn-add-cart:hover {
        background-color: #e55a50;
    }

    .btn-action {
        font-size: 0.9rem;
        padding: 5px 10px;
    }

    .low-quantity {
        color: #dc3545 !important;
        /* Màu đỏ cho số lượng < 10 */
    }

    .container {
        max-width: 1200px;
    }

    @media (max-width: 576px) {
        .product-card img {
            height: 150px;
        }

        .product-card .card-title {
            font-size: 1rem;
        }

        .product-card .price {
            font-size: 1rem;
        }
    }
</style>

<div class="container mt-5">
    <h1 class="text-center mb-4 fw-bold text-primary">List đĩa nhạc</h1>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="/webbanhang/Product/add" class="btn btn-success">➕ Thêm đĩa nhạc mới</a>
        <form class="d-flex" action="/webbanhang/Product/search" method="GET">
            <input class="form-control me-2" type="search" name="keyword" placeholder="Tìm kiếm đĩa nhạc..." aria-label="Search">
            <button class="btn btn-outline-primary" type="submit">Tìm</button>
        </form>
    </div>
    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-6 col-md-4 col-lg-3 mb-4">
                <div class="card product-card h-100">
                    <?php if ($product->image): ?>
                        <img src="/webbanhang/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>" class="card-img-top" alt="Product Image">
                    <?php else: ?>
                        <img src="/webbanhang/public/images/default-product-image.png" class="card-img-top" alt="Default Image">
                    <?php endif; ?>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-primary">
                            <a href="/webbanhang/Product/show/<?php echo $product->id; ?>" class="text-decoration-none"><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></a>
                        </h5>
                        <p class="card-text flex-grow-1"><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></p>
                        <p class="price"><?php echo number_format($product->price, 0, ',', '.'); ?> VND</p>
                        <p class="card-text <?php echo $product->quantity < 10 ? 'low-quantity' : ''; ?>">Số lượng: <?php echo htmlspecialchars($product->quantity, ENT_QUOTES, 'UTF-8'); ?></p>
                        <p class="card-text"><span class="badge category-badge bg-info text-white"><?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?></span></p>
                        <div class="mt-auto d-flex flex-wrap gap-2">
                            <a href="/webbanhang/Product/addToCart/<?php echo $product->id; ?>" class="btn btn-add-cart btn-sm">Thêm vào giỏ</a>
                            <?php if (SessionHelper::isAdmin()) { ?>
                                <a href="/webbanhang/Product/edit/<?php echo $product->id; ?>" class="btn btn-warning btn-action btn-sm">Sửa</a>
                                <a href="/webbanhang/Product/delete/<?php echo $product->id; ?>" class="btn btn-danger btn-action btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>