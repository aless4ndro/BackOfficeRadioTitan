<?php
// Connexion à la base de données
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('config.php');

// Récupération de toutes les pistes audio
$stmt = $conn->prepare("SELECT * FROM audio ORDER BY position ASC");
$stmt->execute();
$tracks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php
include('./include/header.php');
include('./include_sidebar/index.php');
include('./include_breadcrump/index.php');
?>

<h1>Admin - Playlist du lecteur global</h1>

<form id="playlist-form">
    <?php foreach ($tracks as $track): ?>
        <div>
            <input type="checkbox" id="track-<?php echo $track['id']; ?>" <?php if ($track['lecteur'] == 1) echo 'checked'; ?> />
            <label for="track-<?php echo $track['id']; ?>"><?php echo $track['title']; ?></label>
        </div>
    <?php endforeach; ?>
</form>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {// Lorsque le document est prêt...
    // Lorsqu'une case à cocher est modifiée...
    $('#playlist-form input[type=checkbox]').change(function() {
        // Récupère l'ID de la piste audio
        var id = $(this).attr('id').split('-')[1];

        // Détermine si la case à cocher est cochée ou non
        var inPlaylist = $(this).is(':checked') ? 1 : 0;

        // Envoie une requête au serveur pour mettre à jour le statut de la piste audio dans la playlist
        $.post('update_playlist.php', {id: id, inPlaylist: inPlaylist});
    });
});
</script>
<?php include('./include/footer.php'); ?>