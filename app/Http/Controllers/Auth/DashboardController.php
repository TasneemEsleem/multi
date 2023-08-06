<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use App\Models\Restaurant;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\assertNotNull;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role_type == 4) {
            $carts = app('cart');
            $total_amount = $carts->sum(function ($item) {
                return $item->quantity * $item->item->price;
            });
            return response()->view('landingPage.parent', [
                'carts' => $carts,
                'total_amount' => $total_amount
            ]);
        } elseif (Auth::user()->role_type == 0) {
            $categories = Category::count();
            $items = Item::count();
            $users = User::where('role_type', 4)->count();
            $employment = User::whereNotNull('restaurant_id')->count();
        } else {
            // $restaurant=Restaurant::where('restaurant_id', Auth::user()->restaurant_id)->get();
            $categories = Category::where('restaurant_id', Auth::user()->restaurant_id)->count();
            // $subcategories=SubCategory::where('restaurant_id', Auth::user()->restaurant_id)->get();
            $items = Item::where('restaurant_id', Auth::user()->restaurant_id)->count();
            $users = User::where('role_type', 4)->count();
            $employment = User::where('restaurant_id', Auth::user()->restaurant_id)->count();
        }
        return response()->view('auth.dashboard', [
            'users' => $users, 'items' => $items, 'categories' => $categories,
            'employment' => $employment
        ]);
    }
    public function indexCustomer()
    {
        $restaurants = Restaurant::with('categories')->get();
        // $categories = Category::where('restaurant_id', )->get();
        $cart = app('cart');
        $total_amount = $cart->sum(function ($item) {
            return $item->quantity * $item->item->price;
        });
        return response()->view('landingPage.home', [
            'cart' => $cart,
            'total_amount' => $total_amount,
            'restaurants' =>$restaurants,
            // 'categories' =>$categories
        ]);
    }
}
