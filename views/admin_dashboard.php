<?php require_once 'includes/header.php'; ?>

<div class="container py-4">
    <div class="jumbotron bg-primary text-white shadow-sm">
        <h1 class="display-4 text-white"><i class="bi bi-speedometer2"></i> Tableau de Bord Administrateur</h1>
        <p class="lead text-white">Bienvenue sur le tableau de bord administrateur. À partir d'ici, vous pouvez gérer les produits et les catégories de votre boutique.</p>
    </div>

    <div class="row mt-4">
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-box-seam" style="font-size: 3rem; color: #007bff;"></i>
                    <h3 class="mt-3">Produits</h3>
                    <p class="text-muted">Gérez votre inventaire de produits, ajoutez de nouveaux produits, mettez à jour les détails, et plus encore.</p>
                    <a href="admin.php?action=products" class="btn btn-primary btn-lg mt-2">
                        <i class="bi bi-pencil-square"></i> Gérer les Produits
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-tags" style="font-size: 3rem; color: #28a745;"></i>
                    <h3 class="mt-3">Catégories</h3>
                    <p class="text-muted">Organisez vos produits avec des catégories, créez-en de nouvelles et modifiez celles qui existent.</p>
                    <a href="admin.php?action=categories" class="btn btn-success btn-lg mt-2">
                        <i class="bi bi-folder2-open"></i> Gérer les Catégories
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <i class="bi bi-graph-up"></i> Statistiques de la Boutique
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <i class="bi bi-box-seam text-primary" style="font-size: 2rem;"></i>
                            <h4 class="mt-2">Produits</h4>
                            <p class="h2 text-primary"><?= $stats['product_count'] ?></p>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <i class="bi bi-tags text-success" style="font-size: 2rem;"></i>
                            <h4 class="mt-2">Catégories</h4>
                            <p class="h2 text-success"><?= $stats['category_count'] ?></p>
                        </div>
                        <div class="col-md-4">
                            <i class="bi bi-people text-info" style="font-size: 2rem;"></i>
                            <h4 class="mt-2">Utilisateurs</h4>
                            <p class="h2 text-info"><?= $stats['user_count'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
