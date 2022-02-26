<?php
	$base_url = config('base_url.url_backend.url');
?>
<label for="exampleFormControlTextarea1">Đánh giá của sản phẩm:</label>
<div id="dataComment">
    <div class="media">
        <div class="row">
            <div class="col-md-1">
                <img class="mr" src="{{ asset('eshopper/images/product-details/kisspng-user-profile-2018-in-sight-user-conference-expo-5b554c0968c377.0307553315323166814291.jpg') }}" alt="Generic placeholder image">
            </div>
            <div class="media-body col-md-11">
                <h5 class="mt">Media heading</h5>
                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                <a href="" style="display: block; margin-top: 5px;">38 phản hồi</a>

                <form id="FormCommentReply">
                    <input type="hidden" class="product_id" name="product_id" value="' . $id . '">
                    <input type="hidden" class="comment_id" name="comment_id" value="' . $comment->id . '">
                    <textarea class="form-control" name="ContentReply" placeholder="Viết phản hồi của bạn" style="margin-bottom: 5px; height: 3.6em; margin-top: 0px; border-radius: 20px;"></textarea>
                    <button type="button" class="btn btn-info buttonCommentReply">Gửi phản hồi</button>
                    <small class="text-success messageComment"></small>
                </form>

                <div class="media">
                    <div class="col-md-1">
                        <a class="pr" href="#">
                            <img src="{{ $base_url.asset('eshopper/images/product-details/kisspng-user-profile-2018-in-sight-user-conference-expo-5b554c0968c377.0307553315323166814291.jpg') }}" alt="Generic placeholder image">
                        </a>
                    </div>
                    <div class="media-body col-md-11" style="padding-left: 23px;">
                        <h5 class="mt-0">Media heading</h5>
                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                    </div>
                </div>

                <div class="media">
                    <div class="col-md-1">
                        <a class="pr" href="#">
                            <img src="{{ $base_url.asset('eshopper/images/product-details/kisspng-user-profile-2018-in-sight-user-conference-expo-5b554c0968c377.0307553315323166814291.jpg') }}" alt="Generic placeholder image">
                        </a>
                    </div>
                    <div class="media-body col-md-11" style="padding-left: 23px;">
                        <h5 class="mt-0">Media heading</h5>
                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                    </div>
                </div>

                <div class="media">
                    <div class="col-md-1">
                        <a class="pr" href="#">
                            <img src="{{ asset('eshopper/images/product-details/kisspng-user-profile-2018-in-sight-user-conference-expo-5b554c0968c377.0307553315323166814291.jpg') }}" alt="Generic placeholder image">
                        </a>
                    </div>
                    <div class="media-body col-md-11" style="padding-left: 23px;">
                        <h5 class="mt-0">Media heading</h5>
                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="media">
        <div class="row">
            <div class="col-md-1">
                <img class="mr" src="{{ $base_url.asset('eshopper/images/product-details/kisspng-user-profile-2018-in-sight-user-conference-expo-5b554c0968c377.0307553315323166814291.jpg') }}" alt="Generic placeholder image">
            </div>
            <div class="media-body col-md-11">
                <h5 class="mt">Media heading</h5>
                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                <a href="" style="display: block; margin-top: 5px;">38 phản hồi</a>

                <form id="FormCommentReply">
                    <input type="hidden" class="product_id" name="product_id" value="' . $id . '">
                    <input type="hidden" class="comment_id" name="comment_id" value="' . $comment->id . '">
                    <textarea class="form-control" name="ContentReply" placeholder="Viết phản hồi của bạn" style="margin-bottom: 5px; height: 3.6em; margin-top: 0px; border-radius: 20px;"></textarea>
                    <button type="button" class="btn btn-info buttonCommentReply">Gửi phản hồi</button>
                    <small class="text-success messageComment"></small>
                </form>

                <div class="media">
                    <div class="col-md-1">
                        <a class="pr" href="#">
                            <img src="{{ asset('eshopper/images/product-details/kisspng-user-profile-2018-in-sight-user-conference-expo-5b554c0968c377.0307553315323166814291.jpg') }}" alt="Generic placeholder image">
                        </a>
                    </div>
                    <div class="media-body col-md-11" style="padding-left: 23px;">
                        <h5 class="mt-0">Media heading</h5>
                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                    </div>
                </div>

                <div class="media">
                    <div class="col-md-1">
                        <a class="pr" href="#">
                            <img src="{{ asset('eshopper/images/product-details/kisspng-user-profile-2018-in-sight-user-conference-expo-5b554c0968c377.0307553315323166814291.jpg') }}" alt="Generic placeholder image">
                        </a>
                    </div>
                    <div class="media-body col-md-11" style="padding-left: 23px;">
                        <h5 class="mt-0">Media heading</h5>
                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                    </div>
                </div>

                <div class="media">
                    <div class="col-md-1">
                        <a class="pr" href="#">
                            <img src="{{ asset('eshopper/images/product-details/kisspng-user-profile-2018-in-sight-user-conference-expo-5b554c0968c377.0307553315323166814291.jpg') }}" alt="Generic placeholder image">
                        </a>
                    </div>
                    <div class="media-body col-md-11" style="padding-left: 23px;">
                        <h5 class="mt-0">Media heading</h5>
                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>