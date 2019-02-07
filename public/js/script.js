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

    /*var $collectionHolder = $('div.tickets');

    /!*$collectionHolder.data('index', $collectionHolder.children('div').length);*!/
    var index = $collectionHolder.children('div').length;

    // On ajoute un nouveau champ à chaque clic sur le lien d'ajout.
    $('#add_ticket').click(function(e) {
        addTicket($collectionHolder);

        e.preventDefault(); // évite qu'un # apparaisse dans l'URL
        return false;
    });

    var $container = $('div#ticket_order_tickets');
    var index2 = $container.find(':input').length;
    if (0 != index2) {
        alert('yo');
    }
    
    // On ajoute un premier champ automatiquement s'il n'en existe pas déjà un.
    if (index == 0) {
        addTicket($collectionHolder);
    } else {
        // S'il existe déjà des tickets, on ajoute un lien de suppression pour chacune d'entre elles
        $collectionHolder.children('div').each(function() {
            addDeleteLink($(this));
        });
    }


    // La fonction qui ajoute un formulaire CategoryType
    function addTicket($collectionHolder) {
        // Dans le contenu de l'attribut « data-prototype », on remplace :
        // - le texte "__name__label__" qu'il contient par le label du champ
        // - le texte "__name__" qu'il contient par le numéro du champ
        var template = $collectionHolder.attr('data-prototype')
            .replace(/__name__label__/g, (index+1))
            .replace(/__name__/g, index)
        ;

        // On crée un objet jquery qui contient ce template
        var $prototype = $(template);

        // On ajoute au prototype un lien pour pouvoir supprimer la catégorie
        addDeleteLink($prototype);

        // On ajoute le prototype modifié à la fin de la balise <div>
        $collectionHolder.append($prototype);

        var indexBis = 1;

        $collectionHolder.find('h3').each(function() {
            $(this).html('Ticket n°'+indexBis);
            indexBis++
        });

        // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
        index++;
    }


    // La fonction qui ajoute un lien de suppression d'un ticket
    function addDeleteLink($prototype) {
        // Création du lien
        var $deleteLink = $('<a href="#" class="btn btn-danger btn-sm">Supprimer</a>');

        // Ajout du lien
        $prototype.append($deleteLink);

        // Ajout du listener sur le clic du lien pour effectivement supprimer la catégorie
        $deleteLink.click(function(e) {
            $prototype.remove();

            var indexBis = 1;

            $collectionHolder.find('h3').each(function() {
                $(this).html('Ticket n°'+indexBis);
                indexBis++
            });

            e.preventDefault(); // évite qu'un # apparaisse dans l'URL
            return false;
        });
    }*/





    // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
    var $container = $('div#ticket_order_tickets');

    // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
    var index = $container.find(':input').length;

    ticketReorder();

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
            ticketReorder();
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

        ticketReorder();

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

            ticketReorder();

            e.preventDefault(); // évite qu'un # apparaisse dans l'URL
            return false;
        });
    }

    function ticketReorder() {
        var indexBis = 1;

        $container.children('div').each(function() {
            $(this).find('h3').html('Ticket n°'+indexBis);
            indexBis++
        });
    }

});