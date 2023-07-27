<?php

if (session_status() == PHP_SESSION_NONE) {
    // Si aucune session n'est active, on la démarre
    session_start();
}
include('config.php');

if(isset($_GET['id']) && trim($_GET['id']) != '') {
    $getid = $_GET['id'];

    $req = $conn->prepare('SELECT * FROM podcast WHERE id = ?');
    $req->execute(array($getid));
    if($req->rowCount() == 1) {
        $donnees = $req->fetch();
        if(isset($_POST['valider'])) {
            $titre = htmlspecialchars($_POST['title']);
            $file_path = htmlspecialchars($_POST['file_path']);
            $rubrique = htmlspecialchars($_POST['rubrique']);
            $emission = htmlspecialchars($_POST['emission']);
            $interview = htmlspecialchars($_POST['interview']);
            $id_categorie = htmlspecialchars($_POST['id_categorie']);

            if(!empty($titre) AND !empty($file_path) AND !empty($rubrique) AND !empty($emission) AND !empty($interview) AND !empty($id_categorie)) {
                $req = $conn->prepare('UPDATE podcasts SET title = ?, file_path = ?, rubrique = ?, emission = ?, interview = ?, id_categorie = ? WHERE id = ?');
                $req->execute(array($titre, $file_path, $rubrique, $emission, $interview, $id_categorie, $getid));
                header('Location: modifier_podcast.php');
            } else {
                echo "Veuillez remplir tous les champs";
            }
        }
    } else {
        echo "Ce podcast n'existe pas";
    }
}

$req = $conn->query('SELECT * FROM podcast');
$podcasts = $req->fetchAll();


?>

<?php 
include('./include/header.php');
include('./include_sidebar/index.php');
include('./include_breadcrump/index.php');
?>

<div class="container mt-4">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Titre</th>
                <th scope="col">Chemin du fichier</th>
                <th scope="col">Rubrique</th>
                <th scope="col">Émission</th>
                <th scope="col">Interview</th>
                <th scope="col">Catégorie</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($podcasts as $podcast): ?>
            <tr>
                <td><?= htmlspecialchars($podcast['title']); ?></td>
                <td><?= nl2br(htmlspecialchars($podcast['file_path'])); ?></td>
                <td><?= nl2br(htmlspecialchars($podcast['rubrique'])); ?></td>
                <td><?= nl2br(htmlspecialchars($podcast['emission'])); ?></td>
                <td><?= nl2br(htmlspecialchars($podcast['id_categorie'])); ?></td>
                <td>
                <div class="truncate-text" style="width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        <?= nl2br(htmlspecialchars($podcast['intervue'])); ?>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <a href="?id=<?= $podcast['id']; ?>" class="btn btn-primary btn-sm">Modifier</a>
    <br>
    <br>
</div>


    <?php if(isset($_GET['id']) and !empty($_GET['id'])): ?>
        <section class="vh-100 px-3 px-md-5 mx-auto" style="background-color: #eee;">
  <div class="container-fluid h-100">
    <div class="row d-flex justify-content-center">
      <div class="col-lg-12 col-xl-11">
        <!-- Supprimer ou réduire la marge supérieure négative -->
        <div class="card text-black" style="border-radius: 25px;">
          <div class="card-body p-md-5">
            <div class="row justify-content-center">
              <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Modification podcast</p>

                <form method="POST" action="" class="mx-1 mx-md-4">

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                    <label for="title">Titre</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Titre" value="<?php echo $donnees['title']; ?>"><!-- title est une colonne de la bdd elle est initie par $titre qui vaut title $titre = htmlspecialchars($_POST['title']); on faison cela dans notre placeholder on aura les donnees du podcast selectionne  -->
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                    <label for="file_path">File Path</label>
                    <input type="file" class="form-control" id="file_path" name="file_path" placeholder="File Path">
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                    <label for="rubrique">Rubrique</label>
                    <input type="text" class="form-control" id="rubrique" name="rubrique" placeholder="Rubrique" value="<?php echo $donnees['rubrique']; ?>">
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                    <label for="emission">Emission</label>
                    <input type="text" class="form-control" id="emission" name="emission" placeholder="Emission" value="<?php echo $donnees['emission']; ?>">
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                    <label for="interview">Interview</label>
                    <input type="text" class="form-control" id="intervue" name="intervue" placeholder="Interview" value="<?php echo $donnees['intervue']; ?>">
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                    <label for="id_categorie">ID Categorie</label>
                    <input type="text" class="form-control" id="id_categorie" name="id_categorie" placeholder="ID Categorie" value="Categorie<?php echo $donnees['id_categorie']; ?>">
                    </div>
                  </div>

                  <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                    <button type="submit" name="submit" class="btn btn-primary">Modifier</button>
                  </div>

                </form>

              </div>
              <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                <img src="https://images.unsplash.com/photo-1593697820826-2e76c9720a99?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" class="img-fluid" alt="Sample image" style="margin-top: -50px;">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</section>
    <?php endif; ?>
   <?php include('./include/footer.php');?>