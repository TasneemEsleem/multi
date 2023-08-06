<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderCustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth('api')->check()){
            $orderItems = OrderItem::with('item')->get();
            $groupe_items = $orderItems->groupBy('item.name');
            $item_quantities = $groupe_items->mapWithKeys(function ($orderItems, $itemName) {
                return [$itemName => $orderItems->sum('quantity')];
            });
            return response()->json([ 'orderItems' => $orderItems,
            'item_quantities' => $item_quantities]);
        }
        elseif (auth('user')->check() && auth('user')->user()->role_type ==  0) {
            $orderItems = OrderItem::with('item')->get();
            $groupe_items = $orderItems->groupBy('item.name');
            $item_quantities = $groupe_items->mapWithKeys(function ($orderItems, $itemName) {
                return [$itemName => $orderItems->sum('quantity')];
            });
        } else {
            $restaurant_id = Auth::user()->restaurant_id;
            $orderItems = OrderItem::with([
                'item' => function ($query) use ($restaurant_id) {
                    $query->where('restaurant_id', $restaurant_id);
                }
            ])->get();

            $groupe_items = $orderItems->groupBy('item.name');
            $item_quantities = $groupe_items->mapWithKeys(function ($orderItems, $itemName) {
                return [$itemName => $orderItems->sum('quantity')];
            });
        }
        return response()->view('controlPanel.OrderItemsCustomer.index', [
            'orderItems' => $orderItems, 'item_quantities' => $item_quantities
        ]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
