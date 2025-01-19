

@extends('website.layouts.app')

@section('content')
<style>
    /* تخصيص بطاقة الدفع */
    #card-element {
        padding: 12px;
        border: 2px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
        background-color: #f9f9f9;
        width: 100%;
    }

    /* تخصيص حقل تاريخ انتهاء الصلاحية */
    #expiry-element {
        padding: 12px;
        border: 2px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
        background-color: #f9f9f9;
        width: 100%;
    }

    /* تخصيص حقل CVC */
    #cvc-element {
        padding: 12px;
        border: 2px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
        background-color: #f9f9f9;
        width: 100%;
    }

    /* تخصيص زر الدفع */
    #submit-button {
        width: 100%;
        padding: 15px;
        background-color: #28a745;
        border: none;
        color: white;
        font-size: 18px;
        border-radius: 5px;
        cursor: pointer;
    }

    #submit-button:hover {
        background-color: #218838;
    }
</style>

   <!-- Modal Search Start -->
   <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex align-items-center">
                        <div class="input-group w-75 mx-auto d-flex">
                            <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                            <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Search End -->


        <!-- Single Page Header start -->
        <div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Checkout</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item active text-white">Checkout</li>
            </ol>
        </div>
        <!-- Single Page Header End -->
        <!-- Checkout Page Start -->
        <div class="container-fluid py-5">
            <div class="container py-5">

            <div class="row g-5">
            <div class="col-md-12 col-lg-6 col-xl-7">
            

 <!-- بداية الدفع  -->

   
   <div class="checkout-container">
        <h1>إتمام الدفع</h1>
        
        <!-- عرض المجموع الكلي -->
        <p><strong>المجموع الكلي: </strong>{{ $totalPrice }} جنيه</p>

        <form id="payment-form">
            <div id="card-element" class="mb-4">
                <!-- سيتم تحميل بطاقة الدفع هنا -->
            </div>
            <div class="form-group text-center">
            <button id="submit-button" class="btn btn-primary btn-lg">إتمام الدفع</button>
            </div>
        </form>

        <script src="https://js.stripe.com/v3/"></script>
        <script>
     // إعداد Stripe
    const stripe = Stripe('{{ env('STRIPE_KEY') }}'); // المفتاح العلني
    const elements = stripe.elements();

    // إعداد بطاقة الدفع
    const card = elements.create('card');
    card.mount('#card-element');

    // إرسال طلب الدفع عند تقديم النموذج
    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        // استرجاع الـ client_secret الذي تم إرساله من الخادم
        const clientSecret = '{{ $clientSecret }}'; // تمرير client_secret من Blade

        // تأكيد الدفع باستخدام client_secret
        const {paymentIntent, error} = await stripe.confirmCardPayment(clientSecret, {
            payment_method: {
                card: card,
                billing_details: {
                    name: '{{ Auth::user()->name }}', // اسم العميل من بيانات المستخدم
                    email: '{{ Auth::user()->email }}', // البريد الإلكتروني للعميل
                    phone: '{{ Auth::user()->phone ?? "رقم الهاتف غير متوفر" }}', // رقم الهاتف للعميل إذا كان موجوداً
                    address: {
                        line1: '{{ Auth::user()->address ?? "عنوان غير متوفر" }}', // العنوان إذا كان موجوداً
                        city: '{{ Auth::user()->city ?? "المدينة غير متوفرة" }}', // المدينة
                        postal_code: '{{ Auth::user()->postal_code ?? "الرمز البريدي غير متوفر" }}' // الرمز البريدي
                    }
                }
            }
        });

        if (error) {
            console.log(error);
            alert('حدث خطأ أثناء الدفع');
        } else {
            // تحديد حالة الطلب بناءً على حالة الدفع
            let orderStatus = 'معلق'; // حالة الطلب الافتراضية

            // تغيير الحالة بناءً على حالة الـ paymentIntent
            if (paymentIntent.status === 'succeeded') {
                orderStatus = 'تم الدفع';
            } else if (paymentIntent.status === 'requires_payment_method') {
                orderStatus = 'انتظر الدفع';
            } else if (paymentIntent.status === 'requires_confirmation') {
                orderStatus = 'انتظر التأكيد';
            } else if (paymentIntent.status === 'canceled') {
                orderStatus = 'تم الإلغاء';
            }

            // إرسال بيانات الدفع إلى الخادم عبر AJAX
            const orderData = {
                paymentIntentId: paymentIntent.id,  // إرسال الـ paymentIntent ID
                totalAmount: '{{ $totalPrice }}',  // المجموع الكلي من Blade
                customerName: '{{ Auth::user()->name }}',  // اسم العميل
                status: orderStatus,  // حالة الطلب بناءً على الحالة من Stripe
                paymentMethod: 'بطاقة ائتمان',  // طريقة الدفع
                shippingAddress: '{{ Auth::user()->address ?? "عنوان غير متوفر" }}',  // عنوان العميل
                phone: '{{ Auth::user()->phone ?? "رقم الهاتف غير متوفر" }}',  // رقم الهاتف
                userId: '{{ Auth::id() }}',  // معرف العميل إذا كان مسجلاً
                cartItems: @json($cartItems)  // معلومات السلة
            };

            try {
                const response = await fetch("{{ route('control_panel_dashboard.orders') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',  // إضافة توكن CSRF لحماية الطلب
                    },
                    body: JSON.stringify(orderData)
                });

                const data = await response.json();
                if (response.ok) {
                    // إعادة توجيه المستخدم إلى صفحة النجاح
                    window.location.href =  "{{ route('control_panel_dashboard.success') }}"; //'/success'; // انتقل إلى صفحة النجاح
                } else {
                    alert('حدث خطأ في إرسال البيانات إلى الخادم');
                }
            } catch (err) {
                console.log(err);
                alert('حدث خطأ في إرسال البيانات');
            }
        }
    });












        </script>
    </div>
  <!-- نهاية الدفع  -->
  </div>


  <div class="col-md-12 col-lg-6 col-xl-5">
  <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Products</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                	 @foreach($cartItems as $item)
                                        <tr>
                                            <th scope="row">
                                                <div class="d-flex align-items-center mt-2">
                                                    <img  src="{{ asset('storage/' . $item->product->image) }}"  class="img-fluid rounded-circle" style="width: 90px; height: 90px;" alt="">
                                                </div>
                                            </th>
                                            <td class="py-5">{{ $item->product->name }}</td>
                                            <td class="py-5">${{ number_format($item->product->price, 2) }}</td>
                                            <td class="py-5">{{ $item->quantity }}</td>
                                            <td class="py-5">${{ number_format($item->product->price * $item->quantity, 2) }}</td>
                                        </tr>
                                               @endforeach
                                    
                                     
                                        <tr>
                                            <th scope="row">
                                            </th>
                                            <td class="py-5"></td>
                                            <td class="py-5"></td>
                                            <td class="py-5">
                                                <p class="mb-0 text-dark py-3">Subtotal</p>
                                            </td>
                                            <td class="py-5">
                                                <div class="py-3 border-bottom border-top">
                                                    <p class="mb-0 text-dark">${{ number_format($totalPrice, 2) }}</p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                            </th>
                                            <td class="py-5">
                                                <p class="mb-0 text-dark py-4">Shipping</p>
                                            </td>
                                            <td colspan="3" class="py-5">
                                                <div class="form-check text-start">
                                                    <input type="checkbox" class="form-check-input bg-primary border-0" id="Shipping-1" name="Shipping-1" value="Shipping">
                                                    <label class="form-check-label" for="Shipping-1">Free Shipping</label>
                                                </div>
                                                <div class="form-check text-start">
                                                    <input type="checkbox" class="form-check-input bg-primary border-0" id="Shipping-2" name="Shipping-1" value="Shipping">
                                                    <label class="form-check-label" for="Shipping-2">Flat rate: $15.00</label>
                                                </div>
                                                <div class="form-check text-start">
                                                    <input type="checkbox" class="form-check-input bg-primary border-0" id="Shipping-3" name="Shipping-1" value="Shipping">
                                                    <label class="form-check-label" for="Shipping-3">Local Pickup: $8.00</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">
                                            </th>
                                            <td class="py-5">
                                                <p class="mb-0 text-dark text-uppercase py-3">TOTAL</p>
                                            </td>
                                            <td class="py-5"></td>
                                            <td class="py-5"></td>
                                            <td class="py-5">
                                                <div class="py-3 border-bottom border-top">
                                                    <p class="mb-0 text-dark">$135.00</p>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>



  </div>

  </div>
  </div>

  </div>



  @endsection





