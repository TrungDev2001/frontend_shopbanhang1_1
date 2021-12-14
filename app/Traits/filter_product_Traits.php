<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait filter_product_Traits
{
    public function Filter_product_Traits($key_filter, $model, $id, $where)
    {
        try {
            if ($key_filter == 1) {
                $products = $model->where($where, $id)->where('active', 0)->orderBy('price', 'asc')->paginate(6);
            } elseif ($key_filter == 2) {
                $products = $model->where($where, $id)->where('active', 0)->orderBy('price', 'desc')->paginate(6);
            } elseif ($key_filter == 3) {
                $products = $model->where($where, $id)->where('active', 0)->orderBy('name', 'asc')->paginate(6);
            } elseif ($key_filter == 4) {
                $products = $model->where($where, $id)->where('active', 0)->orderBy('name', 'desc')->paginate(6);
            }
            $product_category_html = view('shop.category.components.data', compact('products'))->render();
            $paginate_html = view('components.paginate', compact('products'))->render();
            return Response()->json([
                'status' => 200,
                'product_category_html' => $product_category_html,
                'paginate_html' => $paginate_html,
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
