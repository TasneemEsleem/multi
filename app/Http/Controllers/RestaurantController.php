<?php

namespace App\Http\Controllers;

use App\Http\Requests\RestaurantsRequest;
use App\Mail\UserMail;
use App\Models\Category;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Str;

class RestaurantController extends Controller
{

    public function __construct()
    {
        // $this->authorizeResource(Restaurant::class, 'restaurant');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth('api')->check()){
            $restaurants = Restaurant::all();
            return response()->json(['restaurants' => $restaurants]);
        }
        elseif (auth('user')->user()->role_type == 0) {
            $restaurants = Restaurant::all();
            return response()->view('controlPanel.restaurants.index', ['restaurants' => $restaurants]);
        } else {
            $restaurant_id = auth('user')->user()->restaurant_id;
            $restaurant = Restaurant::find($restaurant_id);
            return response()->view('controlPanel.restaurants.show', ['restaurant' => $restaurant]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role_type', 1)->where('restaurant_id', null)->get();
        return response()->view('controlPanel.restaurants.create', ['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RestaurantsRequest $request)
    {
        $validate_data = $request->validated();

        $restaurant = new Restaurant();
        $restaurant->name = $validate_data['name'];
        $restaurant->email = $validate_data['email'];
        $restaurant->phone = $validate_data['phone'];
        $restaurant->address = $validate_data['address'];
        $restaurant->openingHours = $validate_data['openingHours'];
        $saveData = $restaurant->save();

        $user  = User::find($request->input('user_id'));
        if ($saveData && $user) {
            $password = Str::random(8);
            $user->password = Hash::make($password);
            $user->role_type = 1;
            $user->restaurant_id = $restaurant->id;
            $isSaved = $user->save();
        } else {
            $user = new User();
            $user->name = $request->input('name_user');
            $user->email = $request->input('email_user');
            $password = Str::password();
            $user->password = Hash::make($password);
            $user->role_type = 1;
            $user->restaurant_id = $restaurant->id;
            $isSaved = $user->save();
        }
        if ($isSaved) {
            $admin = Role::where('name', 'admin')->first();
            $user->assignRole($admin);
            Mail::to([$user])->send(new UserMail($user, $password));
        }
        return response()->json(['message' =>  'Saved successfully']);
    }

    /**
     * Display the specified resource.
     * To Landing_Page
     */
    public function ViewRestaurant()
    {
        $restaurants = Restaurant::with('categories')->get();
if(auth('api')->check()){
    return response()->json(['restaurants' => $restaurants]);

}else{
    return response()->view('landingPage.all-restaurant', ['restaurants' => $restaurants]);

}

    }
    public function showCategory(Restaurant $restaurant)
    {
        $restaurant = Restaurant::with('categories')->findOrFail($restaurant->id);
        if(auth('api')->check()){
            return response()->json(['restaurant' => $restaurant]);
        }else{
        return response()->view('landingPage.all-category', ['restaurant' => $restaurant]);}
    }

    public function showItem(Category $category)
    {
        $category = Category::with('items')->findOrFail($category->id);
        if(auth('api')->check()){
            return response()->json(['category' => $category]);
        }else{
            return response()->view('landingPage.all-item', ['category' => $category]);
        }

    }

    public function show(Restaurant $restaurant)
    {
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Restaurant $restaurant)
    {
        if (auth('user')->user()->role_type == 1) {
            $restaurant_id = auth('user')->user()->restaurant_id;
            $restaurant = Restaurant::find($restaurant_id);
        }
        return response()->view('controlPanel.restaurants.edit', ['restaurant' => $restaurant]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        // $validate_data = $request->validate();
        $restaurant->name = $request->input('name');
        $restaurant->email = $request->input('email');
        $restaurant->phone = $request->input('phone');
        $restaurant->address = $request->input('address');
        $restaurant->openingHours = $request->input('openingHours');
        $restaurant->save();
        return response()->json(['message' =>  'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();
        return response()->json(['message' => 'Deleted Successfully']);
    }

    public function trashed()
    {
        $restaurants = Restaurant::onlyTrashed()->get();
        return response()->view('controlPanel.restaurants.trashed', [
            'restaurants' => $restaurants,
        ]);
    }

    public function restore($id)
    {
        $restaurant = Restaurant::withTrashed()->findOrFail($id);
        $restaurant->restore();
        return response()->json(['message' => 'restaurant restored successfully']);
    }

    public function forceDelete($id)
    {
        $restaurant = Restaurant::withTrashed()->findOrFail($id);
        $user_restaurant = $restaurant->user;
        foreach ($user_restaurant as $user) {
            $user->restaurant_id = null;
            $user->save();
        }
        $restaurant->forceDelete();
        return response()->json(['message' => 'restaurant deleted Successfully']);
    }
}
