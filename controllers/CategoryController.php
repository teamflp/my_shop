<?php

namespace controllers;

use models\Category;

class CategoryController
{
    private $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new Category();
    }

    public function adminList()
    {
        $categories = $this->categoryModel->readAll();
        require_once __DIR__ . '/../views/admin/categories.php';
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $parent_id = !empty($_POST['parent_id']) ? $_POST['parent_id'] : null;
            $this->categoryModel->create($name, $parent_id);
            header('Location: admin.php?action=categories');
            exit();
        }
        $categories = $this->categoryModel->readAll();
        require_once __DIR__ . '/../views/admin/category_form.php';
    }

    public function edit()
    {
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $parent_id = !empty($_POST['parent_id']) ? $_POST['parent_id'] : null;
            $this->categoryModel->update($id, $name, $parent_id);
            header('Location: admin.php?action=categories');
            exit();
        }
        $category = $this->categoryModel->readOne($id);
        $categories = $this->categoryModel->readAll();
        require_once __DIR__ . '/../views/admin/category_form.php';
    }

    public function delete()
    {
        $id = $_GET['id'];
        $this->categoryModel->delete($id);
        header('Location: admin.php?action=categories');
        exit();
    }
}