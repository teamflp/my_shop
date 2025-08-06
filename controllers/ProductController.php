<?php

namespace controllers;

use models\Auth;
use models\Product;
use models\Category;

class ProductController
{
    private Product $productModel;

    public function __construct()
    {
        $this -> productModel = new Product();
    }

    // --- Méthodes pour le site public ---

    /**
     * Affiche la liste de tous les produits sur la page d'accueil.
     */
    public function listProducts(): void
    {
        $products = $this -> productModel -> readAll();
        require_once __DIR__ . '/../views/home.php';
    }

    /**
     * Affiche la page de détail d'un produit.
     */
    public function showProduct(): void
    {
        if (!isset($_GET['id'])) {
            header('Location: index.php');
            exit();
        }
        $product = $this -> productModel -> readOne((int)$_GET['id']);
        if (!$product) {
            // Gérer le cas où le produit n'existe pas
            header('Location: index.php');
            exit();
        }
        require_once __DIR__ . '/../views/product_details.php';
    }

    // --- Méthodes pour le panneau d'administration ---

    /**
     * Affiche la liste des produits dans le panneau d'administration.
     */
    public function adminList(): void
    {
        Auth ::isAdmin() or die('Forbidden');

        // Logique de pagination
        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, ['options' => ['default' => 1, 'min_range' => 1]]);
        $products_per_page = 10; // Nombre de produits par page
        $total_products = $this->productModel->countAll();
        $total_pages = ceil($total_products / $products_per_page);
        $offset = ($page - 1) * $products_per_page;

        // Récupérer les produits pour la page actuelle
        $products = $this->productModel->readPaginated($products_per_page, $offset);

        // Afficher la vue avec les produits et les données de pagination
        require_once __DIR__ . '/../views/admin/products.php';
    }

    /**
     * Gère l'ajout d'un nouveau produit.
     */
    public function add(): void
    {
        Auth ::isAdmin() or die('Forbidden');
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = (float)($_POST['price'] ?? 0);
            $category_id = (int)($_POST['category_id'] ?? 0);
            // Utiliser filter_input pour une meilleure validation et sécurité
            $stock = filter_input(INPUT_POST, 'stock', FILTER_VALIDATE_INT);

            // Validation
            if (empty($name) || $price <= 0 || $category_id <= 0) {
                $errors[] = "Le nom, le prix et la catégorie sont des champs obligatoires.";
            }

            // Valider que le stock est un entier non-négatif
            if ($stock === false || $stock < 0) {
                $errors[] = "La quantité en stock doit être un nombre entier positif ou nul.";
            }

            $image_path = $this -> handleImageUpload($_FILES['image'] ?? null, $errors);

            if (empty($errors)) {
                if ($this -> productModel -> create($name, $description, $price, $category_id, $stock, $image_path)) {
                    header('Location: admin.php?action=products&add=success');
                    exit();
                } else {
                    $errors[] = "Une erreur est survenue lors de la création du produit.";
                }
            }
        }

        // Afficher le formulaire (GET request ou POST avec erreurs)
        $categoryModel = new Category();
        $categories = $categoryModel -> readAll();
        require_once __DIR__ . '/../views/admin/product_form.php';
    }

    /**
     * Gère la modification d'un produit existant.
     */
    public function edit(): void
    {
        Auth ::isAdmin() or die('Forbidden');
        $id = (int)($_GET['id'] ?? 0);
        if ($id === 0) {
            header('Location: admin.php?action=products');
            exit();
        }

        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = (float)($_POST['price'] ?? 0);
            $category_id = (int)($_POST['category_id'] ?? 0);
            // Utiliser filter_input pour une meilleure validation et sécurité
            $stock = filter_input(INPUT_POST, 'stock', FILTER_VALIDATE_INT);

            // Validation
            if (empty($name) || $price <= 0 || $category_id <= 0) {
                $errors[] = "Le nom, le prix et la catégorie sont des champs obligatoires.";
            }

            // Valider que le stock est un entier non-négatif
            if ($stock === false || $stock < 0) {
                $errors[] = "La quantité en stock doit être un nombre entier positif ou nul.";
            }

            $product = $this -> productModel -> readOne($id);
            $image_path = $product['image']; // Garder l'ancienne image par défaut

            // Si une nouvelle image est uploadée, la traiter
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $new_image_path = $this -> handleImageUpload($_FILES['image'], $errors);
                if ($new_image_path) {
                    // Supprimer l'ancienne image si elle existe
                    if ($image_path && file_exists(__DIR__ . '/../../' . $image_path)) {
                        unlink(__DIR__ . '/../../' . $image_path);
                    }
                    $image_path = $new_image_path;
                }
            }
            if (empty($errors)) {
                if ($this -> productModel -> update($id, $name, $description, $price, $category_id, $stock, $image_path)) {
                    header('Location: admin.php?action=products&edit=success');
                    exit();
                } else {
                    $errors[] = "Une erreur est survenue lors de la mise à jour du produit.";
                }
            }
        }

        // Afficher le formulaire (GET request ou POST avec erreurs)
        $product = $this -> productModel -> readOne($id);
        if (!$product) {
            header('Location: admin.php?action=products');
            exit();
        }
        $categoryModel = new Category();
        $categories = $categoryModel -> readAll();
        require_once __DIR__ . '/../views/admin/product_form.php';
    }

    /**
     * Gère la suppression d'un produit.
     */
    public function delete(): void
    {
        Auth ::isAdmin() or die('Forbidden');
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            // Supprimer le fichier image associé s'il existe
            $product = $this -> productModel -> readOne($id);
            if ($product && !empty($product['image']) && file_exists(__DIR__ . '/../../' . $product['image'])) {
                unlink(__DIR__ . '/../../' . $product['image']);
            }
            $this -> productModel -> delete($id);
        }
        header('Location: admin.php?action=products&delete=success');
        exit();
    }

    /**
     * Gère l'upload d'une image de produit.
     * @param array|null $file Le tableau $_FILES['image'].
     * @param array &$errors Un tableau pour stocker les erreurs.
     * @return string|null Le chemin de l'image ou null en cas d'échec ou si aucun fichier n'est fourni.
     */
    private function handleImageUpload(?array $file, array &$errors): ?string
    {
        if ($file === null || $file['error'] !== UPLOAD_ERR_OK) {
            // Pas de fichier uploadé ou erreur, ce n'est pas une erreur bloquante
            return null;
        }

        $upload_dir = __DIR__ . '/../../uploads/';
        if (!is_dir($upload_dir)) {
            // Tente de créer le dossier avec les permissions appropriées
            if (!mkdir($upload_dir, 0775, true)) {
                $errors[] = "Impossible de créer le dossier d'upload.";
                return null;
            }
        }

        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowed_types)) {
            $errors[] = "Type de fichier non autorisé. Uniquement JPG, PNG, GIF.";
            return null;
        }

        // Nettoyer le nom du fichier pour plus de sécurité
        $filename = uniqid() . '-' . preg_replace('/[^A-Za-z0-9.\-_]/', '', basename($file['name']));
        $target_file = $upload_dir . $filename;

        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            return 'uploads/' . $filename; // Retourne le chemin relatif pour la BDD
        } else {
            $errors[] = "Erreur lors du déplacement du fichier uploadé.";
            return null;
        }
    }

}
