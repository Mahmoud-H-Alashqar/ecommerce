<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShoppingCart extends Model
{
    use HasFactory;

    // اسم الجدول
    protected $table = 'shopping_carts';

    // الأعمدة القابلة للتعبئة
    protected $fillable = [
        'user_id',
        'status',
    ];

    // تعريف الثوابت لحالات السلة
    const STATUS_OPEN = 0;      // السلة مفتوحة
    const STATUS_CLOSED = 1;    // السلة مغلقة
    const STATUS_PAID = 2;      // السلة مدفوعة
    const STATUS_CANCELLED = 3; // السلة ملغاة

    // علاقة مع نموذج المستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // علاقة مع العناصر في السلة (إذا كان لديك جدول cart_items)
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    // التحقق مما إذا كانت السلة مفتوحة
    public function isOpen()
    {
        return $this->status === self::STATUS_OPEN;
    }

    // التحقق مما إذا كانت السلة مغلقة
    public function isClosed()
    {
        return $this->status === self::STATUS_CLOSED;
    }

    // التحقق مما إذا كانت السلة مدفوعة
    public function isPaid()
    {
        return $this->status === self::STATUS_PAID;
    }

    // التحقق مما إذا كانت السلة ملغاة
    public function isCancelled()
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    // تحديث حالة السلة
    public function setStatus($status)
    {
        if (in_array($status, [self::STATUS_OPEN, self::STATUS_CLOSED, self::STATUS_PAID, self::STATUS_CANCELLED])) {
            $this->status = $status;
            $this->save();
        }
    }
        // ميثود لتحديث الكميات في جميع العناصر المرتبطة بالسلة
        public function updateCartItemQuantity($productId, $quantity)
        {
            // الحصول على العنصر في السلة بناءً على المنتج
            $cartItem = $this->cartItems()->where('product_id', $productId)->first();
    
            if ($cartItem) {
                // تحديث الكمية
                $cartItem->updateQuantity($quantity); // ميثود من CartItem لتحديث الكمية
            }
        }
    



}
