function search_Product() {
    var data_search = $(this).val();
    var origin = window.location.origin;
    if (data_search != '') {
        $.ajax({
            type: "get",
            url: origin + "/home/search",
            data: { data: data_search },
            success: function (response) {
                if (response.status == 200) {
                    $('#results_search').html('');
                    $.each(response.products.data, function (key, item) {
                        $('#results_search').append('<li class="value_search">' + item.name + '</li>');
                        $('#results_search').fadeIn();
                    });
                }
            }
        });
    } else {
        // $('#results_search').html('');
        $('#results_search').fadeOut();
    }
}
function search_Product1() {
    var value_searched = $(this).text();
    $('#input_search').val(value_searched);
    // $('#results_search').html('');
    $('#results_search').fadeOut();
}
$('body').on('click', function (event) {
    if (!$(event.target).is('#input_search')) {
        // $("#results_search").html('');
        $('#results_search').fadeOut();
    }
});

$(document).on('keyup', '#input_search', search_Product);
$(document).on('click', '.value_search', search_Product1);