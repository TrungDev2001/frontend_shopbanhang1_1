<?php

namespace App\Traits;

use DB;
use Illuminate\Support\Facades\Log;

trait price_range_Traits
{
    public function Price_range_Traits($price_range_min, $price_range_max, $model, $id, $where)
    {
        try {
            // DB::enableQueryLog();
            $products = $this->product->where($where, $id)->where('active', 0)->whereBetween('price', [$price_range_min, $price_range_max])->latest()->paginate(6);
            // dd(DB::getQueryLog());
            $product_category_html = view('shop.category.components.data', compact('products'))->render();
            $paginate_html = view('components.paginate', compact('products'))->render();
            return Response()->json([
                'status' => 200,
                'product_category_html' => $product_category_html,
                'paginate_html' => $paginate_html,
                'price_min' => $price_range_min,
                'price_max' => $price_range_max,
            ]);
        } catch (\Exception $exception) {
            $message = Log::error('Message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
            return Response()->json([
                'status' => 500,
                'message' => $message,
            ], 500);
        }
    }
}
