<?php
require_once('app/config/database.php');
require_once('app/models/AccountModel.php');
require_once 'app/helpers/SessionHelper.php'; // Thêm SessionHelper
class AccountController
{
    private $accountModel;
    private $db;
    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
    }
    public function isAdmin()
    {
        return SessionHelper::isAdmin();
    }
    public function register()
    {
        include_once 'app/views/account/register.php';
    }
    public function login()
    {
        include_once 'app/views/account/login.php';
    }
    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $fullName = $_POST['fullname'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmpassword'] ?? '';
            $role = $_POST['role'] ?? 'user';
            $gmail = $_POST['gmail'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $image = $_FILES['image'] ?? null;
            $isDeleted = $_POST['isDeleted'] ?? false;

            $errors = [];
            if (empty($username)) $errors['username'] = "Vui lòng nhập username!";
            if (empty($fullName)) $errors['fullname'] = "Vui lòng nhập fullname!";
            if (empty($password)) $errors['password'] = "Vui lòng nhập password!";
            if ($password != $confirmPassword) $errors['confirmPass'] = "Mật khẩu và xác nhận chưa khớp!";
            if (!in_array($role, ['admin', 'user'])) $role = 'user';
            if ($this->accountModel->getAccountByUsername($username)) {
                $errors['account'] = "Tài khoản này đã được đăng ký!";
            }

            $imageName = 'default-avt.jpg';
            if ($image && $image['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/'; // Thư mục lưu ảnh, cần tạo trước
                if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);
                $imageName = uniqid() . '_' . basename($image['name']);
                $targetFile = $uploadDir . $imageName;
                if (!move_uploaded_file($image['tmp_name'], $targetFile)) {
                    $errors['image'] = "Tải lên hình ảnh thất bại!";
                }
            }

            if (count($errors) > 0) {
                include_once 'app/views/account/register.php';
            } else {
                $result = $this->accountModel->save($username, $fullName, $password, $role, $gmail, $phone, $imageName, $isDeleted);
                if ($result) {
                    header("Location: /webbanhang/account/login");
                    exit;
                } else {
                    $errors['save'] = "Đăng ký thất bại. Vui lòng thử lại!";
                    include_once 'app/views/account/register.php';
                }
            }
        }
    }
    public function logout()
    {
        session_start();
        unset($_SESSION['username']);
        unset($_SESSION['role']);
        header('Location: /webbanhang/product');
        exit;
    }
    public function checkLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $account = $this->accountModel->getAccountByUsername($username);
            if ($account) {
                if ($account->isDeleted) {
                    $error = "Tài khoản của bạn đã bị xóa và không thể đăng nhập!";
                    include_once 'app/views/account/login.php';
                    exit;
                }
                if (password_verify($password, $account->password)) {
                    session_start();
                    if (!isset($_SESSION['username'])) {
                        $_SESSION['username'] = $account->username;
                        $_SESSION['role'] = $account->role;
                    }
                    header('Location: /webbanhang/product');
                    exit;
                } else {
                    $error = "Mật khẩu không đúng!";
                    include_once 'app/views/account/login.php';
                    exit;
                }
            } else {
                $error = "Không tìm thấy tài khoản này!";
                include_once 'app/views/account/login.php';
                exit;
            }
        }
    }
    public function list()
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if (!isset($_SESSION['username'])) {
            header('Location: /webbanhang/account/login');
            exit;
        }
        $account = $this->accountModel->getAllAccounts(); // Lấy danh sách tất cả người dùng
        include_once 'app/views/account/list.php';
    }
    public function index()
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        $account = $this->accountModel->getAllAccounts();
        include 'app/views/account/list.php';
    }
    public function delete()
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        $id = $_GET['id'] ?? null;
        if ($id) {
            $result = $this->accountModel->softDeleteAccount($id);
            if (!$result) {
                echo "Xóa mềm tài khoản thất bại!";
                exit;
            }
        } else {
            echo "ID không hợp lệ!";
            exit;
        }
        header('Location: /webbanhang/account/list');
    }
    public function update()
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'] ?? null;
            $username = $_POST['username'] ?? '';
            $fullName = $_POST['fullname'] ?? '';
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'user';
            $gmail = $_POST['gmail'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $image = $_FILES['image'] ?? null;

            $errors = [];
            if (!$id) $errors['id'] = "ID không hợp lệ!";
            if (empty($username)) $errors['username'] = "Vui lòng nhập username!";
            if (empty($fullName)) $errors['fullname'] = "Vui lòng nhập fullname!";

            $imageName = $this->accountModel->getAccountById($id)->image ?? 'default-avt.jpg';
            if ($image && $image['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/'; // Thư mục lưu ảnh, cần tạo trước
                if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);
                $imageName = uniqid() . '_' . basename($image['name']);
                $targetFile = $uploadDir . $imageName;
                if (!move_uploaded_file($image['tmp_name'], $targetFile)) {
                    $errors['image'] = "Tải lên hình ảnh thất bại!";
                }
            }

            if (count($errors) > 0) {
                include 'app/views/account/edit.php';
            } else {
                $result = $this->accountModel->updateAccount($id, $username, $fullName, $password, $role, $gmail, $phone, $imageName);
                if ($result) {
                    header('Location: /webbanhang/account/index');
                    exit;
                } else {
                    echo "Cập nhật thất bại!";
                    exit;
                }
            }
        }
    }
    public function edit()
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        $id = $_GET['id'] ?? null;
        if ($id) {
            $account = $this->accountModel->getAccountById($id);
            if (!$account) {
                echo "Không tìm thấy tài khoản này!";
                exit;
            }
            include 'app/views/account/edit.php';
        } else {
            echo "ID không hợp lệ!";
            exit;
        }
    }
    public function add()
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        include 'app/views/account/add.php';
    }
    public function show($id = null)
    {
        if (!$id && !SessionHelper::isLoggedIn()) {
            echo "ID không hợp lệ hoặc bạn cần đăng nhập.";
            exit;
        }
        $account = $id ? $this->accountModel->getAccountById($id) : $this->accountModel->getAccountByUsername($_SESSION['username']);
        if ($account) {
            include 'app/views/account/profile.php';
        } else {
            echo "Không thấy người dùng.";
        }
    }
    public function editProfile()
    {
        if (!SessionHelper::isLoggedIn()) {
            header('Location: /webbanhang/account/login');
            exit;
        }
        $account = $this->accountModel->getAccountByUsername($_SESSION['username']);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $account->id;
            $fullName = $_POST['fullname'] ?? $account->fullname;
            $password = $_POST['password'] ?? '';
            $gmail = $_POST['gmail'] ?? $account->gmail;
            $phone = $_POST['phone'] ?? $account->phone;
            $image = $_FILES['image'] ?? null;

            $errors = [];
            if (empty($fullName)) $errors['fullname'] = "Vui lòng nhập fullname!";
            if (!empty($password) && strlen($password) < 6) $errors['password'] = "Mật khẩu phải có ít nhất 6 ký tự!";
            $imageName = $account->image ?? 'default-avt.jpg';
            if ($image && $image['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/';
                if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);
                $imageName = uniqid() . '_' . basename($image['name']);
                $targetFile = $uploadDir . $imageName;
                if (!move_uploaded_file($image['tmp_name'], $targetFile)) {
                    $errors['image'] = "Tải lên hình ảnh thất bại!";
                }
            }

            if (count($errors) > 0) {
                include 'app/views/account/edit_profile.php';
            } else {
                $passwordHash = !empty($password) ? password_hash($password, PASSWORD_BCRYPT) : $account->password;
                $result = $this->accountModel->updateAccount($id, $account->username, $fullName, $passwordHash, $account->role, $gmail, $phone, $imageName);
                if ($result) {
                    $account = $this->accountModel->getAccountByUsername($_SESSION['username']);
                    $_SESSION['account'] = $account;
                    header('Location: /webbanhang/account/show');
                    exit;
                } else {
                    $errors['save'] = "Cập nhật thất bại. Vui lòng thử lại!";
                    include 'app/views/account/edit_profile.php';
                }
            }
        } else {
            include 'app/views/account/edit_profile.php';
        }
    }
}
