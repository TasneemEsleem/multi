<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function __construct()
    {
        // $this->authorizeResource(Category::class, 'category');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth('api')->check()){
            $categories = Category::with('parent')->get();
            return response()->json(['categories' => $categories]);


        } else if (Auth::user()->role_type == 0) {
            $categories = Category::with('parent')->get();
        } else {
            /////// Admin And DataEntry that show all category
            $categories = Category::where('restaurant_id', Auth::user()->restaurant_id)->with('parent')->get();
        }

        return response()->view('controlPanel.category.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = Category::where('restaurant_id', Auth::user()->restaurant_id)->where('parent_id', null)->get();
        return response()->view('controlPanel.category.create', ['parents' => $parents]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string']);
        $category = new Category();
        $category->name = $request->input('name');
        $category->parent_id = $request->input('parent_id');
        $category->user_id = Auth::user()->id;
        $category->restaurant_id = Auth::user()->restaurant_id;
        $category->save();
        return response()->json(['message' => 'Create Category Successfuly']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $parents = Category::where('restaurant_id', Auth::user()->restaurant_id)->get();
        return response()->view('controlPanel.category.edit', [
            'category' => $category,
            'parents' => $parents
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {

        $request->validate(['name' => ['required', 'string']]);
        $category->name = $request->input('name');
        $category->parent_id = $request->input('parent_id');
        $category->user_id = Auth::user()->id;
        $category->restaurant_id = Auth::user()->restaurant_id;
        $category->save();
        return response()->json(['message' => 'Update Category Successfuly']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
