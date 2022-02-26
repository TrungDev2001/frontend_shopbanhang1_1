window.pageProductHotAll = 2;
$('#LoadMoreProduct').on('click', function () {
    var url = window.location.href;
    var price_range_min = $(this).attr('data-price_min');
    var price_range_max = $(this).attr('data-price_max');
    $.ajax({
        type: "get",
        url: url + '?page=' + (window.pageProductHotAll++),
        data: {
            'price_range_min': price_range_min,
            'price_range_max': price_range_max,
        },
        beforeSend: function () {
            $('#img-loading-content').css('display', 'block');
        },
        success: function (response) {
            if (response.status == 200) {
                $('#img-loading-content').css('display', 'none');
                $('#data_product_category').append(response.product_category_html);
                if (response.product_category_html == '') {
                    $('#LoadMoreProduct').css('display', 'none');
                }
            }
        }
    });
});