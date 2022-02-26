<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Oder;
use App\Models\OderDetail;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Video;
use App\Models\Visitor;
use App\User;
use Carbon\Carbon;
use Google\Service\CloudSearch\QueryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    private $slider;
    private $product;
    private $category;
    private $brand;
    private $ads;
    private $video;
    private $visitor;
    private $oder;
    private $oderDetail;
    public function __construct(Slider $slider, Product $product, Category $category, Brand $brand, Ads $ads, Video $video, Visitor $visitor, Oder $oder, OderDetail $oderDetail)
    {
        $this->slider = $slider;
        $this->product = $product;
        $this->category = $category;
        $this->brand = $brand;
        $this->ads = $ads;
        $this->video = $video;
        $this->visitor = $visitor;
        $this->oder = $oder;
        $this->oderDetail = $oderDetail;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $request->session()->flush();
        // Auth::logout();

        // $sliders = $this->slider->where('active', 0)->get();
        // $products = $this->product->where('active', 0)->latest()->take(6)->get();
        // $productHots = $this->product->where('active', 0)->latest('view_count', 'desc')->take(6)->get();
        // $categories = $this->category->where('active', 1)->where('parent_id', 0)->get();
        // $brands = $this->brand->where('active', 0)->latest()->get();
        // $ads = $this->ads->where('active', 0)->latest()->first();

        // Cache::flush();
        // dd('aaa');
        $sliders =  Cache::remember('slidersCache', 60, function () {
            return $this->slider->where('active', 0)->get();
        });
        $products =  Cache::remember('productsCache', 60, function () {
            // return $this->product->where('active', 0)->latest()->take(6)->get();
            return $this->product->where('active', 0)->latest()->paginate(6);
        });
        $productHots =  Cache::remember('productHotsCache', 60, function () {
            return $this->product->where('active', 0)->latest('view_count', 'desc')->take(6)->get();
        });
        $categories =  Cache::remember('categoriesCache', 60, function () {
            return $this->category->where('active', 1)->where('parent_id', 0)->get();
        });
        $brands =  Cache::remember('brandsCache', 60, function () {
            return $this->brand->where('active', 0)->latest()->get();
        });
        $ads =  Cache::remember('adsCache', 60, function () {
            return $this->ads->where('active', 0)->latest()->first();
        });


        $visitor = $this->visitor->where('ip_address', $request->ip())->first();
        $now = Carbon::now('Asia/Ho_Chi_Minh');

        //lưu thời gian khách vừa truy cập
        if ($visitor == null) {
            $this->visitor->create([
                'ip_address' => $request->ip(),
                'date_just_visiter' => $now,
            ]);
        } else {
            if ($now->diffInMinutes($visitor->date_just_visiter) >= 3) {
                $visitor->update([
                    'date_just_visiter' => $now,
                ]);
            }
        }

        if ($request->ajax()) {
            $price_range_min = 0;
            $price_range_max = 0;
            if (isset($_GET['price_range_min']) || isset($_GET['price_range_max'])) {
                $price_range_min = $_GET['price_range_min'];
                $price_range_max = $_GET['price_range_max'];
                $products = $this->product->where('active', 0)->whereBetween('price', [$price_range_min, $price_range_max])->latest()->paginate(6);
                $product_category_html = view('shop.category.components.data', compact('products'))->render();
                return Response()->json([
                    'status' => 200,
                    'product_category_html' => $product_category_html,
                    'price_range_min' => $price_range_min,
                    'price_range_max' => $price_range_max,
                ]);
            } else {
                $products = $this->product->where('active', 0)->latest()->paginate(6);
                $product_category_html = view('shop.category.components.data', compact('products'))->render();
                return Response()->json([
                    'status' => 200,
                    'product_category_html' => $product_category_html,
                ]);
            }
        }

        return view('home.home', compact('sliders', 'products', 'productHots', 'categories', 'brands', 'ads'));
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
    public function videoIndex()
    {
        $categories = $this->category->where('active', 1)->where('parent_id', 0)->get();
        $brands = $this->brand->where('active', 0)->latest()->get();
        $ads = $this->ads->where('active', 0)->latest()->first();
        $videos = $this->video->where('status', 0)->latest()->paginate(6);
        return view('menu.shop.video.video', compact('categories', 'brands', 'ads', 'videos'));
    }
    public function videoPlay(Request $request, $slug)
    {
        $video = $this->video->find($request->id);
        return Response()->json([
            'status' => 200,
            'video' => $video,
        ]);
    }
    public function search_product(Request $request)
    {
        $products = $this->product->where('name', 'LIKE', '%' . $request->data . '%')->orWhere('slug', 'LIKE', '%' . $request->data . '%')->orWhere('description', 'LIKE', '%' . $request->data . '%')->orWhere('content', 'LIKE', '%' . $request->data . '%')->where('active', 0)->latest()->paginate(6);
        return Response()->json([
            'status' => 200,
            'products' => $products,
        ]);
    }
    public function search_product_result(Request $request)
    {
        $categories = $this->category->where('active', 1)->where('parent_id', 0)->get();
        $brands = $this->brand->where('active', 0)->latest()->get();
        $ads = $this->ads->where('active', 0)->latest()->first();
        $product = $this->product->where('name', $request->input_search)->first();
        if ($product) {
            $url_DetailProduct = $request->url();

            // $nunber = $product->ProductImages->count();
            // $productImages = $product->ProductImages->take($nunber - $nunber % 3)->sortBy('position');
            $productImages = $product->ProductImages->sortBy('position');

            $productCategory = $this->category->where('id', $product->category_id)->first();
            $productBrand = $this->brand->where('id', $product->brand_id)->first();
            // dd(Carbon::now()->format('d-m-Y'));
            // dd(date('Y-m-d H:i:s'));

            $productRelates = $this->product->where('category_id', $product->category_id)->where('brand_id', $product->brand_id)->whereNotIn('id', [$product->id])->latest()->take(6)->get();
            //cập nhập view
            $product->update([
                'view_count' => $product->view_count + 1,
            ]);
            return view('DetailProduct.detailProduct', compact('categories', 'brands', 'ads', 'product', 'productImages', 'productBrand', 'url_DetailProduct', 'productRelates', 'productCategory'));
        } else {
            return redirect()->back();
        }
    }

    public function wishlist()
    {
        return view('home.components.wishlist');
    }

    //hiển thị lịch sử mua hàng của mỗi khách
    public function bought()
    {
        $oders = $this->oder->where('user_id', Auth()->id())->where('active', '<>', 6)->latest()->paginate(5);
        return view('home.components.bought.bought', compact('oders'));
    }
    public function show_bought($id)
    {
        $oder = $this->oder->find($id);
        $oderDetails = $this->oderDetail->where('oder_id', $oder->id)->get();
        $user = User::find($oder->user_id);
        return view('home.components.bought.show', compact('oder', 'oderDetails', 'user'));
    }
    public function delete_bought($id)
    {
        $this->oder->find($id)->update([
            'active' => 6,
        ]);
        return Response()->json([
            'status' => 200,
        ]);
    }
}
