<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait filter_product_Traits
{
    public function Filter_product_Traits($key_filter, $products)
    {
        try {
            if ($key_filter == 1) {
                // $products = $this->product->where('category_id', $id)->where('active', 0)->orderBy('price', 'asc')->paginate(3);
                $products = $products->sortBy('price');
                $product_category_html = view('shop.category.components.data', compact('products'))->render();
                return Response()->json([
                    'status' => 200,
                    'product_category_html' => $product_category_html,
                ]);
            } elseif ($key_filter == 2) {
                // $products = $this->product->where('category_id', $id)->where('active', 0)->orderBy('price', 'desc')->paginate(3);
                $products = $products->sortByDesc('price');
                $product_category_html = view('shop.category.components.data', compact('products'))->render();
                return Response()->json([
                    'status' => 200,
                    'product_category_html' => $product_category_html,
                ]);
            } elseif ($key_filter == 3) {
                // $products = $this->product->where('category_id', $id)->where('active', 0)->orderBy('name', 'asc')->paginate(3);
                $products = $products->sortBy('name');
                $product_category_html = view('shop.category.components.data', compact('products'))->render();
                return Response()->json([
                    'status' => 200,
                    'product_category_html' => $product_category_html,
                ]);
            } elseif ($key_filter == 4) {
                // $products = $this->product->where('category_id', $id)->where('active', 0)->orderBy('name', 'desc')->paginate(3);
                $products = $products->sortByDesc('name');
                $product_category_html = view('shop.category.components.data', compact('products'))->render();
                return Response()->json([
                    'status' => 200,
                    'product_category_html' => $product_category_html,
                ]);
            }
        } catch (\Exception $exception) {
            Log::error('Message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
            return Response()->json([
                'status' => 500,
                'message' => 'fail'
            ], 500);
        }
    }
}
