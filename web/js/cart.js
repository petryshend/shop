$(function() {
    $('#add-to-cart-button').on('click', function() {
        var productId = $('input[name=selected-product-id]').val();
        var productName = $('input[name=selected-product-name]').val();
        var productPrice = $('input[name=selected-product-price]').val();
        $.ajax({
            url: '/cart/add',
            type: 'POST',
            data: {
                productId: productId,
                productName: productName,
                productPrice: productPrice,
                quantity: 1
            }
        }).done(function(data) {
            console.log(data);
        }).fail(function() {
            alert('fail');
        });
    }) ;

    $('#show-cart-button').on('click', function() {
        $.ajax({
            url: '/cart/get',
            type: 'POST'
        }).done(function(data) {
            if (data.length) {
                data = JSON.parse(data);
            } else {
                data = '';
            }
            var template = $('#cart-table-template').html();
            var rendered = Mustache.render(template,
                {
                    "items": data
                }
            );
            $('#cart-table-placeholder').html(rendered);
        }).fail(function() {
            alert('fail');
        });
    });
});