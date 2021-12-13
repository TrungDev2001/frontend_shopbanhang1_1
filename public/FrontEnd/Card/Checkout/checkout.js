function fecthAddress() {
    var thanhpho = $('.thanhpho').val();
    var quanhuyen = $('.quanhuyen').val();
    var type = $(this).attr('id');
    $.ajax({
        type: "get",
        url: "/Cart/product/fecthAddress",
        data: {
            thanhpho: thanhpho,
            quanhuyen: quanhuyen,
            type: type,
        },
        success: function (response) {
            if (type == 'thanhpho') {
                $('.quanhuyen').html(response.htmlAddress);
            } else {
                $('.xaphuong').html(response.htmlAddress);
            }
        }
    });
}

function petchPriceShip() {
    var thanhpho = $('.thanhpho').val();
    var quanhuyen = $('.quanhuyen').val();
    var xaphuong = $('.xaphuong').val();
    $.ajax({
        type: "get",
        url: "/Cart/product/fetchPriceShip",
        data: {
            thanhpho: thanhpho,
            quanhuyen: quanhuyen,
            xaphuong: xaphuong,
        },
        success: function (response) {
            $('#totalPrice').html(response.viewTotalPriceRender);
            if (response.priceShip) {
                $('.messagePriceShip').show();
                $('#priceShip, .priceShip').html(response.priceShip);
            } else {
                $('.messagePriceShip').hide();
            }
        }
    });
}

$(document).on('change', '.choose', fecthAddress);
$(document).on('change', '.xaphuong', petchPriceShip);