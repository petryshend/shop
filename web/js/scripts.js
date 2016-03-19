$(function() {

    $('#items-per-page').on('change', function() {
        var itemsPerPage = $(this).val();
        window.location.search = jQuery.query.set('items-per-page', itemsPerPage);
    });

    $('#add-to-cart-button').on('click', function() {
        var productId = $('input[name=selected-product]').val();
        $.ajax({
            url: '/cart/add',
            type: 'POST',
            data: {
                productId: productId,
                quantity: 1
            }
        }).done(function(data) {
            console.log(data);
        }).fail(function() {
            alert('fail');
        });
    }) ;

    $('#get-cart-button').on('click', function() {
        $.ajax({
            url: '/cart/get',
            type: 'POST'
        }).done(function(data) {
            console.log(data);
        }).fail(function() {
            alert('fail');
        });
    }) ;

});