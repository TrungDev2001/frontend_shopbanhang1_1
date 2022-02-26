function getItemWishlist() {
    if (typeof (Storage) !== "undefined") {
        var getItemWishlist = JSON.parse(localStorage.getItem("wishlist"));
        if (getItemWishlist) {
            getItemWishlist.reverse();
            $('.wishlistAll').css("height", "305px");
            $('.wishlistAll').css("overflow", "auto");
            var htmlWishlist = '';
            $.each(getItemWishlist, function (index, item) {
                htmlWishlist += `
                <div class="row wishlist">
                        <div class="col-sm-2">
                            <div class="card">
                                <div class="card-body">
                                    <img style="width: 50px;object-fit: cover;" src="`+ item.product_feature_image_path + `" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-10">
                            <div class="card">
                                <div class="card-body">
                                    <b class="card-title" style="font-size: 11px">`+ item.product_name + `</b>
                                    <p class="card-text">`+ item.product_price + `đ</p>
                                    <p class="card-text add_to_cart"><a data-url="`+ item.product_url_addToCard + `" class="add-to-cart" style="color: #61c2df; border: none; background: none; margin: 0 0 0px;">Mua ngay</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
            $('.wishlistAll').html(htmlWishlist);
        }
    } else {
        alert('Trình duyệt không hỗ trợ localStorgae');
    }
    console.log('aaa');
}
getItemWishlist();

function add_wishlist(e) {
    e.preventDefault();
    var product_id = $(this).attr('data-product_id');
    var product_name = $(this).attr('data-product_name');
    var product_price = $(this).attr('data-product_price');
    var product_feature_image_path = $(this).attr('data-feature_image_path');
    var product_url_DetailProduct = $(this).attr('data-url_DetailProduct');
    var product_url_addToCard = $(this).attr('data-url_addToCard');

    if (typeof (Storage) !== "undefined") {
        if (!localStorage.getItem("wishlist")) {
            localStorage.setItem("wishlist", "[]");
        }
        var data_wishlist_new = {
            'product_id': product_id,
            'product_name': product_name,
            'product_price': product_price,
            'product_feature_image_path': product_feature_image_path,
            'product_url_DetailProduct': product_url_DetailProduct,
            'product_url_addToCard': product_url_addToCard,
        };
        var data_wishlist_old = JSON.parse(localStorage.getItem("wishlist"));

        var filtered = $.grep(data_wishlist_old, function (item) {
            return item.product_id == product_id;
        });
        if (filtered.length == 0 && product_id != undefined) {
            $('.wishlistAll').append(`
                <div class="row wishlist">
                        <div class="col-sm-2">
                            <div class="card">
                                <div class="card-body">
                                    <img style="width: 50px;object-fit: cover;" src="`+ product_feature_image_path + `" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-10">
                            <div class="card">
                                <div class="card-body">
                                    <b class="card-title" style="font-size: 11px">`+ product_name + `</b>
                                    <p class="card-text">`+ product_price + `đ</p>
                                    <p class="card-text add_to_cart"><a data-url="`+ product_url_addToCard + `" class="add-to-cart" style="color: #61c2df; border: none; background: none; margin: 0 0 0px;">Mua ngay</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                `);
            data_wishlist_old.push(data_wishlist_new);
            localStorage.setItem("wishlist", JSON.stringify(data_wishlist_old));
        } else {
            Swal.fire({
                position: 'center-center',
                icon: 'warning',
                title: 'Sản phẩm đã tồn tại',
                showConfirmButton: false,
                timer: 1400
            })
        }

        // localStorage.removeItem("wishlist");
    } else {
        alert("Sorry, your browser does not support Web Storage...");
    }
}
$(document).on('click', '.btn-add-wishlist', add_wishlist);