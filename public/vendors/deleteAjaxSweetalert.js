$(document).on('click', '.delete-sweetalert', function (e) {
    e.preventDefault();
    var url = $(this).attr('data-url');
    var that = $(this);
    console.log(url);
    Swal.fire({
        title: 'Delete!',
        text: "Bạn có chắc muốn xóa.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ok'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "delete",
                url: url,
                success: function (response) {
                    if (response.status == 200) {
                        Swal.fire(
                            'Deleted!',
                            'Đã xóa thành công',
                            'success'
                        );
                        that.parent().parent().parent().remove();
                    };
                }
            });
        }
    })
});