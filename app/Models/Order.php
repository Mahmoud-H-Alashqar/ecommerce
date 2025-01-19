<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    // إضافة الحقول القابلة للتخزين بشكل جماعي
    protected $fillable = [
        'user_id',            // معرّف العميل
        'status',             // حالة الطلب
        'total',              // المجموع الكلي
        'payment_method',     // طريقة الدفع
        'shipping_address',   // عنوان الشحن
        'phone',              // رقم الهاتف
        'payment_intent_id',  // المعرف الذي يتم استرجاعه من Stripe
    ];

        // العلاقة مع OrderItem (الطلب يحتوي على العديد من العناصر)
        public function orderItems()
        {
            return $this->hasMany(OrderItem::class, 'order_id');
        }
        public function user()
        {
            return $this->belongsTo(User::class, 'user_id');
        }
    
    

}
