function compareProduct(e) {

    e.preventDefault();
    var product_id = $(this).attr('data-product_id');
    var product_name = $('.compareProduct_' + product_id).attr('data-product_name');
    var product_price = $('.compareProduct_' + product_id).attr('data-product_price');
    var product_feature_image_path = $('.compareProduct_' + product_id).attr('data-feature_image_path');
    var product_url_DetailProduct = $('.compareProduct_' + product_id).attr('data-url_DetailProduct');
    var product_url_addToCard = $('.compareProduct_' + product_id).attr('data-url_addToCard');

    if (localStorage.getItem("compareProduct") == null) {
        localStorage.setItem('compareProduct', '[]')
    }
    var data_compareProduct_old = JSON.parse(localStorage.getItem("compareProduct"));
    var data_compareProduct_new = {
        'product_id': product_id,
        'product_name': product_name,
        'product_price': product_price,
        'product_feature_image_path': product_feature_image_path,
        'product_url_DetailProduct': product_url_DetailProduct,
        'product_url_addToCard': product_url_addToCard,
    };
    var filtered = $.grep(data_compareProduct_old, function (item) {
        return item.product_id == product_id;
    });
    if (data_compareProduct_old.length <= 2) {
        if (filtered == '' && product_id != undefined) {
            $('#dataCompareProduct').append(`
                    <tr>
                        <td>1</td>
                        <td>`+ product_name + `</td>
                        <td><img src="`+ product_feature_image_path + `" alt="` + product_name + `" width="80px" height="80px"></td>
                        <td>`+ product_price + `</td>
                        <td> <a href="`+ product_url_addToCard + `"><button class="btn btn-info btn-sm">Mua ngay</button></a> </td>
                        <td> <a href="`+ product_url_DetailProduct + `"><button class="btn btn-warning btn-sm">Chi tiết</button></a> </td>
                        <td> <a data-product_id="`+ product_id + `"><button class="btn btn-danger btn-sm delete_compareProduct">Xóa</button></a> </td>
                    </tr>
                `);
            data_compareProduct_old.push(data_compareProduct_new);
            localStorage.setItem("compareProduct", JSON.stringify(data_compareProduct_old));
        }
    } else {
        alert('So sánh tối đa 3 sản phẩm thôi');
    }
    getItemCompareProduct();
}

function getItemCompareProduct() {
    if (typeof (Storage) !== "undefined") {
        var getItemcompareProduct = JSON.parse(localStorage.getItem("compareProduct"));
        var html = '';
        if (getItemcompareProduct.length > 0) {
            // getItemcompareProduct.reverse();
            $.each(getItemcompareProduct, function (index, item) {
                html += `
                    <tr>
                        <td>1</td>
                        <td>`+ item.product_name + `</td>
                        <td><img src="`+ item.product_feature_image_path + `" alt="` + item.product_name + `" width="80px" height="80px"></td>
                        <td>`+ item.product_price + `</td>
                        <td> <a href="`+ item.product_url_addToCard + `"><button class="btn btn-info btn-sm">Mua ngay</button></a> </td>
                        <td> <a href="`+ item.product_url_DetailProduct + `"><button class="btn btn-warning btn-sm">Chi tiết</button></a> </td>
                        <td><button data-product_id="`+ item.product_id + `" class="btn btn-danger btn-sm delete_compareProduct">Xóa</button></td>
                    </tr>
                `;
            });
            $('#dataCompareProduct').html(html);
        }
    } else {
        alert('Trình duyệt không hỗ trợ localStorgae');
    }
}
function delete_compareProduct() {
    var product_id = $(this).attr('data-product_id');
    var dataItemCompareProduct = JSON.parse(localStorage.getItem("compareProduct"));
    var index = dataItemCompareProduct.findIndex(function (o) {
        return o.product_id === product_id;
    })
    if (index !== -1) dataItemCompareProduct.splice(index, 1);
    localStorage.setItem("compareProduct", JSON.stringify(dataItemCompareProduct));
    $(this).parent().parent().remove();
    if (dataItemCompareProduct == '') {
        $('#dataCompareProduct').append(`
            <tr>
                <td colspan="4" align="center">Chưa có sản phẩm yêu thích nào.</td>
            </tr>
        `);
    }
}

$(document).on('click', '.compareProduct', compareProduct);
$(document).on('click', '.delete_compareProduct', delete_compareProduct);
