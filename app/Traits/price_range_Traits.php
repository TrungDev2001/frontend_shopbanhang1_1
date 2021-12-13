<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait price_range_Traits
{
    public function Price_range_Traits($price_range_min, $price_range_max, $products)
    {
        try {
            $products = $products->whereBetween('price', [$price_range_min, $price_range_max]);
            $product_category_html = view('shop.category.components.data', compact('products'))->render();
            return Response()->json([
                'status' => 200,
                'product_category_html' => $product_category_html,
            ]);
        } catch (\Exception $exception) {
            Log::error('Message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
            return Response()->json([
                'status' => 500,
                'message' => 'fail'
            ], 500);
        }
    }
}
