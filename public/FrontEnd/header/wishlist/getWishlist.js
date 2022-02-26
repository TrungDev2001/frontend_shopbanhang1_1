function getItemWishlist() {
    if (typeof (Storage) !== "undefined") {
        var getItemWishlist = JSON.parse(localStorage.getItem("wishlist"));
        console.log(getItemWishlist);
        if (getItemWishlist && getItemWishlist != '') {
            getItemWishlist.reverse();
            $.each(getItemWishlist, function (index, item) {
                $('tbody').append(`
                    <tr>
                        <td><img style="width: 50px;object-fit: cover;" src="`+ item.product_feature_image_path + `" alt=""></td>
                        <td>`+ item.product_name + `</td>
                        <td>`+ item.product_price + `đ</td>
                        <td style="display: flex;justify-content: space-evenly; padding-top: 32px;"><a class="add-to-cart" data-url="`+ item.product_url_addToCard + `">Thêm vào giỏ</a><a href="` + item.product_url_DetailProduct + `">Chi tiết</a><a data-product_id="` + item.product_id + `" id="delete">Xóa</a></td>
                    </tr>
                `);
            });
            $('.clear_wishlist').html('<button class="btn btn-danger" id="btn_wishlist">Xóa hết</button>');
        } else {
            $('tbody').append(`
                <tr>
                    <td colspan="4" align="center">Chưa có sản phẩm yêu thích nào.</td>
                </tr>
            `);
        }
    } else {
        alert('Trình duyệt không hỗ trợ localStorgae');
    }
}
getItemWishlist();

$(document).on('click', '#btn_wishlist', function () {
    $('tbody, .clear_wishlist').fadeOut();
    $('.clear_wishlist').html('');
    $('tbody').html(`
                <tr>
                    <td colspan="4" align="center">Chưa có sản phẩm yêu thích nào.</td>
                </tr>
            `).fadeIn();
    localStorage.removeItem("wishlist");
});

$(document).on('click', '#delete', function (e) {
    e.preventDefault();
    var product_id = $(this).attr('data-product_id');
    var dataItemWishlist = JSON.parse(localStorage.getItem("wishlist"));
    var index = dataItemWishlist.findIndex(function (o) {
        return o.product_id === product_id;
    })
    if (index !== -1) dataItemWishlist.splice(index, 1);
    localStorage.setItem("wishlist", JSON.stringify(dataItemWishlist));
    $(this).parent().parent().remove();
    if (dataItemWishlist == '') {
        $('tbody').append(`
                <tr>
                    <td colspan="4" align="center">Chưa có sản phẩm yêu thích nào.</td>
                </tr>
        `);
        $('.clear_wishlist').html('');
    }
});
