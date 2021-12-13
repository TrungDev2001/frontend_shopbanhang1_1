<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    public function Products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
    public function categoryChildren()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
