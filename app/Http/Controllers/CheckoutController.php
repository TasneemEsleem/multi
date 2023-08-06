<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException1;
use App\Exceptions\CustomException2;
use App\Exceptions\ExceptionHandlerTrait;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Exception;

class CheckoutController extends Controller
{
    use ExceptionHandlerTrait;
    
    public function create()
    {
        $cart = app('cart');
        $total_amount = $cart->sum(function ($item) {
            return $item->quantity * $item->item->price;
        });
        return response()->view('landingPage.checkout', [
            'cart' => $cart,
            'user' => Auth::check() ? Auth::user() : new User(),
            'total_amount' => $total_amount
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone' => 'required|max:10',
            'address' => 'required',
        ]);
        $cart = app('cart');
        $total_amount = $cart->sum(function ($item) {
            return $item->quantity * $item->item->price;
        });
        // Add Attribute in the request
        $request->merge([
            'user_id' => Auth::id(),
            'total_amount' => $total_amount,
        ]);
        DB::beginTransaction();
        try {
            $order = Order::create($request->all());
            foreach ($cart as $item) {
                $order->orderItems()->create([
                    'item_id' => $item->item_id,
                    'price' => $item->item->price,
                    'quantity' => $item->quantity,
                ]);
            }
            $cart = app('delete_cart');
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        return response()->json(['message' => 'Order Creating Successfully', 'order_id' => $order->id]);
    }

// Api

public function placeOrder(Request $request)
{
    $request->validate([
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required',
        'phone' => 'required|max:10',
        'address' => 'required',
    ]);
    $cart = Cart::where('user_id', auth()->user()->id)->get();
    $total_amount = 0;
    foreach ($cart as $item) {
        $total_amount += $item->item->price * $item->quantity;
    }
    DB::beginTransaction();
    try {
        $order = Order::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'total_amount' => $total_amount,
            'user_id' =>Auth::id(),
        ]);

        foreach ($cart as $item) {
            $order->orderItems()->create([
                'item_id' => $item->item_id,
                'price' => $item->item->price,
                'quantity' => $item->quantity,
            ]);
        }
        Cart::where('user_id', auth()->user()->id)->delete();
        DB::commit();
        return CustomException::validMessage([
            'order_id' => $order->id,
            'total_amount' => $total_amount,
        ],'Order placed successfully', 201);
    }catch (CustomException1 $e) {
        DB::rollBack();
        return $this->handleException($e);
    } catch (CustomException2 $e) {
        DB::rollBack();
        return $this->handleException($e);
    } catch (Exception $e) {
        DB::rollBack();
        return $this->handleException($e);
    }

}

}
