function add_productWatched() {
    var product_id = $('.productWatched').attr('data-product_id');
    var product_name = $('.productWatched').attr('data-product_name');
    var product_price = $('.productWatched').attr('data-product_price');
    var product_feature_image_path = $('.productWatched').attr('data-feature_image_path');
    var product_url_DetailProduct = $('.productWatched').attr('data-url_DetailProduct');
    var product_url_addToCard = $('.productWatched').attr('data-url_addToCard');

    if (localStorage.getItem("productWatched") == null) {
        localStorage.setItem('productWatched', '[]')
    }
    var data_productWatched_old = JSON.parse(localStorage.getItem("productWatched"));

    var data_productWatched_new = {
        'product_id': product_id,
        'product_name': product_name,
        'product_price': product_price,
        'product_feature_image_path': product_feature_image_path,
        'product_url_DetailProduct': product_url_DetailProduct,
        'product_url_addToCard': product_url_addToCard,
    };
    var filtered = $.grep(data_productWatched_old, function (item) {
        return item.product_id == product_id;
    });
    if (filtered == '' && product_id != undefined) {
        $('.productWatchedAll').append(`
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
        data_productWatched_old.push(data_productWatched_new);
        localStorage.setItem("productWatched", JSON.stringify(data_productWatched_old));
    }
}

function getItemProductWatched() {
    if (typeof (Storage) !== "undefined") {
        var getItemProductWatched = JSON.parse(localStorage.getItem("productWatched"));
        var html = '';
        if (getItemProductWatched) {
            getItemProductWatched.reverse();
            $.each(getItemProductWatched, function (index, item) {
                $('.productWatchedAll').css("height", "305px");
                $('.productWatchedAll').css("overflow", "auto");
                html += `
                <div class="row wishlist">
                        <div class="col-sm-2">
                            <div class="card">
                                <div class="card-body">
                                    <img style="width: 50px; object-fit: cover; height: 50px;" src="`+ item.product_feature_image_path + `" alt="">
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
            $('.productWatchedAll').html(html);
        }
    } else {
        alert('Trình duyệt không hỗ trợ localStorgae');
    }
}

getItemProductWatched();
add_productWatched();