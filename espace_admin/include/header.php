<?php
//basename() function qui permet de récupérer le nom du fichier courant dans lequel on se trouve de manière dynamique afin avoir le style css dans tous les fichiers peut importe le chemin ou dossier dans lequel on se trouve
$current_file = basename($_SERVER['PHP_SELF']);
$filesInAdminDir = ['creation_membre.php', 'creation_playlist.php', 'edit_actualites.php','modifier_actualites.php', 'upload_audio.php', 'modifier_audio.php', 'upload_podcast.php', 'creation_album.php', 'modifier_album.php',  'createEvent.php', 'publier_article.php', 'edit_categorie.php', 'modifier_album.php', 'modifier_podcast.php', 'modifier_video.php', 'modifier_membre.php', 'modifier_event.php', 'modifier_article.php', 'modifier_categorie.php'];
 
if (in_array($current_file, $filesInAdminDir)) {
  $pathToBackend = 'Back-end/';
  $pathToAdmin = '';
} else {
  $pathToBackend = '';
  $pathToAdmin = 'espace_admin/';
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
  <!-- plugins:css -->
  <!-- plugins:css -->

  <link rel="stylesheet" href="<?php echo $pathToBackend; ?>assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="<?php echo $pathToBackend; ?>assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
  <link rel="stylesheet" href="<?php echo $pathToBackend; ?>assets/css/style.css">
  <!-- End layout styles -->
  <link rel="shortcut icon" href="<?php echo $pathToBackend; ?>assets/images/favicon.ico" />

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
  <!-- MDB -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet" />

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
            <a class="dropdown-item" href="../logout.php">
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