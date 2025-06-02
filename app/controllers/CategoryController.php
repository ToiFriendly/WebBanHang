<?php
// Require SessionHelper and other necessary files
require_once('app/config/database.php');
require_once('app/models/CategoryModel.php');

class CategoryController
{
    private $model;

    public function __construct()
    {
        $db = (new Database())->getConnection();
        $this->model = new CategoryModel($db);
    }

    public function list()
    {
        $categories = $this->model->getCategories();
        include 'app/views/category/list.php';
    }

    public function add()
    {
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
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->model->deleteCategory($id);
        }
        header('Location: /webbanhang/Category/list');
    }
}