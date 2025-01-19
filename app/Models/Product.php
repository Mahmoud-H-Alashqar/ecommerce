<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category_id',
    ];

    // العلاقة مع التصنيف
    public function category()
    {
        return $this->belongsTo(Category::class); // كل منتج ينتمي إلى تصنيف واحد
    }

    // تحميل الصورة
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image);  // إرجاع رابط الصورة في المسار المناسب
    }
}
