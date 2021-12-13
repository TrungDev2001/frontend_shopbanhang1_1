function quickview() {
    var origin = window.location.origin;
    var product_id = $(this).attr('data-product_id');
    var product_slug = $(this).attr('data-slug');
    var url = origin + '/product/detail/' + product_id + '/' + product_slug;
    $.ajax({
        type: "get",
        url: url,
        success: function (response) {
            if (response.status == 200) {
                $('.modal-body').html(response.quickview_html);
            }
        }
    });
}

$(document).on('click', '.quickview-product', quickview);