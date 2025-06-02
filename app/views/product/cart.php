<?php include 'app/views/shares/header.php'; ?>
<style>
    .cart-table img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 5px;
    }

    .cart-table .product-name {
        font-weight: 600;
        color: #333;
    }

    .cart-table .price {
        color: #e44d26;
        font-weight: bold;
    }

    .cart-table .total {
        font-weight: bold;
        color: #e44d26;
    }

    .btn-update-cart {
        background-color: #ff6f61;
        color: #fff;
        border: none;
    }

    .btn-update-cart:hover {
        background-color: #e55a50;
    }

    .btn-checkout {
        background-color: #28a745;
        color: #fff;
        font-size: 1.1rem;
    }

    .btn-checkout:hover {
        background-color: #218838;
    }

    .btn-checkout:disabled {
        background-color: #6c757d;
        cursor: not-allowed;
    }

    .cart-empty {
        text-align: center;
        padding: 50px 0;
    }
</style>

<div class="container mt-5">
    <h1 class="text-center mb-4 fw-bold text-primary">Giỏ hàng của bạn</h1>
    <?php
    $canCheckout = true;
    $errorMessages = [];
    $productModel = new ProductModel((new Database())->getConnection());
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $id => $item) {
            $product = $productModel->getProductById($id);
            if ($product && $item['quantity'] > $product->quantity) {
                $canCheckout = false;
                $errorMessages[] = "Sản phẩm " . htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') . " có số lượng đặt mua (" . $item['quantity'] . ") vượt quá số lượng tồn kho (" . $product->quantity . ").";
            }
        }
    }
    ?>
    <?php if (!empty($errorMessages)): ?>
        <div class="alert alert-danger" role="alert">
            <ul>
                <?php foreach ($errorMessages as $message): ?>
                    <li><?php echo $message; ?></li>
                <?php endforeach; ?>
            </ul>
            <p>Vui lòng điều chỉnh số lượng trong giỏ hàng để tiếp tục thanh toán.</p>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
        <form action="/webbanhang/Product/updateCart" method="POST">
            <table class="table table-bordered table-hover cart-table bg-white shadow-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>Hình ảnh</th>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($_SESSION['cart'] as $id => $item):
                        $product = $productModel->getProductById($id);
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                    ?>
                        <tr>
                            <td>
                                <?php if ($item['image']): ?>
                                    <img src="/webbanhang/<?php echo htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>">
                                <?php else: ?>
                                    <img src="/webbanhang/public/images/default-product-image.png" alt="Default Image">
                                <?php endif; ?>
                            </td>
                            <td class="product-name">
                                <?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>
                                <br><small class="text-muted">Tồn kho: <?php echo htmlspecialchars($product->quantity, ENT_QUOTES, 'UTF-8'); ?></small>
                            </td>
                            <td class="price"><?php echo number_format($item['price'], 0, ',', '.'); ?> VND</td>
                            <td>
                                <input type="number" name="quantity[<?php echo $id; ?>]" value="<?php echo $item['quantity']; ?>" min="1" max="<?php echo $product->quantity; ?>" class="form-control w-50 d-inline">
                            </td>
                            <td class="total"><?php echo number_format($subtotal, 0, ',', '.'); ?> VND</td>
                            <td>
                                <a href="/webbanhang/Product/removeFromCart/<?php echo $id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?');">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="d-flex justify-content-between align-items-center mt-4">
                <h4>Tổng tiền: <span class="text-danger"><?php echo number_format($total, 0, ',', '.'); ?> VND</span></h4>
                <div>
                    <button type="submit" class="btn btn-update-cart me-2">Cập nhật giỏ hàng</button>
                    <a href="/webbanhang/Product/checkout" class="btn btn-checkout" <?php if (!$canCheckout) echo 'disabled'; ?>>Thanh toán</a>
                </div>
            </div>
        </form>
    <?php else: ?>
        <div class="cart-empty">
            <h4 class="text-muted">Giỏ hàng của bạn đang trống!</h4>
            <a href="/webbanhang/Product/list" class="btn btn-primary mt-3">Tiếp tục mua sắm</a>
        </div>
    <?php endif; ?>
</div>
<?php include 'app/views/shares/footer.php'; ?>