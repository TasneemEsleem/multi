<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Mail\UserMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use  Str;

class FinancialController extends Controller
{
    public  function __construct()
    {
        // $this->authorizeResource(User::class, 'financial');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth('api')->check()){
            $financials = User::where('role_type', 3)->get();
            return response()->json(['financials' => $financials]);
        }else if (auth('user')->user()->role_type == 0) {
            $financials = User::where('role_type', 3)->get();
        } else {
            $restaurant_id = auth('user')->user()->restaurant_id;
            $financials = User::where('role_type', 3)->where('restaurant_id', $restaurant_id)->get();
        }
        return response()->view('controlPanel.financial.index', ['financials' => $financials]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->view('controlPanel.financial.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $validator = $request->validated();
        $financial = new User();
        $financial->name = $validator['name'];
        $financial->email = $validator['email'];
        $password = Str::random(8);
        $financial->password = Hash::make($password);
        $financial->role_type = 3;
        $financial->restaurant_id = Auth::user()->restaurant_id;
        $saved = $financial->save();
        if ($saved) {
            $financials = Role::where('name', 'Financial')->first();
            $financial->assignRole($financials);
            Mail::to([$financial])->send(new UserMail($financial, $password));
        }
        return response()->json(['message' =>  'Saved successfully']);
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
    public function edit(User $financial)
    {
        return response()->view('controlPanel.financial.edit', ['financial' => $financial]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $financial)
    {
        $validator = $request->validated();
        $financial->name = $validator['name'];
        $financial->email = $validator['email'];
        $password = Str::random(8);
        $financial->password = Hash::make($password);
        $financial->role_type = 3;
        $financial->restaurant_id = Auth::user()->restaurant_id;
        $saved = $financial->save();
        if ($saved) {
            $financials = Role::where('name', 'Financial')->first();
            $financial->assignRole($financials);
            Mail::to([$financial])->send(new UserMail($financial, $password));
        }
        return response()->json(['message' =>  'Saved successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $financial)
    {
        $financial->delete();
        return response()->json(['message' => 'Deleted Successfully']);
    }
}
