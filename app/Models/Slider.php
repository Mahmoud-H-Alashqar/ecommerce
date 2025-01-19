<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'title',
         'image',
        'category_id',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class); // كل منتج ينتمي إلى تصنيف واحد
    }

}
