<?php
// Require SessionHelper and other necessary files
require_once('app/config/database.php');
require_once('app/models/CategoryModel.php');
require_once 'app/helpers/SessionHelper.php'; // Thêm SessionHelper
class CategoryController
{
    private $model;

    public function __construct()
    {
        $db = (new Database())->getConnection();
        $this->model = new CategoryModel($db);
    }
    public function isAdmin()
    {
        return SessionHelper::isAdmin();
    }
    public function list()
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        $categories = $this->model->getCategory();
        include 'app/views/category/list.php';
    }

    public function add()
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $this->model->createCategory($name, $description);
            header('Location: /webbanhang/Category/list');
        }
        include 'app/views/category/add.php';
    }

    public function edit()
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        $id = $_GET['id'] ?? null;
        if (!$id) return;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $this->model->updateCategory($id, $name, $description);
            header('Location: /webbanhang/Category/list');
        }

        $category = $this->model->getCategoryById($id);
        include 'app/views/category/edit.php';
    }

    public function delete()
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->model->deleteCategory($id);
        }
        header('Location: /webbanhang/Category/list');
    }
}
