<?php

// app/Models/Category.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description']; // الأعمدة التي يمكن ملؤها
    public function products()
    {
        return $this->hasMany(Product::class); // كل تصنيف يحتوي على العديد من المنتجات
    }

}
