<?php
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');
require_once('app/models/OrderModel.php'); // Thêm OrderModel
require_once 'app/helpers/SessionHelper.php'; // Thêm SessionHelper
class ProductController
{
    private $productModel;
    private $orderModel; // Thêm OrderModel
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
        $this->orderModel = new OrderModel($this->db); // Khởi tạo OrderModel
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    // Kiểm tra quyền Admin 
    public function isAdmin()
    {
        return SessionHelper::isAdmin();
    }
    public function index()
    {
        $products = $this->productModel->getProducts();
        include 'app/views/product/list.php';
    }

    public function show($id)
    {
        $product = $this->productModel->getProductById($id);
        if ($product) {
            include 'app/views/product/show.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function add()
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        $categories = (new CategoryModel($this->db))->getCategory();
        include_once 'app/views/product/add.php';
    }

    public function save()
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? null;
            $quantity = $_POST['quantity'] ?? 0;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {
                $image = "";
            }
            $result = $this->productModel->addProduct(
                $name,
                $description,
                $price,
                $category_id,
                $image,
                $quantity
            );
            if (is_array($result)) {
                $errors = $result;
                $categories = (new CategoryModel($this->db))->getCategory();
                include 'app/views/product/add.php';
            } else {
                header('Location: /webbanhang/Product');
            }
        }
    }

    public function edit($id)
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        $product = $this->productModel->getProductById($id);
        $categories = (new CategoryModel($this->db))->getCategory();
        if ($product) {
            include 'app/views/product/edit.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function update()
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];
            $quantity = $_POST['quantity'];
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {
                $image = $_POST['existing_image'];
            }
            $edit = $this->productModel->updateProduct(
                $id,
                $name,
                $description,
                $price,
                $category_id,
                $image,
                $quantity
            );
            if ($edit) {
                header('Location: /webbanhang/Product');
            } else {
                echo "Đã xảy ra lỗi khi lưu sản phẩm.";
            }
        }
    }

    public function delete($id)
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($this->productModel->deleteProduct($id)) {
            header('Location: /webbanhang/Product');
        } else {
            echo "Đã xảy ra lỗi khi xóa sản phẩm.";
        }
    }

    private function uploadImage($file)
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            throw new Exception("File không phải là hình ảnh.");
        }
        if ($file["size"] > 10 * 1024 * 1024) {
            throw new Exception("Hình ảnh có kích thước quá lớn.");
        }
        if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            throw new Exception("Chỉ cho phép các định dạng JPG, JPEG, PNG và GIF.");
        }
        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            throw new Exception("Có lỗi xảy ra khi tải lên hình ảnh.");
        }
        return $target_file;
    }

    public function addToCart($id)
    {
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            echo "Không tìm thấy sản phẩm.";
            return;
        }
        if ($product->quantity <= 0) {
            echo "Sản phẩm đã hết hàng.";
            return;
        }
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (isset($_SESSION['cart'][$id])) {
            if ($_SESSION['cart'][$id]['quantity'] + 1 > $product->quantity) {
                echo "Số lượng trong giỏ hàng vượt quá số lượng tồn kho.";
                return;
            }
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            $_SESSION['cart'][$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image
            ];
        }
        header('Location: /webbanhang/Product/cart');
    }

    public function cart()
    {
        include 'app/views/product/cart.php';
    }

    public function updateCart()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantity'])) {
            foreach ($_POST['quantity'] as $id => $quantity) {
                $product = $this->productModel->getProductById($id);
                if (!$product) {
                    echo "Không tìm thấy sản phẩm.";
                    return;
                }
                if ($quantity < 1) {
                    unset($_SESSION['cart'][$id]);
                } else {
                    if ($quantity > $product->quantity) {
                        echo "Số lượng sản phẩm $product->name vượt quá số lượng tồn kho ($product->quantity).";
                        return;
                    }
                    if (isset($_SESSION['cart'][$id])) {
                        $_SESSION['cart'][$id]['quantity'] = (int)$quantity;
                    }
                }
            }
            header('Location: /webbanhang/Product/cart');
        }
    }

    public function removeFromCart($id)
    {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        header('Location: /webbanhang/Product/cart');
    }

    public function checkout()
    {
        include 'app/views/product/checkout.php';
    }

    public function processCheckout()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            $gmail = $_POST['gmail'] ?? null;
            $time = $_POST['time'] ?? null;
            $note = $_POST['note'] ?? null;

            // Kiểm tra giỏ hàng
            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                $_SESSION['error'] = "Giỏ hàng trống.";
                header('Location: /webbanhang/Product/cart');
                return;
            }

            // Kiểm tra số lượng tồn kho
            foreach ($_SESSION['cart'] as $product_id => $item) {
                $product = $this->productModel->getProductById($product_id);
                if (!$product) {
                    $_SESSION['error'] = "Không tìm thấy sản phẩm.";
                    header('Location: /webbanhang/Product/cart');
                    return;
                }
                if ($item['quantity'] > $product->quantity) {
                    $_SESSION['error'] = "Số lượng sản phẩm $product->name vượt quá số lượng tồn kho ($product->quantity).";
                    header('Location: /webbanhang/Product/cart');
                    return;
                }
            }

            // Bắt đầu giao dịch
            $this->db->beginTransaction();
            try {
                // Lưu thông tin đơn hàng vào bảng orders bằng OrderModel
                $order_id = $this->orderModel->createOrder($name, $phone, $address, $gmail, $time, $note);
                if (!$order_id) {
                    throw new Exception("Không thể tạo đơn hàng.");
                }

                // Lưu chi tiết đơn hàng và cập nhật số lượng tồn kho
                $cart = $_SESSION['cart'];
                foreach ($cart as $product_id => $item) {
                    // Lưu chi tiết đơn hàng vào bảng order_details
                    $query = "INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)";
                    $stmt = $this->db->prepare($query);
                    $stmt->bindParam(':order_id', $order_id);
                    $stmt->bindParam(':product_id', $product_id);
                    $stmt->bindParam(':quantity', $item['quantity']);
                    $stmt->bindParam(':price', $item['price']);
                    $stmt->execute();

                    // Cập nhật số lượng tồn kho
                    $query = "UPDATE product SET quantity = quantity - :quantity WHERE id = :product_id";
                    $stmt = $this->db->prepare($query);
                    $stmt->bindParam(':quantity', $item['quantity']);
                    $stmt->bindParam(':product_id', $product_id);
                    $stmt->execute();
                }

                // Xóa giỏ hàng sau khi đặt hàng thành công
                unset($_SESSION['cart']);

                // Commit giao dịch
                $this->db->commit();

                // Chuyển hướng đến trang xác nhận đơn hàng
                header('Location: /webbanhang/Product/orderConfirmation');
            } catch (Exception $e) {
                // Rollback giao dịch nếu có lỗi
                $this->db->rollBack();
                $_SESSION['error'] = "Đã xảy ra lỗi khi xử lý đơn hàng: " . $e->getMessage();
                header('Location: /webbanhang/Product/cart');
            }
        }
    }

    public function orderConfirmation()
    {
        include 'app/views/product/orderConfirmation.php';
    }

    public function list()
    {
        $products = $this->productModel->getProducts();
        require_once 'app/views/product/list.php';
    }

    public function search()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
            $products = $this->productModel->searchProducts($keyword);
        } else {
            $products = $this->productModel->getProducts();
        }
        include 'app/views/product/list.php';
    }
}
