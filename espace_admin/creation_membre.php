<?php
session_start();
include('config.php');
require('permission_admin.php');


if (isset($_POST['submit'])) { // Si le formulaire est soumis
  $pseudo = htmlspecialchars($_POST['pseudo']);// On sécurise les données rentrées par l'utilisateur
  $email = htmlspecialchars($_POST['email']);
  $pass = htmlspecialchars($_POST['pass']);
  $comfirmation_pass = htmlspecialchars($_POST['comfirmation_pass']);
  $role = htmlspecialchars($_POST['role']);


  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // Validate email address
    echo "Format d'e-mail invalide";
    exit;
  }

  if (strlen($pass) < 8) {
    echo "Le mot de passe doit comporter au moins 8 caractères";// On vérifie que le mot de passe contient au moins 8 caractères
    exit;// On arrête le script
  } elseif (!preg_match("#[0-9]+#", $pass)) {// On vérifie que le mot de passe contient au moins un chiffre
    echo "Le mot de passe doit contenir au moins un chiffre";// On affiche un message d'erreur
    exit;
  } elseif (!preg_match("#[a-zA-Z]+#", $pass)) {// On vérifie que le mot de passe contient au moins une lettre
    echo "Le mot de passe doit contenir au moins une lettre";
    exit;
  } elseif (!preg_match("#[A-Z]+#", $pass)) {// On vérifie que le mot de passe contient au moins une lettre majuscule
    echo "Le mot de passe doit contenir au moins une lettre majuscule";
    exit;
  } elseif (!preg_match("#\W+#", $pass)) {// On vérifie que le mot de passe contient au moins un caractère spécial
    echo "Le mot de passe doit contenir au moins un caractère spécial";
    exit;
  } elseif ($pass != $comfirmation_pass) {// On vérifie que les deux mots de passe sont identiques
    echo "Les mots de passe ne correspondent pas";
    exit;
  } else {
    echo "Mot de passe valide";
  }

  $pass = password_hash($pass, PASSWORD_DEFAULT); // Hash password

  $stmt = $conn->prepare("INSERT INTO membres (pseudo, email, pass, role) VALUES (?, ?, ?, ?)"); // Insertion des données dans la table membres
  $stmt->execute([$pseudo, $email, $pass, $role]); // Exécution de la requête

  echo "Membre créé avec succès.";
  header('Location: ./Back-end/index.php');
}
?>

<?php
include('./include/header.php');
include('./include_sidebar/index.php');
include('./include_breadcrump/index.php');
?>


<section class="vh-100 px-3 px-md-5 mx-auto" style="background-color: #eee;">
  <div class="container-fluid h-100">
    <div class="row d-flex justify-content-center">
      <div class="col-lg-12 col-xl-11">
        <!-- Supprimer ou réduire la marge supérieure négative -->
        <div class="card text-black" style="border-radius: 25px;">
          <div class="card-body p-md-5">
            <div class="row justify-content-center">
              <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Création membres</p>

                <form method="POST" action="" class="mx-1 mx-md-4">

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <label for="pseudo" class="form-label">Pseudo</label>
                      <input type="text" name="pseudo" placeholder="Pseudo" class="form-control" id="pseudo">
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <label for="email" class="form-label">Email</label>
                      <input type="email" name="email" placeholder="Email" class="form-control" id="email">
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <label for="pass" class="form-label">Password</label>
                      <input type="password" name="pass" placeholder="Password" class="form-control" id="pass">
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <label for="confirmation_pass" class="form-label">Password Confirmation</label>
                      <input type="password" name="comfirmation_pass" placeholder="Password comfirm" class="form-control" id="confirmation_pass">
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <label for="role" class="form-label">Role</label>
                      <select name="role" class="form-select" id="role">
                        <option value="admin">Admin</option>
                        <option value="contributeur">Contributeur</option>
                        <option value="user">Utilisateur</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-check d-flex justify-content-center mb-5">
                    <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3c" />
                    <label class="form-check-label" for="form2Example3">
                      I agree all statements in <a href="#!">Terms of service</a>
                    </label>
                  </div>

                  <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                    <button type="submit" name="submit" class="btn btn-primary">Créer</button>
                  </div>

                </form>

              </div>
              <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp" class="img-fluid" alt="Sample image" style="margin-top: -50px;">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</section>
<?php include('./include/footer.php'); ?>