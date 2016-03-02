$(function() {

    $('#items-per-page').on('change', function() {
        var itemsPerPage = $(this).val();
        window.location.search = jQuery.query.set('items-per-page', itemsPerPage);
    });

});