<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Ads;
use App\Models\Product;
use App\Traits\filter_product_Traits;
use App\Traits\price_range_Traits;
use Illuminate\Support\Facades\Response;

class ShopController extends Controller
{
    use filter_product_Traits;
    use price_range_Traits;

    private $category;
    private $brand;
    private $ads;
    private $product;
    public function __construct(Category $category, Brand $brand, Ads $ads, Product $product)
    {
        $this->category = $category;
        $this->brand = $brand;
        $this->ads = $ads;
        $this->product = $product;
    }
    public function index(Request $request, $slug, $id)
    {
        $categories = $this->category->where('active', 1)->where('parent_id', 0)->get();
        $brands = $this->brand->where('active', 0)->latest()->get();
        $ads = $this->ads->where('active', 0)->latest()->first();
        $products = $this->product->where('category_id', $id)->where('active', 0)->latest()->paginate(6);
        $category = $this->category->find($id);
        if ($request->ajax()) {
            if ($request->filter_product) {
                return $this->Filter_product_Traits($request->filter_product, $this->product, $id, 'category_id');
            }
            if ($request->price_range_min || $request->price_range_max) {
                return $this->Price_range_Traits($request->price_range_min, $request->price_range_max, $this->product, $id, 'category_id');
            }
        }
        return view('shop.category.listProductCategory', compact('categories', 'brands', 'ads', 'products', 'category'));
    }
    public function brand($id, Request $request)
    {
        $categories = $this->category->where('active', 1)->where('parent_id', 0)->get();
        $brands = $this->brand->where('active', 0)->latest()->get();
        $ads = $this->ads->where('active', 0)->latest()->first();
        $products = $this->product->where('brand_id', $id)->where('active', 0)->latest()->paginate(6);
        $brand = $this->brand->find($id);
        if ($request->ajax()) {
            if ($request->filter_product) {
                return $this->Filter_product_Traits($request->filter_product, $this->product, $id, 'brand_id');
            }
            if ($request->price_range_min || $request->price_range_max) {
                return $this->Price_range_Traits($request->price_range_min, $request->price_range_max, $this->product, $id, 'brand_id');
            }
        }
        return view('shop.brand.listProductBrand', compact('categories', 'brands', 'ads', 'products', 'brand'));
    }
}
