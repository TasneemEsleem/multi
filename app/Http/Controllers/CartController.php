<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    public function index()
    {
        $cart = app('cart');
        $total_amount = $cart->sum(function ($item) {
            return $item->quantity * $item->item->price;
        });
        return response()->view('landingPage.cart', [
            'cart' => $cart, 'total_amount' => $total_amount
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'item_id' => ['required', 'int', 'exists:items,id'],
            'quantity' => ['required', 'min:1', 'max:10'],
        ]);
        $cart = Cart::where([
            'cookie_id' => app('cart_id'),
            'item_id' => $request->input('item_id'),
        ])->first();
        if ($cart) {
            $cart->update([
                'user_id' => Auth::id(),
                'quantity' => $cart->quantity +  $request->input('quantity', 1),
            ]);
        } else {
            Cart::create([
                'cookie_id' => app('cart_id'),
                'user_id' => Auth::id(),
                'item_id' => $request->input('item_id'),
                'quantity' => $request->input('quantity', 1)
            ]);
        }
        return response()->json(['message' => 'Successfuly Added To Cart']);
    }

//Start functions API
    public function addToCart(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|numeric|min:1',
        ]);
        $item = Item::find($request->input('item_id'));
        $quantity = $request->input('quantity');
        $cartItem = Cart::where('item_id', $item->id)->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            Cart::create([
                'cookie_id' => app('cart_id'),
                'user_id' => Auth::id(),
                'item_id' => $item->id,
                'quantity' => $quantity,
            ]);
        }
        return CustomException::validMessage([
             'Item added to cart successfully',
        ], Response::HTTP_OK);
    }
    public function getCarts()
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
        $carts = $user->cart;
        return response()->json(['carts' => $carts], 200);
    }
    public function getOrder(){
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
        $orders = $user->orders;
        return response()->json(['orders' => $orders], 200);
    }
    // End functions Api
}
