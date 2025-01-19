@extends('ControlPanel.layouts.app_pages')

@section('content')
<style>
.input-group {
    display: flex;
    justify-content: center;
    align-items: center;
}

.input-group button {
    width: 30px;
    height: 30px;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 0;
}

.input-group input {
    width: 40px;
    height: 30px;
    text-align: center;
    font-size: 14px;
    margin: 0;
}

.input-group button i {
    font-size: 16px;
}

/* التعديل على الأزرار بحيث تكون الزر الأول والزر الأخير بهما حواف دائرية */
.input-group .btn-minus {
    border-top-left-radius: 5px;
    border-bottom-left-radius: 5px;
}

.input-group .btn-plus {
    border-top-right-radius: 5px;
    border-bottom-right-radius: 5px;
}



</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Cart Items</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('control_panel_dashboard.shoppingcarts.index') }}">Shopping Carts</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Cart Items</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Products in Cart #{{ $cart->id }}</h3>
                        </div>
                        <div class="card-body">
                            <!-- الجدول لعرض المنتجات داخل السلة -->
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart->cartItems as $item)
                                        <tr>
                                            <td>{{ $item->product->name }}</td>
                                            <td>
                                                <!-- إضافة أزرار + و - لتعديل الكمية -->
                                                <div class="input-group quantity" style="width: 140px; height: 40px;">
    <button class="btn btn-sm btn-minus bg-light border rounded-start" id="btn-minus-{{ $item->id }}" data-item-id="{{ $item->id }}">
        <i class="fa fa-minus"></i>
    </button>
    
    <input type="text" class="form-control form-control-sm text-center border-0" value="{{ $item->quantity }}" id="quantity-{{ $item->id }}" readonly>
    
    <button class="btn btn-sm btn-plus bg-light border rounded-end" id="btn-plus-{{ $item->id }}" data-item-id="{{ $item->id }}">
        <i class="fa fa-plus"></i>
    </button>
</div>





                                            </td>
                                            <td>${{ $item->unit_price }}</td>
                                            <td>${{ $item->total_price }}</td>
                                            <td>
                                                <!-- زر الحذف -->
                                                <button class="btn btn-sm btn-danger" id="btn-remove-{{ $item->id }}" data-item-id="{{ $item->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
     // عند الضغط على زر الزيادة
    $('.btn-plus').click(function() {
        var itemId = $(this).data('item-id');
        var currentQuantity = parseInt($('#quantity-' + itemId).val());

        // زيادة الكمية
        var newQuantity = currentQuantity + 1;

        // تحديث الواجهة
        $('#quantity-' + itemId).val(newQuantity);

        // إرسال طلب AJAX لتحديث الكمية في قاعدة البيانات
        $.ajax({
            url: "{{ route('control_panel_dashboard.update-quantity') }}",  // يجب أن يكون لديك مسار في الـ Routes لهذه الدالة
            method: 'POST',
            data: {
                item_id: itemId,
                quantity: newQuantity,
                _token: '{{ csrf_token() }}'  // إضافة token إذا كنت تستخدم Laravel
            },
            success: function(response) {
                console.log('Quantity updated successfully!');
            },
            error: function(xhr, status, error) {
                console.log('Error updating quantity:', error);
            }
        });
    });

    // عند الضغط على زر النقصان
    $('.btn-minus').click(function() {
        var itemId = $(this).data('item-id');
        var currentQuantity = parseInt($('#quantity-' + itemId).val());

        // التأكد من أن الكمية لا تصبح أقل من 1
        if (currentQuantity > 1) {
            var newQuantity = currentQuantity - 1;

            // تحديث الواجهة
            $('#quantity-' + itemId).val(newQuantity);

            // إرسال طلب AJAX لتحديث الكمية في قاعدة البيانات
            $.ajax({
                url: "{{ route('control_panel_dashboard.update-quantity') }}",  // نفس المسار هنا
                method: 'POST',
                data: {
                    item_id: itemId,
                    quantity: newQuantity,
                    _token: '{{ csrf_token() }}'  // إضافة token إذا كنت تستخدم Laravel
                },
                success: function(response) {
                    console.log('Quantity updated successfully!');
                },
                error: function(xhr, status, error) {
                    console.log('Error updating quantity:', error);
                }
            });
        }
    });


    $('.btn-danger').click(function() {
        var itemId = $(this).data('item-id');  // الحصول على item_id من الزر

        // تأكيد الحذف من المستخدم
        if (confirm('هل أنت متأكد من أنك تريد حذف هذا العنصر؟')) {
            // إرسال طلب AJAX لحذف العنصر
            $.ajax({
                url: "{{ route('control_panel_dashboard.delete-item', ':id') }}".replace(':id', itemId),  // استخدم Route helper مع استبدال الـ id
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'  // تأكيد أن الطلب يحتوي على token
                },
                success: function(response) {
                    if (response.status === 'success') {
                        // إزالة العنصر من الصفحة بعد الحذف بنجاح
                        $('#btn-remove-' + itemId).closest('.item-row').remove();
                        alert('تم حذف العنصر بنجاح!');
                        location.reload();
                    } else {
                        alert('حدث خطأ أثناء الحذف: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('حدث خطأ أثناء الحذف!');
                    console.log(xhr.responseText);
                }
            });
        }
    });






});
</script>

 @endsection
