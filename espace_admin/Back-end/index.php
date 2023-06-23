<?php

session_start();

$servername = "localhost";
$username = "root";
$password = "my-secret-pw";
$dbname = "espace_admin_altameos";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}


if (isset($_SESSION['pseudo'])) {
} else {
  header('Location: ./BackOfficeRadioTitan/espace_admin/connexion.php');
  exit;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Titan DashBoard</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">


  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <!-- endinject -->
  <!-- Layout styles -->
  <link rel="stylesheet" href="assets/css/style.css">
  <!-- End layout styles -->
  <link rel="shortcut icon" href="assets/images/favicon.ico" />
</head>

<body>
  <div class="d-flex align-items-center justify-content-between">
    <a href="https://www.bootstrapdash.com/product/purple-bootstrap-admin-template/"><i class="mdi mdi-home me-3 text-white"></i></a>
    <button id="bannerClose" class="btn border-0 p-0">
      <i class="mdi mdi-close text-white me-0"></i>
    </button>
  </div>
  </div>
  </div>
  </div>
  <!-- partial:partials/_navbar.html -->
  <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
      <!--SVG dashboard-->
      <a class="navbar-brand brand-logo" href="../index.php"><svg width="200" height="100" style="margin-top: 20px;" xmlns="http://www.w3.org/2000/svg">
          <text x="10" y="50" fill="blue" font-size="35">DashBoard</text>
        </svg>
        <!--SVG dashboard-->
        <a class="navbar-brand brand-logo-mini" href="index.html"><img src="assets/images/logo-mini.svg" alt="logo" /></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-stretch">
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
        <span class="mdi mdi-menu"></span>
      </button>
      <ul class="navbar-nav navbar-nav-right">
        <li class="nav-item nav-profile dropdown">
          <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="nav-profile-img">
              <img src="assets/images/faces/face1.jpg" alt="image">
              <span class="availability-status online"></span>
            </div>
            <div class="nav-profile-text">
              <p class="mb-1 text-black">
                <?php
                if (isset($_SESSION['pseudo'])) {
                  echo $_SESSION['pseudo'];
                } else {
                  echo "Non connecté";
                }
                ?>
              </p>
            </div>
          </a>
          <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="/espace_admin/logout.php">
              <i class="mdi mdi-logout me-2 text-primary"></i> Signout </a>
          </div>
        </li>
        <li class="nav-item d-none d-lg-block full-screen-link">
          <a class="nav-link">
            <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
          </a>
        </li>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
    </div>
  </nav>
  <!-- partial -->
  <div class="container-fluid page-body-wrapper">
    <!-- partial:partials/_sidebar.html -->
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
      <ul class="nav">
        <li class="nav-item nav-profile">
          <a href="#" class="nav-link">
            <div class="nav-profile-image">
              <img src="assets/images/faces/face1.jpg" alt="profile">
              <span class="login-status online"></span>
              <!--change to offline or busy as needed-->
            </div>
            <div class="nav-profile-text d-flex flex-column">
              <span class="font-weight-bold mb-2">
                <?php
                if (isset($_SESSION['pseudo'])) {
                  echo $_SESSION['pseudo'];
                } else {
                  echo "Non connecté";
                }
                ?>
              </span>
              <span class="text-secondary text-small">Project Manager</span>
            </div>
            <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.html">
            <span class="menu-title">Dashboard</span>
            <i class="mdi mdi-home menu-icon"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#membres" aria-expanded="false" aria-controls="membres">
            <span class="menu-title">Membres</span>
            <i class="menu-arrow"></i>
            <i class="mdi mdi-account-group menu-icon"></i>
          </a>
          <div class="collapse" id="membres">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="../creation_membre.php">Créer le membre</a></li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#articles" aria-expanded="false" aria-controls="articless">
            <span class="menu-title">Articles</span>
            <i class="menu-arrow"></i>
            <i class="mdi mdi-crosshairs-gps menu-icon"></i>
          </a>
          <div class="collapse" id="articles">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="../publier_article.php">Créer l'article</a></li>
              <li class="nav-item"> <a class="nav-link" href="../modifier_article.php">Modifier l'article</a></li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#podcasts" aria-expanded="false" aria-controls="podcasts">
            <span class="menu-title">Podcast</span>
            <i class="menu-arrow"></i>
            <i class="mdi mdi-podcast menu-icon"></i>
          </a>
          <div class="collapse" id="podcasts">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="../upload_podcast.php">Créer un podcast</a></li>
              <li class="nav-item"> <a class="nav-link" href="../modifier_podcast.php">Modifier un podcast</a></li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#albums" aria-expanded="false" aria-controls="albums">
            <span class="menu-title">Albums</span>
            <i class="menu-arrow"></i>
            <i class="mdi mdi-album menu-icon"></i>
          </a>
          <div class="collapse" id="albums">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="../upload_album.php">Créer un albums</a></li>
              <li class="nav-item"> <a class="nav-link" href="../modifier_album.php">Modifier un albums</a></li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#categories" aria-expanded="false" aria-controls="categories">
            <span class="menu-title">Catégories</span>
            <i class="menu-arrow"></i>
            <i class="mdi mdi-format-list-bulleted-type menu-icon"></i>
          </a>
          <div class="collapse" id="categories">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="../edit_categorie.php">Créer une categorie</a></li>
              <li class="nav-item"> <a class="nav-link" href="../modifier_categorie.php">Modifier une categorie</a></li>
            </ul>
          </div>
        </li>
      </ul>
    </nav>
    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="page-header">
          <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
              <i class="mdi mdi-home"></i>
            </span> Dashboard
          </h3>
          <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page">
                <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
              </li>
            </ul>
          </nav>
        </div>
        <!-- Voir les memebrs -->
        <div class="row">
          <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-danger card-img-holder text-white">
              <div class="card-body">
                <h4 class="card-title">Membres</h4>
                <ul class="list-group">
                  <?php
                  $req = $conn->query('SELECT * FROM membres');
                  while ($donnees = $req->fetch()) {
                  ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      <?= htmlspecialchars($donnees['pseudo']); ?> (<?= htmlspecialchars($donnees['role']); ?>)
                      <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') { ?>
                        <a href="/espace_admin/delete.php?id=<?php echo $donnees['id']; ?>" class="badge badge-danger badge-pill">
                          <i class="fas fa-trash-alt mr-3"></i>
                        </a>
                      <?php } ?>
                    </li>
                  <?php
                  }
                  ?>
                </ul>
              </div>
            </div>
          </div>
          <!-- Voir les articles -->
          <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-info card-img-holder text-white">
              <div class="card-body">
                <h4 class="card-title">Articles</h4>
                <ul class="list-group">
                  <?php
                  $req = $conn->query('SELECT * FROM articles');
                  while ($donnees = $req->fetch()) {
                  ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      <?= htmlspecialchars($donnees['titre']); ?>
                      <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') { ?>
                        <a href="/espace_admin/supprime_article.php?id=<?php echo $donnees['id']; ?>" class="badge badge-danger badge-pill">
                          <i class="fas fa-trash-alt mr-3"></i>
                        </a>
                      <?php } ?>
                    </li>
                  <?php
                  }
                  ?>
                </ul>
              </div>
            </div>
          </div>
          <!-- Voir les podcast -->
          <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-success card-img-holder text-white">
              <div class="card-body">
                <h4 class="card-title">Podcast</h4>
                <ul class="list-group">
                  <?php
                  $req = $conn->query('SELECT * FROM podcast');
                  while ($donnees = $req->fetch()) {
                  ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      <?= htmlspecialchars($donnees['title']); ?>
                      <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') { ?>
                        <a href="/espace_admin/delete_podcast.php?id=<?php echo $donnees['id']; ?>" class="badge badge-danger badge-pill">
                          <i class="fas fa-trash-alt mr-3"></i>
                        </a>
                      <?php } ?>
                    </li>
                  <?php
                  }
                  ?>
                </ul>
              </div>
            </div>
          </div>
          <!-- Voir les albums -->
          <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-success card-img-holder text-white">
              <div class="card-body">
                <h4 class="card-title">Albums</h4>
                <ul class="list-group">
                  <?php
                  $req = $conn->query('SELECT * FROM albums');
                  while ($donnees = $req->fetch()) {
                  ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      <?= htmlspecialchars($donnees['title']); ?>
                      <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') { ?>
                        <a href="/espace_admin/delete_albums.php?id=<?php echo $donnees['id']; ?>" class="badge badge-danger badge-pill">
                          <i class="fas fa-trash-alt mr-3"></i>
                        </a>
                      <?php } ?>
                    </li>
                  <?php } ?>

                </ul>
              </div>
            </div>
            <!-- Voir les catégories -->
          </div>
          <div class="col-md-5 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Catégories</h4>
                <ul class="list-group">
                  <?php
                  $req = $conn->query('SELECT * FROM categories');
                  while ($donnees = $req->fetch()) {
                  ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      <?= htmlspecialchars($donnees['nom_categorie']); ?>
                      <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') { ?>
                        <a href="/espace_admin/delete_categorie.php?id_categorie=<?php echo $donnees['id_categorie']; ?>" class="badge badge-danger badge-pill">
                          <i class="fas fa-trash-alt mr-3"></i>
                        </a>
                      <?php } ?>
                    </li>
                  <?php
                  }
                  ?>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <?php


        $articles = [];

        // If the user is an admin, display all unapproved articles
        if ($_SESSION['role'] == 'admin') {
          $req = $conn->prepare("SELECT articles.*, membres.pseudo /*Select all articles and their authors*/
          FROM articles 
          INNER JOIN membres ON articles.id_membre = membres.id /*Join the articles table with the membres table*/
          WHERE articles.is_approved = 0"); // Select only unapproved articles
          $req->execute();
          $articles = $req->fetchAll();
        }

        ?>
        <div class="row">
          <div class="col-md-7 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Articles en attente d'approbation</h4>
                  <div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                      <span class="sr-only">Loading...</span>
                    </div>
              </div>
              
              
              <?php foreach ($articles as $article) : ?>
                <div class="article">
                  <h5><?php echo "Titre : " . htmlspecialchars($article['titre']); ?></h5>
                  <p><?php print "Contenu : " . $article['contenu']; ?></p>
                  <p><?php echo "Auteur : " . htmlspecialchars($article['pseudo']); ?></p>
                  <a href="/espace_admin/publier_article.php?id=<?php echo $article['id']; ?>" class="btn btn-success">Approuver</a>
                  <a href="/espace_admin/supprime_article.php?id=<?php echo $article['id']; ?>" class="btn btn-danger">Supprimer</a>
                </div>
                <hr>
              <?php endforeach; ?>

            </div>
          </div>
        </div>
        <div class="col-md-5 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title text-white">Todo</h4>
              <div class="add-items d-flex">
                <input type="text" class="form-control todo-list-input" placeholder="What do you need to do today?">
                <button class="add btn btn-gradient-primary font-weight-bold todo-list-add-btn" id="add-task">Add</button>
              </div>
              <div class="list-wrapper">
                <ul class="d-flex flex-column-reverse todo-list todo-list-custom">
                  <li>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="checkbox" type="checkbox"> Meeting with Alisa </label>
                    </div>
                    <i class="remove mdi mdi-close-circle-outline"></i>
                  </li>
                  <li class="completed">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="checkbox" type="checkbox" checked> Call John </label>
                    </div>
                    <i class="remove mdi mdi-close-circle-outline"></i>
                  </li>
                  <li>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="checkbox" type="checkbox"> Create invoice </label>
                    </div>
                    <i class="remove mdi mdi-close-circle-outline"></i>
                  </li>
                  <li>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="checkbox" type="checkbox"> Print Statements </label>
                    </div>
                    <i class="remove mdi mdi-close-circle-outline"></i>
                  </li>
                  <li class="completed">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="checkbox" type="checkbox" checked> Prepare for presentation </label>
                    </div>
                    <i class="remove mdi mdi-close-circle-outline"></i>
                  </li>
                  <li>
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="checkbox" type="checkbox"> Pick up kids from school </label>
                    </div>
                    <i class="remove mdi mdi-close-circle-outline"></i>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    <footer class="footer">
      <div class="container-fluid d-flex justify-content-between">
        <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">Copyright © Altameos 2023</span>
      </div>
    </footer>
    <!-- partial -->
  </div>
  <!-- main-panel ends -->
  </div>
  <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="assets/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="assets/vendors/chart.js/Chart.min.js"></script>
  <script src="assets/js/jquery.cookie.js" type="text/javascript"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="assets/js/off-canvas.js"></script>
  <script src="assets/js/hoverable-collapse.js"></script>
  <script src="assets/js/misc.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page -->
  <script src="assets/js/dashboard.js"></script>
  <script src="assets/js/todolist.js"></script>
  <!-- End custom js for this page -->
</body>

</html>