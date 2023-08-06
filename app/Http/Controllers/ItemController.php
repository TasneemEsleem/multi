<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\SubCategory;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function __construct()
    {
        // $this->authorizeResource(Item::class, 'item');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $this->authorize('viewAny' , Item::class);
        if(auth('api')->check()){
            $items = Item::all();
            return response()->json(['items' => $items]);
        }
        else if (auth('user')->user()->role_type == 0) {
            $items = Item::all();
        } else {
            $items = Item::where('restaurant_id', Auth::user()->restaurant_id)->with('categories')->get();
        }
        return response()->view('controlPanel.item.index', ['items' => $items]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('restaurant_id', Auth::user()->restaurant_id)
            ->get();
        return response()->view('controlPanel.item.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'image' => ['required', 'image', 'mimes:jpg,png,jpeg,gif,svg', 'max:2048'],
            'price' => ['required', 'numeric'],
            'categories.*' => ['numeric', 'exists:categories,id'],
        ]);
        $item = new Item();
        $item->name = $request->input('name');
        $item->price = $request->input('price');
        $item->user_id = Auth::user()->id;
        $item->restaurant_id = Auth::user()->restaurant_id;
        if ($request->hasFile('image')) {
            $imagetitle =  time() . '_' . str_replace(' ', '', $item->name) . '.' . $request->file('image')->extension();
            $request->file('image')->storePubliclyAs('item', $imagetitle, ['disk' => 'public']);
            $item->image = 'item/' . $imagetitle;
        }
        $item->save();

        // Attach categories to the item
        $categories = json_decode($request->input('categories'), true);
        foreach ($categories as $categoryId) {
            $item->categories()->attach($categoryId);
        }

        return response()->json(['message' => 'Create Item Successfuly']);
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
    public function edit(Item $item)
    {
        $categories = Category::where('restaurant_id', Auth::user()->restaurant_id)->where('parent_id', null)->get();;
        $selectedCategories = $item->categories->pluck('id')->toArray();

        return response()->view('controlPanel.item.edit', ['item' => $item, 'categories' => $categories, 'selectedCategories' => $selectedCategories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'categories.*' => ['numeric', 'exists:categories,id'],
        ]);
        $item->name = $request->input('name');
        $item->price = $request->input('price');
        $item->user_id = Auth::user()->id;
        $item->restaurant_id = Auth::user()->restaurant_id;
        if ($request->hasFile('image')) {
            $imagetitle =  time() . '_' . str_replace(' ', '', $item->name) . '.' . $request->file('image')->extension();
            $request->file('image')->storePubliclyAs('item', $imagetitle, ['disk' => 'public']);
            $item->image = 'item/' . $imagetitle;
        }
        $item->save();
        $categories = json_decode($request->input('categories'), true);
        $item->categories()->sync($categories);
        return response()->json(['message' => 'Update Item Successfuly']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $deleted = $item->delete();
        if ($deleted) {
            Storage::delete($item->image);
            $this->deleteImages($item);
        }
        return response()->json(['message' => 'Deleted successfully']);
    }
}
