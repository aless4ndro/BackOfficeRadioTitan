$(".delete-btn").click(function(e) {// on écoute l'événement "click" sur le bouton
    e.preventDefault();  // empêche le bouton de soumettre le formulaire

    var articleId = $(this).data("data_id");  // récupère l'ID de l'article du bouton

    $.ajax({// on envoie une requête AJAX au fichier de traitement
        url: "/espace_admin/publier_article.php",
        type: "POST",
        data: {
            id: articleId // on envoie l'ID de l'article au fichier de traitement
        },
        success: function(data) {
            // code à exécuter lorsque la requête réussit
            // par exemple, vous pourriez supprimer l'article de la liste ici
            $("#list-item" + articleId).remove();
        },
        error: function(jqXHR, textStatus, errorThrown) {// code à exécuter en cas d'erreur
            // code à exécuter en cas d'erreur
            console.error(textStatus, errorThrown);// on affiche la réponse du serveur dans la console
        }
    });
});
