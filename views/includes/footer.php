</main>

<footer class="container-fluid mt-auto bg-dark text-white">
    <div class="container py-4">
        <div class="row">
            <div class="col-md-4 mb-4 mb-md-0">
                <h5><i class="bi bi-shop"></i> Ma Boutique</h5>
                <p class="text-muted">Votre boutique unique pour des produits de qualité à prix abordables.</p>
                <div class="d-flex">
                    <a href="#" class="text-white mr-3"><i class="bi bi-facebook" style="font-size: 1.5rem;"></i></a>
                    <a href="#" class="text-white mr-3"><i class="bi bi-twitter" style="font-size: 1.5rem;"></i></a>
                    <a href="#" class="text-white mr-3"><i class="bi bi-instagram" style="font-size: 1.5rem;"></i></a>
                    <a href="#" class="text-white"><i class="bi bi-linkedin" style="font-size: 1.5rem;"></i></a>
                </div>
            </div>
            <div class="col-md-2 mb-4 mb-md-0">
                <h5>Boutique</h5>
                <ul class="list-unstyled">
                    <li><a href="index.php" class="text-muted"><i class="bi bi-chevron-right"></i> Produits</a></li>
                    <li><a href="#" class="text-muted"><i class="bi bi-chevron-right"></i> Catégories</a></li>
                    <li><a href="#" class="text-muted"><i class="bi bi-chevron-right"></i> Nouveautés</a></li>
                    <li><a href="#" class="text-muted"><i class="bi bi-chevron-right"></i> Meilleures ventes</a></li>
                </ul>
            </div>
            <div class="col-md-2 mb-4 mb-md-0">
                <h5>Assistance</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-muted"><i class="bi bi-chevron-right"></i> Nous contacter</a></li>
                    <li><a href="#" class="text-muted"><i class="bi bi-chevron-right"></i> FAQ</a></li>
                    <li><a href="#" class="text-muted"><i class="bi bi-chevron-right"></i> Livraison</a></li>
                    <li><a href="#" class="text-muted"><i class="bi bi-chevron-right"></i> Retours</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Newsletter</h5>
                <p class="text-muted">Inscrivez-vous pour recevoir des mises à jour sur les nouveautés et les promotions.</p>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Votre email" aria-label="Votre email">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"><i class="bi bi-envelope"></i> S'abonner</button>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <i class="bi bi-shield-check text-success mr-2" style="font-size: 1.5rem;"></i>
                    <span class="text-muted">Paiements sécurisés</span>
                </div>
            </div>
        </div>
        <hr class="my-4 bg-secondary">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-left">
                <span class="text-muted">&copy; <?= date('Y') ?> Ma Boutique. Tous droits réservés.</span>
            </div>
            <div class="col-md-6 text-center text-md-right">
                <img src="https://via.placeholder.com/50x30" alt="Visa" class="ml-2">
                <img src="https://via.placeholder.com/50x30" alt="Mastercard" class="ml-2">
                <img src="https://via.placeholder.com/50x30" alt="PayPal" class="ml-2">
                <img src="https://via.placeholder.com/50x30" alt="Apple Pay" class="ml-2">
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<!-- Chemin corrigé pour pointer vers le dossier assets à la racine -->
<script src="assets/js/scripts.js"></script>
</body>
</html>
