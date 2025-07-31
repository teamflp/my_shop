<?php

namespace controllers;

use models\Product;
use models\Category;

class ProductController
{
    private Product $productModel;
    private Category $categoryModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
    }

    public function adminList(): void
    {
        $products = $this->productModel->readAll();
        require_once __DIR__ . '/../views/admin/products.php';
    }

    public function add(): void
    {
        $errors = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate form data
            if (empty($_POST['name']) || empty($_POST['description']) || empty($_POST['price']) || empty($_POST['category_id'])) {
                $errors[] = ERROR_FILL_ALL_FIELDS;
            }
            
            if (empty($errors)) {
                // Handle file upload
                $image_path = $this->handleImageUpload();
                
                if ($this->productModel->create(
                    $_POST['name'],
                    $_POST['description'],
                    $_POST['price'],
                    $_POST['category_id'],
                    $image_path
                )) {
                    header('Location: admin.php?action=products');
                    exit();
                } else {
                    $errors[] = ERROR_PRODUCT_ADD_FAILED;
                }
            }
        }
        
        $categories = $this->categoryModel->readAll();
        require_once __DIR__ . '/../views/admin/product_form.php';
    }

    public function edit(): void
    {
        $errors = [];
        $id = $_GET['id'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate form data
            if (empty($_POST['name']) || empty($_POST['description']) || empty($_POST['price']) || empty($_POST['category_id'])) {
                $errors[] = ERROR_FILL_ALL_FIELDS;
            }
            
            if (empty($errors)) {
                $image_path = $this->handleImageUpload();
                // If no new image is uploaded, keep the old one
                if ($image_path === null && !empty($_POST['existing_image'])) {
                    $image_path = $_POST['existing_image'];
                }

                if ($this->productModel->update(
                    $id,
                    $_POST['name'],
                    $_POST['description'],
                    $_POST['price'],
                    $_POST['category_id'],
                    $image_path
                )) {
                    header('Location: admin.php?action=products');
                    exit();
                } else {
                    $errors[] = ERROR_PRODUCT_UPDATE_FAILED;
                }
            }
        }
        
        $product = $this->productModel->readOne($id);
        $categories = $this->categoryModel->readAll();
        require_once __DIR__ . '/../views/admin/product_form.php';
    }

    public function delete()
    {
        $id = $_GET['id'];
        // You might want to delete the associated image file from the server as well
        $product = $this->productModel->readOne($id);
        if ($product && !empty($product['image']) && file_exists(__DIR__ . '/../' . $product['image'])) {
            unlink(__DIR__ . '/../' . $product['image']);
        }
        $this->productModel->delete($id);
        header('Location: admin.php?action=products');
        exit();
    }

    private function handleImageUpload(): ?string
    {
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $target_dir = IMAGES_DIR;
            // Create dir if it doesn't exist
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                return $target_file;
            }
        }
        return null;
    }

    // Liste des produits
    public function listProducts(): void
    {
        $products = $this->productModel->readAll();
        require_once __DIR__ . '/../views/product_list.php';
    }

    // Voir un produit
    public function showProduct(): void
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $product = $this->productModel->readOne($id);
            if ($product) {
                require_once __DIR__ . '/../views/product_detail.php';
            } else {
                echo ERROR_PRODUCT_NOT_FOUND;
            }
        } else {
            echo ERROR_NO_PRODUCT_SPECIFIED;
        }
    }
}