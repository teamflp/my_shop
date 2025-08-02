
# Plan de Développement pour "Ma Boutique"

---

## Phase 1 : Le Cœur de l'E-commerce (Fonctionnalités Essentielles)

🎯 **Objectif** : Permettre à un utilisateur de faire un achat de A à Z.

### 1. Le Panier d'Achat (Shopping Cart)

- **Logique** :

  - Utiliser la session PHP (`$_SESSION['cart']`) pour stocker les produits ajoutés.

- **Actions** :

  - Ajouter un produit au panier depuis la page produit.
  - Afficher un résumé du panier (ex : une icône avec le nombre d'articles dans le header).
  - Créer une page dédiée (`cart.php`) pour : 
    - voir les détails du panier,
    - modifier les quantités,
    - supprimer des articles.

- **Interface** :

  - Un bouton **"Ajouter au panier"** sur les fiches produits.

---

### 2. Le Processus de Commande (Checkout)

- **Logique** :

  - Un tunnel de commande simple pour commencer.

- **Étapes** :

  1. Depuis la page du panier, un bouton **"Passer la commande"**.
  2. Une page formulaire pour que l'utilisateur (connecté) confirme ou saisisse son **adresse de livraison**.
  3. Une page de **résumé de commande** (produits, total, adresse).
  4. **Simulation de Paiement** : Un bouton **"Confirmer et Payer"** (sans traitement bancaire réel).

- **Base de données** :

  - `orders` : 
    - `id`, `user_id`, `total_price`, `shipping_address`, `status` ('en attente', 'expédiée', 'livrée'), `created_at`.
  - `order_items` : 
    - `id`, `order_id`, `product_id`, `quantity`, `price_at_purchase` (important de stocker le prix au moment de l'achat !).

---

### 3. Historique des Commandes Utilisateur

- **Logique** :

  - Permettre à un utilisateur connecté de voir ses commandes passées.

- **Interface** :

  - Ajouter une section **"Mes Commandes"** dans `profile.php` : 
    - Liste des commandes,
    - Statut de chaque commande,
    - Lien vers les détails.

---

## Phase 2 : Amélioration de l'Expérience Utilisateur (UX)

🎯 **Objectif** : Améliorer l’ergonomie, la navigation et les interactions.

### 1. Recherche et Filtrage de Produits

- **Recherche** :

  - Barre de recherche dans le header (nom et description des produits).

- **Filtrage** :

  - Sur la page d’accueil ou les pages catégories : 
    - Par **catégorie**,
    - Par **fourchette de prix** (slider ou champs min/max),
    - Par tri : "prix croissant/décroissant", "nouveautés".

---

### 2. Avis et Notes sur les Produits

- **Logique** :

  - Autoriser les utilisateurs connectés à : 
    - Laisser une **note** (1 à 5 étoiles),
    - Écrire un **commentaire** sur les produits achetés.

- **Base de données** :

  - `reviews` : 
    - `id`, `product_id`, `user_id`, `rating`, `comment`, `created_at`.

- **Interface** :

  - Afficher la **note moyenne** sur la liste des produits,
  - Afficher les **avis détaillés** sur la page produit.

---

### 3. Navigation par Catégories

- **Interface** : 
  - Ajouter un menu déroulant **"Catégories"** dans le header : 
    - Liste des catégories principales,
    - Navigation facilitée.

---

## Phase 3 : Évolution du Panneau d'Administration

🎯 **Objectif** : Donner plus de pouvoir à l’admin pour la gestion efficace.

### 1. Gestion des Commandes

- **Interface** :

  - Nouvelle section **"Gérer les Commandes"** dans la sidebar de l’admin.

- **Fonctionnalités** :

  - Lister toutes les commandes avec leur statut,
  - Voir le détail d’une commande (client, produits, adresse),
  - Changer le **statut** (ex : "en attente" → "expédiée").

---

### 2. Gestion des Stocks

- **Logique** :

  - Ajouter un champ `stock` à la table `products`,
  - Décrémenter le stock lors de la validation d'une commande.

- **Interface** :

  - Afficher **"En stock" / "Épuisé"** sur les pages produits,
  - Empêcher l’ajout au panier si le stock est à 0,
  - Permettre à l’admin de modifier le stock depuis l’admin.

---

### 3. Tableau de Bord Amélioré

- **Interface** :

  - Ajouter de nouveaux widgets à `admin_dashboard.php`.

- **Idées** :

  - **Graphique** des ventes des 7 derniers jours,
  - **Top 5 produits les plus vendus**,
  - **Alerte** pour les produits à faible stock.

---

## Phase 4 : Fondations Techniques et Sécurité

🎯 **Objectif** : Améliorer la qualité technique, la sécurité et le SEO.

### 1. URL Rewriting (URLs Propres)

- **Objectif** :

  - Rendre les URLs lisibles et meilleures pour le SEO.

- **Exemples** :

  - `index.php?page=product&id=12` → `/produit/12/nom-du-produit`
  - `admin.php?action=products` → `/admin/produits`

- **Comment** :

  - Utiliser `.htaccess` et ajuster le routeur (`index.php`, `admin.php`).

---

### 2. Protection CSRF (Cross-Site Request Forgery)

- **Objectif** :

  - Sécuriser tous les formulaires (connexion, inscription, ajout de produit...).

- **Logique** :

  - Générer un **token unique** par session,
  - L’ajouter comme champ caché dans chaque formulaire,
  - Le vérifier côté serveur avant traitement.

---