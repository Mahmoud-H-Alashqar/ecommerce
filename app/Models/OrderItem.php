<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';

    // حقول قابلة للتعديل (لتحديد أي الأعمدة يمكن تعديلها عبر الـ Mass Assignment)
    protected $fillable = [
        'order_id', 'product_id', 'product_name', 'price', 'quantity',
    ];

    // تعريف العلاقة مع جدول الطلبات (Order)
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // تعريف العلاقة مع جدول المنتجات (ProductCategory)
    public function Product()
    {
       // return $this->belongsTo(Product::class, 'product_id');
        return $this->belongsTo(Product::class, 'product_id');
    }

}
