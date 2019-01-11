$(document).ready(function() {

    /*$('.js-datepicker').each(function () {
        $(this).datepicker({
            format: 'yyyy-mm-dd'
        });
    });
*/
    // $('.js-datepicker').on("click", function (e) {
    //     e.preventDefault();
    //     $(this).datepicker({
    //         format: 'yyyy-mm-dd'
    //     });
    // });

    // $('.js-datepicker').click(function(e) {
    //     e.preventDefault();
    //     $(this).datepicker({
    //         format: 'dd-mm-yyyy'
    //     });
    // });


    $( ".js-datepicker" ).datepicker({
        dateFormat: "dd-mm-yy"
    });


    /*$('input[id="ticket_order_visitDate"]').on("click", function () {
        $(this).datepicker({
            format: 'yyyy-mm-dd'
        });
    });*/

/***********************************************/
/*    generateur tickets multiples imbriqué    */
/***********************************************/

    // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
    var $container = $('div#ticket_order_tickets');

    // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
    var index = $container.find(':input').length;

    console.log($container.find(':input'));

    // On ajoute un nouveau champ à chaque clic sur le lien d'ajout.
    $('#add_ticket').click(function(e) {
        addTicket($container);

        e.preventDefault(); // évite qu'un # apparaisse dans l'URL
        return false;
    });

    // On ajoute un premier champ automatiquement s'il n'en existe pas déjà un (cas d'une nouvelle annonce par exemple).
    if (index == 0) {
        addTicket($container);
    } else {
        // S'il existe déjà des catégories, on ajoute un lien de suppression pour chacune d'entre elles
        $container.children('div').each(function() {
            addDeleteLink($(this));
        });
    }

    // La fonction qui ajoute un formulaire CategoryType
    function addTicket($container) {
        // Dans le contenu de l'attribut « data-prototype », on remplace :
        // - le texte "__name__label__" qu'il contient par le label du champ
        // - le texte "__name__" qu'il contient par le numéro du champ
        var template = $container.attr('data-prototype')
            .replace(/__name__label__/g, 'Ticket n°' + (index+1))
            .replace(/__name__/g,        index)
        ;

        // On crée un objet jquery qui contient ce template
        var $prototype = $(template);

        // On ajoute au prototype un lien pour pouvoir supprimer la catégorie
        addDeleteLink($prototype);

        // On ajoute le prototype modifié à la fin de la balise <div>
        $container.append($prototype);

        // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
        index++;
    }

    // La fonction qui ajoute un lien de suppression d'une catégorie
    function addDeleteLink($prototype) {
        // Création du lien
        var $deleteLink = $('<a href="#" class="btn btn-danger">Supprimer</a>');

        // Ajout du lien
        $prototype.append($deleteLink);

        // Ajout du listener sur le clic du lien pour effectivement supprimer la catégorie
        $deleteLink.click(function(e) {
            $prototype.remove();

            index--;

            e.preventDefault(); // évite qu'un # apparaisse dans l'URL
            return false;
        });
    }

});