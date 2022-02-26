<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Ads;
use App\Models\Comment;
use App\Models\Oder;
use App\Models\OderDetail;
use App\Models\Product;
use App\Models\ProductTag;
use App\Models\rating_star;
use App\Models\Tag;
use App\Models\Visitor;
use App\Traits\filter_product_Traits;
use App\Traits\price_range_Traits;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ProductDetailController extends Controller
{
    use filter_product_Traits;
    use price_range_Traits;

    private $category;
    private $brand;
    private $ads;
    private $product;
    private $tag;
    private $productTag;
    private $oder;
    private $oderDetail;
    private $rating_star;
    private $comment;
    private $visitor;
    public function __construct(Category $category, Brand $brand, Ads $ads, Product $product, Tag $tag, ProductTag $productTag, Oder $oder, OderDetail $oderDetail, rating_star $rating_star, Comment $comment, Visitor $visitor)
    {
        $this->category = $category;
        $this->brand = $brand;
        $this->ads = $ads;
        $this->product = $product;
        $this->tag = $tag;
        $this->productTag = $productTag;
        $this->oder = $oder;
        $this->oderDetail = $oderDetail;
        $this->rating_star = $rating_star;
        $this->comment = $comment;
        $this->visitor = $visitor;
    }
    public function index($id, $slug, Request $request)
    {
        $categories = $this->category->where('active', 1)->where('parent_id', 0)->get();
        $brands = $this->brand->where('active', 0)->latest()->get();
        $ads = $this->ads->where('active', 0)->latest()->first();
        $product = $this->product->where('active', 0)->find($id);

        $url_DetailProduct = $request->url();


        $nunber = $product->ProductImages->count();
        // $productImages = $product->ProductImages->take($nunber - $nunber % 3)->sortBy('position');
        $productImages = $product->ProductImages->sortBy('position');


        $productCategory = $this->category->where('id', $product->category_id)->first();
        $productBrand = $this->brand->where('id', $product->brand_id)->first();
        // dd(Carbon::now()->format('d-m-Y'));
        // dd(date('Y-m-d H:i:s'));

        $productRelates = $this->product->where('category_id', $product->category_id)->where('brand_id', $product->brand_id)->whereNotIn('id', [$product->id])->latest()->take(6)->get();
        //cập nhập view
        $visitor = $this->visitor->where('ip_address', $request->ip())->first();
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        if ($now->diffInMinutes($visitor->date_just_visiter) >= 2) {
            $product->update([
                'view_count' => $product->view_count + 1,
            ]);
        }

        if ($request->ajax()) {
            $quickview_html = view('DetailProduct.quickview.index', compact('categories', 'brands', 'ads', 'product', 'productImages', 'productBrand', 'url_DetailProduct', 'productRelates', 'productCategory'))->render();
            if ($quickview_html) {
                return Response()->json([
                    'status' => 200,
                    'quickview_html' => $quickview_html,
                ]);
            }
        }

        $checkLogin = Auth::check();
        return view('DetailProduct.detailProduct', compact('categories', 'brands', 'ads', 'product', 'productImages', 'productBrand', 'url_DetailProduct', 'productRelates', 'productCategory', 'checkLogin'));
    }
    public function tagProducts(Request $request, $slug)
    {
        $categories = $this->category->where('active', 1)->where('parent_id', 0)->get();
        $brands = $this->brand->where('active', 0)->latest()->get();
        $ads = $this->ads->where('active', 0)->latest()->first();

        $tag_name = str_replace('-', ' ', $slug);
        $tags = $this->tag->where('name', 'LIKE', '%' . $tag_name . '%')->get();
        $products_tags = $this->productTag->whereIn('tag_id', $tags)->get();
        foreach ($products_tags as $product_tag) {
            $products_id[] = $product_tag->product_id;
        }
        //DB::enableQueryLog();
        $products = $this->product->whereIn('id', $products_id)->where('active', 0)->latest()->paginate(6);
        // dd(DB::getQueryLog());

        if ($request->ajax()) {
            if ($request->filter_product) {
                if ($request->filter_product == 1) {
                    $products = $this->product->whereIn('id', $products_id)->where('active', 0)->orderBy('price', 'asc')->paginate(6);
                } elseif ($request->filter_product == 2) {
                    $products = $this->product->whereIn('id', $products_id)->where('active', 0)->orderBy('price', 'desc')->paginate(6);
                } elseif ($request->filter_product == 3) {
                    $products = $this->product->whereIn('id', $products_id)->where('active', 0)->orderBy('name', 'asc')->paginate(6);
                } elseif ($request->filter_product == 4) {
                    $products = $this->product->whereIn('id', $products_id)->where('active', 0)->orderBy('name', 'desc')->paginate(6);
                }
                $product_category_html = view('shop.category.components.data', compact('products'))->render();
                $paginate_html = view('components.paginate', compact('products'))->render();
                return Response()->json([
                    'status' => 200,
                    'product_category_html' => $product_category_html,
                    'paginate_html' => $paginate_html,
                ]);
            } else {
                $price_range_min = $request->price_range_min;
                $price_range_max = $request->price_range_max;
                $products = $this->product->whereIn('id', $products_id)->where('active', 0)->whereBetween('price', [$price_range_min, $price_range_max])->latest()->paginate(6);
                $product_category_html = view('shop.category.components.data', compact('products'))->render();
                $paginate_html = view('components.paginate', compact('products'))->render();
                return Response()->json([
                    'status' => 200,
                    'product_category_html' => $product_category_html,
                    'paginate_html' => $paginate_html,
                    'price_min' => $price_range_min,
                    'price_max' => $price_range_max,
                ]);
            }
        }
        return view('DetailProduct.TagsProduct.index', compact('products', 'categories', 'brands', 'ads', 'tag_name'));
    }
    public function rating_star(Request $request)
    {
        if ($request->user_id) {
            $oders = $this->oder->whereIn('user_id', [$request->user_id])->get();

            if ($oders) {
                foreach ($oders as $oder) {
                    $oder_id[] = $oder->id;
                }
                $oderDetail = $this->oderDetail->where('product_id', $request->product_id)->whereIn('oder_id', $oder_id)->get();
                if (count($oderDetail) != 0) {
                    foreach ($oderDetail as $oderDetail_item) {
                        $oderDetail_id[] = $oderDetail_item->oder_id;
                    }

                    $oder = $this->oder->whereIn('id', $oderDetail_id)->get();
                    foreach ($oder as $oder_item) {
                        $oder_active[] = $oder_item->active;
                    }
                    $collection = collect($oder_active);
                    if ($collection->contains(3)) {
                        $rating_star = $this->rating_star->updateOrCreate([
                            'product_id' => $request->product_id,
                            'user_id' => $request->user_id,
                        ], [
                            'rating' => $request->rating,
                        ]);
                        if ($rating_star) {
                            return Response()->json([
                                'status' => 200,
                                'message' => 'Đánh giá sao thành công',
                                'rated_star' => $request->rating,
                            ]);
                        }
                    } else {
                        return Response()->json([
                            'status' => 400,
                            'message' => '(Bạn chưa mua sản phẩm này)',
                        ]);
                    }
                } else {
                    return Response()->json([
                        'status' => 400,
                        'message' => '(Bạn chưa mua sản phẩm này)',
                    ]);
                }
            } else {
                return Response()->json([
                    'status' => 400,
                    'message' => '(Bạn chưa mua sản phẩm này)',
                ]);
            }
        } else {
            return Response()->json([
                'status' => 400,
                'message' => '(Vui lòng đăng nhập để đánh giá sản phẩm)',
            ]);
        }
    }
    public function getRatedStar(Request $request)
    {
        $rating_star_avg = $this->rating_star->where('product_id', $request->product_id)->avg('rating');
        return Response()->json([
            'status' => 200,
            'rating_star_avg' => $rating_star_avg,
        ]);
    }
    public function getRatedStarUserAuth(Request $request)
    {
        $rating_star_user = $this->rating_star->where('product_id', $request->product_id)->where('user_id', $request->user_id)->first();
        $rating_star_user_rating = 0;
        if ($rating_star_user) {
            $rating_star_user_rating =  $rating_star_user->rating;
        }
        return Response()->json([
            'status' => 200,
            'rating_star_user' => $rating_star_user_rating,
        ]);
    }

    public function addComment(Request $request)
    {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $comment = $this->comment->create([
            'content' => $request->contentComment,
            'user_id' => Auth()->id(),
            'product_id' => $request->product_id,
        ]);
        if ($comment) {
            return Response()->json([
                'status' => 200,
                'comment' => $comment,
            ]);
        }
    }
    public function addCommentReply(Request $request)
    {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $comment = $this->comment->create([
            'content' => $request->ContentReply,
            'user_id' => Auth()->id(),
            'product_id' => $request->product_id,
            'parent_id' => $request->comment_id,
        ]);
        if ($comment) {
            return Response()->json([
                'status' => 200,
                'comment' => $comment,
            ]);
        }
    }
    public function LoginAndComment(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'taikhoan' => 'required|email|exists:App\user,email',
                'matkhau' => 'required',
            ],
            [
                'taikhoan.required' => 'Tài khoản không được để trống',
                'taikhoan.email' => 'Tài khoản phải là email',
                'taikhoan.exists' => 'Tài khoản không tồn tại',
                'matkhau.required' => 'Mật khẩu không được để trống',
            ]
        );
        if ($validate->fails()) {
            return Response()->json([
                'status' => 400,
                'errors' => $validate->errors(),
            ]);
        } else {
            $data = [
                'email' => $request->taikhoan,
                'password' => $request->matkhau,
            ];
            $checkLogin = Auth::attempt($data);
            if ($checkLogin) {
                return Response()->json([
                    'status' => 200,
                    'checkLogin' => $checkLogin,
                ]);
            }
        }
        return Response()->json([
            'status' => 500,
            'message' => 'Tài khoản hoặc mật khẩu không đúng',
        ]);
    }
}
