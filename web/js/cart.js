$(function() {
    $('#add-to-cart-button').on('click', function() {
        var productId = $('input[name=selected-product-id]').val();
        var productName = $('input[name=selected-product-name]').val();
        $.ajax({
            url: '/cart/add',
            type: 'POST',
            data: {
                productId: productId,
                productName: productName,
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
            var tableHtml;
            if (data.length) {
                tableHtml = createCartItemsTable(JSON.parse(data));
            } else {
                tableHtml = '';
            }
            console.log(data);
            $('#cart-table').html(tableHtml);
        }).fail(function() {
            alert('fail');
        });

        $('#myModal').modal('show');
    });

    function createCartItemsTable(data) {
        var table = $('<table></table>');
        var tableHeader = $('<thead></thead>');
        tableHeader.append($('<th>Id</th>'));
        tableHeader.append($('<th>Name</th>'));
        tableHeader.append($('<th>Quantity</th>'));
        var tableBody = $('<tbody></tbody>');
        $.each(data, function(index, row) {
            var tableRow = $('<tr></tr>');
            tableRow.append($('<td>' + row.productId + '</td>'));
            tableRow.append($('<td>' + row.productName + '</td>'));
            tableRow.append($('<td>' + row.quantity + '</td>'));
            tableBody.append(tableRow);
        });
        table.append(tableHeader);
        table.append(tableBody);
        return table;
    }
});