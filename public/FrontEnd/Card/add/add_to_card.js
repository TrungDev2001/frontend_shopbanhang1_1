function add_to_cart() {
    var url = $(this).attr('data-url');
    console.log(url);
    $.ajax({
        type: "post",
        url: url,

        success: function (response) {
            if (response.status == 200) {
                // toastr.success(response.message);
                $('.cartt').html(response.numberCart);
                Swal.fire({
                    position: 'center-center',
                    icon: 'success',
                    title: 'Đã thêm vào giỏ hàng',
                    showConfirmButton: false,
                    timer: 1400
                })
            } else {
                Swal.fire({
                    position: 'center-center',
                    icon: 'warning',
                    title: 'Sản phẩm đã hết hàng',
                    showConfirmButton: false,
                    timer: 1400
                })
            }
        }
    });
}


$(document).on('click', '.add-to-cart', add_to_cart);