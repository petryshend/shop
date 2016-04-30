$(function() {
    var calculateTotalPriceForCartItems = function(data) {
        console.dir(data);
        for (var i = 0; i < data.length; i++) {
            var price = parseFloat(data[i].productPrice);
            data[i].totalPrice = price * data[i].quantity;
        }
        return data;
    };

    var showCartModal = function() {
        $.ajax({
            url: '/cart/get',
            type: 'POST'
        }).done(function(data) {
            if (data.length) {
                data = JSON.parse(data);
                data = calculateTotalPriceForCartItems(data);
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
            $('#cartModal').modal('show');
        }).fail(function() {
            alert('fail');
        });
    };

    var addItemToCart = function() {
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
            showCartModal();
        }).fail(function() {
            alert('fail');
        });
    };

    $('#add-to-cart-button').on('click', addItemToCart) ;
    $('#show-cart-button').on('click', showCartModal);
});