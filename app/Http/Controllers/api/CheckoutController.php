<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CustomException;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class CheckoutController extends Controller
{
    public function clearCart()
    {
        try {
            $this->clearCartId(); // استدعاء دالة حذف الـcart
            return $this->validMessage(['message' => 'Cart cleared successfully'], 'Cart cleared successfully', HttpResponse::HTTP_OK);
        } catch (\Exception $e) {
            throw new CustomException(
                'Failed to clear cart',
                HttpResponse::HTTP_INTERNAL_SERVER_ERROR,
                'ERR123',
                ['field_name' => 'Invalid value']
            );
        }
    }

    private function clearCartId()
    {
        Cookie::queue(Cookie::forget('cart_cookie_id')); // Clear the cart ID cookie

    }

    public function storeOrder(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone' => 'required|max:10',
            'address' => 'required',
        ]);

        $cart = app('cart'); // استدعاء الـcart

        // حساب المبلغ الإجمالي للطلب
        $total_amount = $cart->sum(function ($item) {
            return $item->quantity * $item->item->price;
        });

        // إضافة البيانات الإضافية للـrequest
        $request->merge([
            'user_id' => auth()->id(),
            'total_amount' => $total_amount,
        ]);

        DB::beginTransaction(); // بدء العمليات المؤقتة

        try {
            // إنشاء سجل جديد في جدول الطلبات
            $order = Order::create($request->all());

            // إضافة عناصر الطلب إلى جدول order_items
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'item_id' => $item->item_id,
                    'price' => $item->item->price,
                    'quantity' => $item->quantity,
                ]);
            }

           $this->clearCart(); // حذف الـcart
            DB::commit(); // اعتماد العمليات

            return response()->json(['message' => 'Order Created Successfully', 'order_id' => $order->id]);
        } catch (\Exception $e) {
            DB::rollBack(); // إلغاء العمليات في حالة حدوث خطأ
            return CustomException::errorMessage(
                'Custom error message',
                Response::HTTP_INTERNAL_SERVER_ERROR,
                'ERR123',
                ['field_name' => 'Invalid value']
            );
        }
    }
}
