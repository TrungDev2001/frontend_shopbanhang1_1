function getComment() {
    var product_id = $('.product_id').val();
    var url = origin + '/product/GetComment/' + product_id;
    $.ajax({
        type: "get",
        url: url,
        success: function (response) {
            if (response.status == 200) {
                $('.img-loading-content').hide();
                $('#comments').html(response.comments_html);
                $('#comments_html_paginate').html(response.comments_html_paginate);
                $('.count_comment').html(response.count_comments_cha);
            } else {
                $('.img-loading-content').hide();
                $('.count_comment').html(0);
            }
        }
    });
}
getComment();

function getPaginateComment(page) {
    var product_id = $('.product_id').val();
    var lastPage = $('#getPaginateComment').attr('data-lastPage');
    var url = origin + '/product/GetComment/' + product_id + '?page=' + page;
    $.ajax({
        type: "get",
        url: url,
        beforeSend: function () {
            $('#img-loading-content').show();
        },
        success: function (response) {
            if (response.status == 200) {
                $('#comments').append(response.comments_html);
                $('#img-loading-content').hide();
                if (lastPage == page) {
                    console.log('trang cuoi');
                    $('#comments_html_paginate').hide();
                }
                // $('.count_comment').html(response.count_comments_cha);
            }
        }
    });
}
var page = 1;

$(document).on('click', '#getPaginateComment', function () {
    page++;
    getPaginateComment(page);
});



function getPaginateCommentChildrent(PaginateCommentChildrent, comment_id) {
    var product_id = $('.product_id').val();
    console.log(comment_id);
    // var lastPage = $('#getPaginateComment').attr('data-lastPage');
    var url = origin + '/product/get_comment_childent/' + comment_id;
    $.ajax({
        type: "get",
        url: url,
        data: {
            'page': PaginateCommentChildrent,
        },
        beforeSend: function () {
            $('.img-loading-content-childrent').show();
        },
        success: function (response) {
            if (response.status == 200) {
                console.log(response.comments_html);
                $('#comments_' + comment_id).html(response.comments_html);
                $('.img-loading-content-childrent').hide();
                // if (lastPage == page) {
                //     console.log('trang cuoi');
                //     $('#comments_html_paginate').hide();
                // }
                // $('.count_comment').html(response.count_comments_cha);
            }
            if (response.lastpage == PaginateCommentChildrent) {
                $('.getPaginateCommentChildrent').hide();
            }
        }
    });
}
var PaginateCommentChildrent = 1;
$(document).on('click', '.getPaginateCommentChildrent', function () {
    var comment_id = $(this).attr('data-id');
    PaginateCommentChildrent++;
    getPaginateCommentChildrent(PaginateCommentChildrent, comment_id);
});

$(document).on('click', '.getCommentChildrent', function () {
    var comment_id = $(this).attr('data-id');
    $('#container-comment-childrent-' + comment_id).show();
    console.log(comment_id);
});

