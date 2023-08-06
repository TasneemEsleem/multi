<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Restaurant;
use Exception;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $restaurants=Restaurant::all();
        $selected_restaurant = $request->input('restaurant_id');
        $items = Item::query();
  if ($selected_restaurant) {
      $items->where('restaurant_id', $selected_restaurant);
  }
  $items = $items->get();
        return response()->view('landingPage.list_item', ['items' => $items , 'restaurants'=>$restaurants
        , 'selected_restaurant' => $selected_restaurant]);
    }


    public function viewCheckout()
    {
        $orders = Order::where('user_id', auth()->user()->id)->with(['orderItems', 'items'])->get();
        return response()->view('landingPage.checkout', ['orders' => $orders]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'quantity.*' => ['required', 'numeric'],
        ]);
        $itemIds = $request->input('item_id');
        $totalAmount = 0;
        try {
            $order = new Order();
            $order->user_id = auth()->user()->id;
            $order->total_amount = 0;
            $order->save();
            foreach ($itemIds as $item_id) {
                $orderItem = new OrderItem();
                $orderItem->item_id = $item_id;
                $orderItem->quantity =  $request->input('quantity');
                $item = Item::find($item_id);
                $orderItem->price = $item->price;
                // Use the order() relationship to assign the order_id
                $orderItem->order()->associate($order);
                $orderItem->save();
                $totalAmount += ($orderItem->quantity * $orderItem->price);
            }
            $order->total_amount = $totalAmount; // Set the calculated total amount
            $order->save();
            return response()->json(['message' => 'Saved successfully']);
        } catch (Exception $e) {
            // dd($e);
            return response()->json(['message' => 'Error occurred while saving the order'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        if(auth('api')->check()){
            return response()->json(['item' => $item]);
        }else{
            return response()->view('landingPage.product_details' , ['item' =>$item]);
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
