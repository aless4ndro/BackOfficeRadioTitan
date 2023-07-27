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
              <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin' && $_SESSION['id'] != $donnees['id']) { ?>
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
              <div>
                <!-- Le titre de l'article -->
                <span><?= htmlspecialchars($donnees['titre']); ?></span>
              </div>
              <div id="icons" class="ml-auto">
                <!-- L'icône de l'état de l'article -->
                <?php if ($donnees['is_approved'] == 1) : ?>
                  <i class="fas fa-check-circle text-success"></i>
                <?php else : ?>
                  <i class="fas fa-hourglass-half text-warning"></i>
                <?php endif; ?>

                <!-- Le bouton de suppression de l'article -->
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
                  <a href="../supprime_article.php?id=<?php echo $donnees['id']; ?>" class="badge badge-danger badge-pill ml-2">
                    <i class="fas fa-trash-alt"></i>
                  </a>
                <?php } ?>
              </div>
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
              <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
                <a href="../delete_podcast.php?id=<?php echo $donnees['id']; ?>" class="badge badge-danger badge-pill">
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
  <!-- Voir les audio -->
  <div class="col-md-4 stretch-card grid-margin">
    <div class="card bg-gradient-success card-img-holder text-white">
      <div class="card-body">
        <h4 class="card-title">Audio</h4>
        <ul class="list-group">
          <?php
          $req = $conn->query('SELECT * FROM audio');
          while ($donnees = $req->fetch()) {
          ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <?= htmlspecialchars($donnees['title']); ?>
              <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
                <a href="../delete_audio.php?id=<?php echo $donnees['id']; ?>" class="badge badge-danger badge-pill">
                  <i class="fas fa-trash-alt mr-3"></i>
                </a>
              <?php } ?>
            </li>
          <?php } ?>

        </ul>
      </div>
    </div>
  </div>
  <!-- Voir les catégories -->

  <div class="col-md-4 grid-margin stretch-card">
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
              <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
                <a href="../delete_categorie.php?id_categorie=<?php echo $donnees['id_categorie']; ?>" class="badge badge-danger badge-pill">
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
  <!-- Voir les audio -->
  <div class="col-md-4 stretch-card grid-margin">
    <div class="card bg-gradient-success card-img-holder text-white">
      <div class="card-body">
        <h4 class="card-title">Album</h4>
        <ul class="list-group">
          <?php
          $req = $conn->query('SELECT * FROM albums');
          while ($donnees = $req->fetch()) {
          ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <?= htmlspecialchars($donnees['title']); ?>
              <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
                <a href="../delete_album.php?id=<?php echo $donnees['id']; ?>" class="badge badge-danger badge-pill">
                  <i class="fas fa-trash-alt mr-3"></i>
                </a>
              <?php } ?>
            </li>
          <?php } ?>

        </ul>
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

if (isset($_SESSION['message'])) { // If a message is set, display it
  echo "<p>" . htmlspecialchars($_SESSION['message']) . "</p>";
  $_SESSION['message'] = '';
}

?>
<div class="row">
  <div class="col-md-7 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Articles en attente d'approbation</h4>
        <?php foreach ($articles as $article) : ?>
          <div class="article">
            <h5><?php echo "Titre : " . htmlspecialchars($article['titre']); ?></h5>
            <p><?php print "Contenu : " . $article['contenu']; ?></p>
            <p><?php echo "Auteur : " . htmlspecialchars($article['pseudo']); ?></p>
            <!-- Ici, on affiche l'icône en fonction de l'état de l'article -->
            <a href="../validation_admin_articles.php?id=<?php echo $article['id']; ?>" class="btn btn-success">Approuver</a>
            <a href="../supprime_article.php?id=<?php echo $article['id']; ?>" class="btn btn-danger">Supprimer</a>
          </div>
          <hr>
        <?php endforeach; ?>

      </div>
    </div>
  </div>


  <div class="col-md-4 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Actualités</h4>
        <ul class="list-group">
          <?php
          $req = $conn->query('SELECT * FROM actualites');
          while ($donnees = $req->fetch()) {
          ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <?= htmlspecialchars($donnees['titre']); ?>
              <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
                <a href="../delete_actualites.php?id=<?php echo $donnees['id']; ?>" class="badge badge-danger badge-pill">
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
  <!-- Calendar -->

  <div class="col-lg-6 col-md-6 col-sm-8 grid-margin stretch-card">
    <div class="calendar">
      <header class="calendar__header">
        <div class="calendar__month"></div>
        <div class="calendar__year"></div>
      </header>
      <div class="calendar__grid">
        <div class="calendar__day-names">
          <span class="calendar__day-name">S</span>
          <span class="calendar__day-name">M</span>
          <span class="calendar__day-name">T</span>
          <span class="calendar__day-name">W</span>
          <span class="calendar__day-name">T</span>
          <span class="calendar__day-name">F</span>
          <span class="calendar__day-name">S</span>
        </div>
        <div class="calendar__day-numbers"></div>
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