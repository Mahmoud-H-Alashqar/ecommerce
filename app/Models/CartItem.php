<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItem extends Model
{
    use HasFactory;

    // اسم الجدول إذا كان مختلفًا
    protected $table = 'cart_items';

    // تحديد الأعمدة القابلة للتعبئة
    protected $fillable = [
        'shopping_cart_id',        // مفتاح خارجي لسلة التسوق
        'product_id',     // مفتاح خارجي للمنتج
        'quantity',       // الكمية
        'unit_price',     // سعر الوحدة
        'total_price',    // السعر الإجمالي
    ];

    // علاقة مع جدول ShoppingCart (سلة التسوق)
    public function shoppingCart()
    {
        return $this->belongsTo(ShoppingCart::class, 'cart_id');
    }

    // علاقة مع جدول Product (المنتجات)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // دالة لحساب السعر الإجمالي (يتم حسابه بناءً على الكمية وسعر الوحدة)
    public function calculateTotalPrice()
    {
        $this->total_price = $this->quantity * $this->unit_price;
        $this->save();
    }
        // ميثود لتحديث الكمية
        public function updateQuantity($quantity)
        {
            $this->quantity = $quantity;
            $this->calculateTotalPrice(); // تحديث السعر الإجمالي بعد التعديل
            $this->save();
        }
    
 
}
