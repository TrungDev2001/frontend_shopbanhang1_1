<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Video;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $slider;
    private $product;
    private $category;
    private $brand;
    private $ads;
    private $video;
    public function __construct(Slider $slider, Product $product, Category $category, Brand $brand, Ads $ads, Video $video)
    {
        $this->slider = $slider;
        $this->product = $product;
        $this->category = $category;
        $this->brand = $brand;
        $this->ads = $ads;
        $this->video = $video;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = $this->slider->where('active', 0)->get();
        $products = $this->product->where('active', 0)->latest()->take(6)->get();
        $productHots = $this->product->where('active', 0)->latest('view_count', 'desc')->take(6)->get();
        $categories = $this->category->where('active', 1)->where('parent_id', 0)->get();
        $brands = $this->brand->where('active', 0)->latest()->get();
        $ads = $this->ads->where('active', 0)->latest()->first();
        $price_min = $products->min('price');
        $price_max = $products->max('price');
        return view('home.home', compact('sliders', 'products', 'productHots', 'categories', 'brands', 'ads', 'price_min', 'price_max'));
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
}
