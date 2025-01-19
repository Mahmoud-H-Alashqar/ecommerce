<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Laravel\Cashier\Cashier;

class PaymentController extends Controller
{
    public function processPayment(Request $request)
{
    // تأكد من أن المفتاح السري موجود في ملف .env
    Stripe::setApiKey(env('STRIPE_SECRET'));

    try {
        // إنشاء PaymentIntent للتحقق من الدفع
        $paymentIntent = PaymentIntent::create([
            'amount' => $request->amount,  // تأكد من تحويل المبلغ إلى سنتات (مثال: 13500 سنت)
            'currency' => 'usd',
            'payment_method' => $request->payment_method_id,
            'confirmation_method' => 'manual',
            'confirm' => true,
        ]);

        return response()->json(['clientSecret' => $paymentIntent->client_secret]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()]);
    }
}

}
