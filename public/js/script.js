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

});