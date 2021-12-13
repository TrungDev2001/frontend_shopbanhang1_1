function filter_product() {
    var url = window.location.href;
    var filter_product = $(this).val();
    if (filter_product != 0) {
        $.ajax({
            type: "get",
            url: url,
            data: {
                filter_product: filter_product,
            },
            beforeSend: function () {
                $('#data_product_category').html('');
                $('#img-loading-content').css('display', 'block');
            },
            success: function (response) {
                if (response.status == 200) {
                    $('#img-loading-content').css('display', 'none');
                    $('#data_product_category').html(response.product_category_html);
                    $('.paginate_html').html(response.paginate_html);
                }
            }
        });
    }

}
$(document).on('change', '.filter_product', filter_product);

function paginate_url_item() {
    var url = $(this).attr('data-url');
    var filter_product = $('.filter_product').val();
    $.ajax({
        type: "get",
        url: url,
        data: {
            filter_product: filter_product,
        },
        beforeSend: function () {
            $('#data_product_category').html('');
            $('#img-loading-content').css('display', 'block');
        },
        success: function (response) {
            if (response.status == 200) {
                $('#img-loading-content').css('display', 'none');
                $('#data_product_category').html(response.product_category_html);
                $('.paginate_html').html(response.paginate_html);
            }
        }
    });
}
$(document).on('click', '.paginate_url_item', paginate_url_item);