<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Exists;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $comment;
    private $base_url;
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
        $this->base_url = 'http://localhost:8081/';
    }
    public function index(Request $request, $id)
    {
        $base_url = config('base_url.url_backend.url');
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $date_current = strtotime(date('Y-m-d H:i:s'));
        $comments = $this->comment->where('product_id', $id)->where('parent_id', 0)->latest()->paginate(3);
        $count_comment_childent_total = 0;
        $comments_html = '';
        foreach ($comments as $comment) {
            $count_comment_childent_total += count($comment->Comments_reply);
            $count_comment_childent = count($comment->Comments_reply);
            $date_create_comment = strtotime($comment->created_at);
            $totalSecondsDiff = abs($date_current - $date_create_comment);
            $totalHoursDiff   = $totalSecondsDiff / 60 / 60;
            if ($totalHoursDiff <= 1) {
                $totalDiff = round($totalSecondsDiff / 60) . ' phút trước';
            } elseif ($totalHoursDiff >= 24) {
                $totalDiff = round($totalSecondsDiff / 60 / 60 / 24) . ' ngày trước';
            } elseif ($totalHoursDiff >= 720) {
                $totalDiff = round($totalSecondsDiff / 60 / 60 / 24 / 30) . ' tháng trước';
            } elseif ($totalHoursDiff >= 8760) {
                $totalDiff = round($totalSecondsDiff / 60 / 60 / 24 / 365) . ' năm trước';
            } else {
                $totalDiff = round($totalHoursDiff) . ' giờ trước';
            }

            $comments_html .= '
                <div class="media" id="comments_' . $comment->id . '">
                    <div class="row">
                        <div class="col-md-1">
                            <img class="mr" src="http://localhost:8081/eshopper/images/product-details/kisspng-user-profile-2018-in-sight-user-conference-expo-5b554c0968c377.0307553315323166814291.jpg" alt="Generic placeholder image">
                        </div>
                        <div class="media-body col-md-11">
                            <h5 class="mt">' . $comment->user->name . '</h5>
                            ' . $comment->content . '
                            <p class="getCommentChildrent" data-id="' . $comment->id . '" style="display: block; margin-top: 5px; font-weight: 500; cursor: pointer;">' . $count_comment_childent . ' phản hồi<span style="font-weight: 300;"> ' . $totalDiff . '</span></p>

                            <div id="container-comment-childrent-' . $comment->id . '" style="display: none;">
                            <form class="FormCommentReply-' . $comment->id . '">
                                <input type="hidden" class="product_id" name="product_id" value="' . $id . '">
                                <input type="hidden" class="comment_id" name="comment_id" value="' . $comment->id . '">
                                <textarea class="form-control" name="ContentReply" placeholder="Viết phản hồi của bạn" style="margin-bottom: 5px; height: 3.6em; margin-top: 0px; border-radius: 20px;"></textarea>';
            if (Auth::check()) {
                $comments_html .= '<button type="button" data-id="' . $comment->id . '" class="btn btn-info buttonCommentReply">Gửi phản hồi</button>
            					    <small class="text-success messageComment-' . $comment->id . '"></small>
                            </form>';
            } else {
                $comments_html .= '<button type="button" class="btn btn-info LoginAndComment" data-toggle="modal" data-target="#LoginAndComment">Đăng nhập ngay để bình luận</button></form>';
            }


            foreach ($comment->Comments_reply->sortByDesc('created_at')->forPage(0, 3) as $object) {
                // dd($comment->Comments_reply->paginate(2));
                $date_create_comment_children = strtotime($object->created_at);
                $totalSecondsDiff_comment_children = abs($date_current - $date_create_comment_children);
                $totalHoursDiff_comment_children   = $totalSecondsDiff_comment_children / 60 / 60;
                if ($totalHoursDiff_comment_children <= 1) {
                    $totalDiff_comment_children = round($totalSecondsDiff_comment_children / 60) . ' phút trước';
                } elseif ($totalHoursDiff_comment_children >= 24) {
                    $totalDiff_comment_children = round($totalSecondsDiff_comment_children / 60 / 60 / 24) . ' ngày trước';
                } elseif ($totalHoursDiff_comment_children >= 720) {
                    $totalDiff_comment_children = round($totalSecondsDiff_comment_children / 60 / 60 / 24 / 30) . ' tháng trước';
                } elseif ($totalHoursDiff_comment_children >= 8760) {
                    $totalDiff_comment_children = round($totalSecondsDiff_comment_children / 60 / 60 / 24 / 365) . ' năm trước';
                } else {
                    $totalDiff_comment_children = round($totalHoursDiff_comment_children) . ' giờ trước';
                }
                $comments_html .= '
                        <div class="media">
                            <div class="col-md-1">
                                <a class="pr" href="#">
                                    <img src="http://localhost:8081/eshopper/images/product-details/kisspng-user-profile-2018-in-sight-user-conference-expo-5b554c0968c377.0307553315323166814291.jpg" alt="Generic placeholder image">
                                </a>
                            </div>
                            <div class="media-body col-md-11" style="padding-left: 23px;">
                                <h5 class="mt-0">' . $object->user->name . '</h5>
                                ' . $object->content . '
                                <span style="font-weight: 300; display: block;"> ' . $totalDiff_comment_children . '</span>
                            </div>
                        </div>
                    ';
            }
            if (count($comment->Comments_reply) > 3) {
                $comments_html .= '
                    <img class="img-loading-content-childrent" src="' . $this->base_url . 'eshopper\images\loding-gif\loading5.gif" style="width: 200px;margin-left: auto; margin-right: auto; display: none;" alt="">
                    <p id="getPaginateCommentChildrent-' . $comment->id . '" class="getPaginateCommentChildrent" data-id="' . $comment->id . '" >Xem thêm ' . ($count_comment_childent - 3) . ' phản hồi khác</p>
                    </div>
                ';
            }

            $comments_html .= '
                        </div>
                    </div>
                </div>
            ';
        }
        $comments_html_paginate = '';
        if ($comments->lastPage() > 1) {
            $comments_html_paginate .= '<p id="getPaginateComment" data-lastPage="' . $comments->lastPage() . '" style="cursor: pointer;">Xem thêm các bình luận khác</p>';
        }
        $count_comments_total = count($comments) + $count_comment_childent_total;
        if ($comments_html != '') {
            return Response()->json([
                'status' => 200,
                'comments_html' => $comments_html,
                'count_comments_cha' => $count_comments_total,
                'count_comment_childent' => $count_comment_childent,
                'comments_html_paginate' => $comments_html_paginate,
                'page' => $request->page,
                // 'paginateCommentChildrent' => $comment->Comments_reply->paginate(2)->lastItem(),
            ]);
        }
    }

    public function get_comment_childent(Request $request, $id)
    {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $date_current = strtotime(date('Y-m-d H:i:s'));
        $comment = $this->comment->find($id);
        $count_comment_childent_total = 0;
        $comments_html = '';
        $count_comment_childent_total += count($comment->Comments_reply);
        $count_comment_childent = count($comment->Comments_reply);
        $date_create_comment = strtotime($comment->created_at);
        $totalSecondsDiff = abs($date_current - $date_create_comment);
        $totalHoursDiff   = $totalSecondsDiff / 60 / 60;
        if ($totalHoursDiff <= 1) {
            $totalDiff = round($totalSecondsDiff / 60) . ' phút trước';
        } elseif ($totalHoursDiff >= 24) {
            $totalDiff = round($totalSecondsDiff / 60 / 60 / 24) . ' ngày trước';
        } elseif ($totalHoursDiff >= 720) {
            $totalDiff = round($totalSecondsDiff / 60 / 60 / 24 / 30) . ' tháng trước';
        } elseif ($totalHoursDiff >= 8760) {
            $totalDiff = round($totalSecondsDiff / 60 / 60 / 24 / 365) . ' năm trước';
        } else {
            $totalDiff = round($totalHoursDiff) . ' giờ trước';
        }
        $comments_html .= '
                <div class="media">
                    <div class="row">
                        <div class="col-md-1">
                            <img class="mr" src="http://localhost:8081/eshopper/images/product-details/kisspng-user-profile-2018-in-sight-user-conference-expo-5b554c0968c377.0307553315323166814291.jpg" alt="Generic placeholder image">
                        </div>
                        <div class="media-body col-md-11">
                            <h5 class="mt">' . $comment->user->name . '</h5>
                            ' . $comment->content . '
                            <p style="display: block; margin-top: 5px; font-weight: 500; cursor: pointer;">' . $count_comment_childent . ' phản hồi<span style="font-weight: 300;"> ' . $totalDiff . '</span></p>

                            <form class="FormCommentReply-' . $comment->id . '">
                                <input type="hidden" class="product_id" name="product_id" value="' . $id . '">
                                <input type="hidden" class="comment_id" name="comment_id" value="' . $comment->id . '">
                                <textarea class="form-control" name="ContentReply" placeholder="Viết phản hồi của bạn" style="margin-bottom: 5px; height: 3.6em; margin-top: 0px; border-radius: 20px;"></textarea>';
        if (Auth::check()) {
            $comments_html .= '<button type="button" data-id="' . $comment->id . '" class="btn btn-info buttonCommentReply">Gửi phản hồi</button>
            					    <small class="text-success messageComment-' . $comment->id . '"></small>
                            </form>';
        } else {
            $comments_html .= '<button type="button" class="btn btn-info LoginAndComment" data-toggle="modal" data-target="#LoginAndComment">Đăng nhập ngay để bình luận</button></form>';
        }

        $perpage = 3;
        if ($request->page) {
            $perpage = $perpage * $request->page;
        }
        foreach ($comment->Comments_reply->sortByDesc('created_at')->forPage(0, $perpage) as $object) {

            // dd($comment->Comments_reply->paginate(2));
            $date_create_comment_children = strtotime($object->created_at);
            $totalSecondsDiff_comment_children = abs($date_current - $date_create_comment_children);
            $totalHoursDiff_comment_children   = $totalSecondsDiff_comment_children / 60 / 60;
            if ($totalHoursDiff_comment_children <= 1) {
                $totalDiff_comment_children = round($totalSecondsDiff_comment_children / 60) . ' phút trước';
            } elseif ($totalHoursDiff_comment_children >= 24) {
                $totalDiff_comment_children = round($totalSecondsDiff_comment_children / 60 / 60 / 24) . ' ngày trước';
            } elseif ($totalHoursDiff_comment_children >= 720) {
                $totalDiff_comment_children = round($totalSecondsDiff_comment_children / 60 / 60 / 24 / 30) . ' tháng trước';
            } elseif ($totalHoursDiff_comment_children >= 8760) {
                $totalDiff_comment_children = round($totalSecondsDiff_comment_children / 60 / 60 / 24 / 365) . ' năm trước';
            } else {
                $totalDiff_comment_children = round($totalHoursDiff_comment_children) . ' giờ trước';
            }
            $comments_html .= '
                        <div class="media">
                            <div class="col-md-1">
                                <a class="pr" href="#">
                                    <img src="http://localhost:8081/eshopper/images/product-details/kisspng-user-profile-2018-in-sight-user-conference-expo-5b554c0968c377.0307553315323166814291.jpg" alt="Generic placeholder image">
                                </a>
                            </div>
                            <div class="media-body col-md-11" style="padding-left: 23px;">
                                <h5 class="mt-0">' . $object->user->name . '</h5>
                                ' . $object->content . '
                                <span style="font-weight: 300; display: block;"> ' . $totalDiff_comment_children . '</span>
                            </div>
                        </div>
                    ';
        }
        if ($perpage < count($comment->Comments_reply) && count($comment->Comments_reply) != 0) {
            $comments_html .= '<img class="img-loading-content-childrent" src="' . $this->base_url . 'eshopper\images\loding-gif\loading5.gif" style="width: 200px;margin-left: auto; margin-right: auto; display: none;" alt="">
                                <p id="getPaginateCommentChildrent-' . $comment->id . '" class="getPaginateCommentChildrent" data-id="' . $comment->id . '" >Xem thêm ' . (count($comment->Comments_reply) - $perpage) . ' phản hồi khác</p>';
        }
        $comments_html .= '
                        </div>
                    </div>
                </div>
            ';
        // if ($comments->lastPage() > 1) {
        //     $comments_html_paginate = '<p id="getPaginateComment" data-lastPage="' . $comments->lastPage() . '" style="cursor: pointer;">Xem thêm các bình luận khác</p>';
        // }
        // $count_comments_total = count($comments) + $count_comment_childent_total;
        if ($comments_html != '') {
            return Response()->json([
                'status' => 200,
                'comments_html' => $comments_html,
                // 'count_comments_cha' => $count_comments_total,
                'count_comment_childent' => $count_comment_childent,
                // 'comments_html_paginate' => $comments_html_paginate,
                'page' => $request->page,
                'perpage' => $perpage,
                'lastpage' => count($comment->Comments_reply),
                // 'paginateCommentChildrent' => $comment->Comments_reply->paginate(2)->lastItem(),
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
