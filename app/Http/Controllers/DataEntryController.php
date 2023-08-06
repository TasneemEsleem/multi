<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Mail\UserMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Str;

class DataEntryController extends Controller
{
    public  function __construct()
    {
        // $this->authorizeResource(User::class, 'dataentry');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth('api')->check()){
            $dataentries = User::where('role_type', 2)->get();
            return response()->json(['dataentries' => $dataentries]);
        }else if (auth('user')->user()->role_type == 0) {
            $dataentries = User::where('role_type', 2)->get();
        } else {
            $restaurant_id = auth('user')->user()->restaurant_id;
            $dataentries = User::where('role_type', 2)->where('restaurant_id', $restaurant_id)->get();
        }
        return response()->view('controlPanel.dataentry.index', ['dataentries' => $dataentries]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->view('controlPanel.dataentry.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $validator = $request->validated();
        $dataentry = new User();
        $dataentry->name = $validator['name'];
        $dataentry->email = $validator['email'];
        $password = Str::random(8);
        $dataentry->password = Hash::make($password);
        $dataentry->role_type = 2;
        $dataentry->restaurant_id = Auth::user()->restaurant_id;
        $saved = $dataentry->save();
        if ($saved) {
            $dataEntry = Role::where('name', 'Data-Entry')->first();
            $dataentry->assignRole($dataEntry);
            Mail::to([$dataentry])->send(new UserMail($dataentry, $password));
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
    public function edit(User $dataentry)
    {
        return response()->view('controlPanel.dataentry.edit', ['dataentry' => $dataentry]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $dataentry)
    {
        $validator = $request->validated();
        $dataentry->name = $validator['name'];
        $dataentry->email = $validator['email'];
        $password = Str::random(8);
        $dataentry->password = Hash::make($password);
        $dataentry->role_type = 2;
        $dataentry->restaurant_id = Auth::user()->restaurant_id;
        $saved = $dataentry->save();
        if ($saved) {
            $dataEntry = Role::where('name', 'Data-Entry')->first();
            $dataentry->assignRole($dataEntry);
            Mail::to([$dataentry])->send(new UserMail($dataentry, $password));
        }
        return response()->json(['message' =>  'Saved successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $dataentry)
    {
        $dataentry->delete();
        return response()->json(['message' =>  'Deleted Successfully']);
    }
}
