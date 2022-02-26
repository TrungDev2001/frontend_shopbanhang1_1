<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CategoryPost;
use App\Models\Post;
use App\Models\PostTag;
use App\Models\Tag;
use App\User;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $categoryPost;
    private $post;
    private $tag;
    private $postTag;
    public function __construct(CategoryPost $categoryPost, Post $post, Tag $tag, PostTag $postTag)
    {
        $this->categoryPost = $categoryPost;
        $this->post = $post;
        $this->tag = $tag;
        $this->postTag = $postTag;
    }
    public function index()
    {
        $categoryPosts = $this->categoryPost->where('id', '<>', 11)->latest()->get();
        $posts = $this->post->latest()->where('status', 0)->where('categoryPost_id', '<>', 11)->paginate(5);
        return view('blog.index', compact('categoryPosts', 'posts'));
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
    //danh sách các biết theo danh mục
    public function show($id, $slug)
    {
        $posts = $this->post->latest()->where('categoryPost_id', $id)->paginate(5);
        $categoryPost = $this->categoryPost->find($id);
        $categoryPosts = $this->categoryPost->latest()->get();


        return view('blog.listPostOfCategory', compact('posts', 'categoryPost', 'categoryPosts'));
    }

    //chi tiết bài viết
    public function detail($id, $slug)
    {
        $post = $this->post->find($id);
        $categoryPosts = $this->categoryPost->latest()->get();
        $categoryPostRelateds = $this->post->where('categoryPost_id', $post->categoryPost_id)->whereNotIn('id', [$id])->latest()->take(4)->get();
        $PostUser = User::where('id', $post->user_id)->first();

        $post->update([
            'view_count' => $post->view_count + 1,
        ]);
        return view('blog/detailblog', compact('post', 'categoryPosts', 'categoryPostRelateds', 'PostUser'));
    }

    //danh sách các biết theo tag
    public function postTag($id)
    {
        $categoryTag = $this->tag->find($id);
        $postTags = $this->postTag->where('tag_id', $id)->get();
        foreach ($postTags as $postTag) {
            $postId[] = $postTag->post_id;
        }
        $posts = $this->post->whereIn('id', $postId)->latest()->paginate(5);
        $categoryPosts = $this->categoryPost->latest()->get();
        return view('blog.listPostOfTag', compact('posts', 'categoryTag', 'categoryPosts'));
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
