//Make sure that the dom is ready

// $(function () {
function getRatedStar() {
    var product_id = $('#product_id').val();
    var user_id = $('#user_id').val();
    var origin = window.location.origin;
    var url = origin + "/product/getRatedStar";
    console.log(url);
    $.ajax({
        type: "get",
        url: url,
        data: {
            product_id: product_id,
            user_id: user_id,
        },
        success: function (response) {
            if (response.status == 200) {
                var rating_star_avg = response.rating_star_avg;
                $("#rateYo").rateYo({
                    rating: rating_star_avg,
                    starWidth: "15px",
                    spacing: "4px",
                    readOnly: true,
                    multiColor: {
                        "startColor": "#FF0000", //RED
                        "endColor": "#fff200"  //GREEN
                    },
                    onChange: function (rating, rateYoInstance) {
                        $(this).next().text(rating);
                    },
                }).on("rateyo.set", function (e, data) {

                });
            }
        }
    });
}
getRatedStar();
// });


function getRatedStar1() {
    var product_id = $('#product_id').val();
    var user_id = $('#user_id').val();
    var origin = window.location.origin;
    var url = origin + "/product/getRatedStarUserAuth";
    console.log(url);
    $.ajax({
        type: "get",
        url: url,
        data: {
            product_id: product_id,
            user_id: user_id,
        },
        success: function (response) {
            if (response.status == 200) {
                var rating_star_user = response.rating_star_user;
                if (rating_star_user != 0) {
                    $('#titleRating').html('Bạn đã đánh giá ' + rating_star_user + ' sao cho sản phẩm này:');
                };
                $("#rateYo1").rateYo({
                    rating: rating_star_user,
                    starWidth: "15px",
                    spacing: "4px",
                    // readOnly: true,
                    multiColor: {
                        "startColor": "#FF0000", //RED
                        "endColor": "#fff200"  //GREEN
                    },
                    onChange: function (rating, rateYoInstance) {
                        $(this).next().text(rating);
                    },

                }).on("rateyo.set", function (e, data) {
                    var product_id = $('#product_id').val();
                    var user_id = $('#user_id').val();
                    var rating = data.rating;
                    var origin = window.location.origin;
                    var url = origin + "/product/rating-star";
                    $.ajax({
                        type: "post",
                        url: url,
                        data: {
                            product_id: product_id,
                            user_id: user_id,
                            rating: rating,
                        },
                        success: function (response) {
                            if (response.status == 400) {
                                $('#messageErrorStar').html(response.message);
                            } else if (response.status == 200) {
                                $('#rated_star').val(response.rated_star);
                                $('#titleRating').html('Bạn đã đánh giá ' + response.rated_star + ' sao cho sản phẩm này:');
                            }
                        }
                    });
                });
            }
        }
    });
}
getRatedStar1();



// $(function () {
//     $("#rateYo1").rateYo({
//         rating: 5,
//         starWidth: "15px",
//         spacing: "4px",
//         // readOnly: true,
//         multiColor: {
//             "startColor": "#FF0000", //RED
//             "endColor": "#fff200"  //GREEN
//         },
//         onChange: function (rating, rateYoInstance) {
//             $(this).next().text(rating);
//         },

//     }).on("rateyo.set", function (e, data) {
//         var product_id = $('#product_id').val();
//         var user_id = $('#user_id').val();
//         var rating = data.rating;
//         var origin = window.location.origin;
//         var url = origin + "/product/rating-star";
//         $.ajax({
//             type: "post",
//             url: url,
//             data: {
//                 product_id: product_id,
//                 user_id: user_id,
//                 rating: rating,
//             },
//             success: function (response) {
//                 if (response.status == 400) {
//                     $('#messageErrorStar').html(response.message);
//                 } else if (response.status == 200) {
//                     $('#rated_star').val(response.rated_star);
//                     getRatedStar();
//                 }
//             }
//         });
//     });
// });
