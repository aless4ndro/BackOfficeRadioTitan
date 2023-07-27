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
          <a class="nav-link" href="./index.php">
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
              <li class="nav-item"> <a class="nav-link" href="<?php echo $pathToBackend; ?>../creation_membre.php">Créer le membre</a></li>
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
              <li class="nav-item"> <a class="nav-link" href="<?php echo $pathToBackend; ?>../publier_article.php">Créer l'article</a></li>
              <li class="nav-item"> <a class="nav-link" href="<?php echo $pathToBackend; ?>../modifier_article.php">Modifier l'article</a></li>
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
              <li class="nav-item"> <a class="nav-link" href="<?php echo $pathToBackend; ?>../upload_podcast.php">Créer un podcast</a></li>
              <li class="nav-item"> <a class="nav-link" href="<?php echo $pathToBackend; ?>../modifier_podcast.php">Modifier un podcast</a></li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#audio" aria-expanded="false" aria-controls="audio">
            <span class="menu-title">Audio</span>
            <i class="menu-arrow"></i>
            <i class="mdi mdi-audio menu-icon"></i>
          </a>
          <div class="collapse" id="audio">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="<?php echo $pathToBackend; ?>../upload_audio.php">Créer un audio</a></li>
              <li class="nav-item"> <a class="nav-link" href="<?php echo $pathToBackend; ?>../modifier_audio.php">Modifier un audio</a></li>
              <li class="nav-item"> <a class="nav-link" href="<?php echo $pathToBackend; ?>../creation_playlist.php">Création Playlist</a></li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#album" aria-expanded="false" aria-controls="album">
            <span class="menu-title">Album</span>
            <i class="menu-arrow"></i>
            <i class="mdi mdi-audio menu-icon"></i>
          </a>
          <div class="collapse" id="album">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="<?php echo $pathToBackend; ?>../creation_album.php">Créer un album</a></li>
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
          <li class="nav-item"> <a class="nav-link" href="<?php echo $pathToBackend; ?>../edit_categorie.php">Créer une categorie</a></li>
          <li class="nav-item"> <a class="nav-link" href="<?php echo $pathToBackend; ?>../modifier_categorie.php">Modifier une categorie</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#actualites" aria-expanded="false" aria-controls="actualites">
        <span class="menu-title">Actualites</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-format-list-bulleted-type menu-icon"></i>
      </a>
      <div class="collapse" id="actualites">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="<?php echo $pathToBackend; ?>../edit_actualites.php">Créer une actualite</a></li>
        </ul>
      </div>
    </li>
  </ul>
</nav>