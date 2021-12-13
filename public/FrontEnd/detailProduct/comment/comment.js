var origin = window.location.origin;
function addComment() {
    var data = new FormData($('#FormDataComment')[0]);
    var url = origin + '/product/addComment';
    console.log(origin);
    $.ajax({
        type: "post",
        url: url,
        data: data,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.status == 200) {
                $('.messageComment').html('Gửi bình luận thành công');
                $('.contentComment11').val('');
                $('.messageComment').fadeOut(5000);

                getComment();
            }
        }
    });
}
function addCommentReply() {
    var comment_id = $(this).attr('data-id');
    var data = new FormData($('.FormCommentReply-' + comment_id)[0]);
    var url = origin + '/product/addCommentReply';
    $.ajax({
        type: "post",
        url: url,
        data: data,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.status == 200) {
                $('.messageComment-' + comment_id).html('Gửi phản hồi thành công');
                $('.messageComment-' + comment_id).fadeOut(5000);
                getComment();
            }
        }
    });
}
function btnLoginComment() {
    var data = new FormData($('#formDataLoginComment')[0]);
    var url = origin + '/product/LoginAndComment';
    $.ajax({
        type: "post",
        url: url,
        data: data,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.status == 200) {
                window.location.reload();
                $('#LoginAndComment').modal('hide');
            } else if (response.status == 500) {
                if (response.message) {
                    $('.errorTk').html(response.message);
                } else {
                    $('.errorTk').html('');
                }
            }
            else {
                if (response.errors.taikhoan) {
                    $('.errorTk').html(response.errors.taikhoan);
                } else {
                    $('.errorTk').html('');
                }
                if (response.errors.matkhau) {
                    $('.errorMk').html(response.errors.matkhau);
                } else {
                    $('.errorMk').html('');
                }
            }
        }
    });

}

$(document).on('click', '.buttonComment', addComment);
$(document).on('click', '.buttonCommentReply', addCommentReply);

$(document).on('click', '.btnLoginComment', btnLoginComment);