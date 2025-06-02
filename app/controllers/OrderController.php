<?php
require_once('app/config/database.php');
require_once('app/models/OrderModel.php');

class OrderController
{
    private $orderModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->orderModel = new OrderModel($this->db);
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    public function create()
    {
        include 'app/views/order/create.php'; // Giả sử có file view để tạo đơn hàng
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            $gmail = $_POST['gmail'] ?? null;
            $time = $_POST['time'] ?? null;
            $note = $_POST['note'] ?? null;

            $result = $this->orderModel->createOrder($name, $phone, $address, $gmail, $time, $note);
            if ($result) {
                header('Location: /webbanhang/Order');
            } else {
                echo "Đã xảy ra lỗi khi tạo đơn hàng.";
            }
        }
    }
}
