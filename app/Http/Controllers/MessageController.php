<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Restaurant;
use App\Models\User;
use App\Notifications\ChatNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index($restaurant_id)
    {
        $messages = Message::where('restaurant_id', $restaurant_id)->where('sender_id', Auth::user()->id)->get();
        return response()->json($messages);
    }
    public function chat()
    {
        $restaurants = Restaurant::all();
        return response()->view('landingPage.chat', [
            'restaurants' => $restaurants,
        ]);
    }
    public function sendMessage(Request $request)
    {
        $validatedData = $request->validate([
            'restaurant_id' => 'nullable|integer',
            'message' => 'required|string|max:500',
        ]);
        Message::create([
            'restaurant_id' => $validatedData['restaurant_id'],
            'message' => $validatedData['message'],
            'sender_id' => Auth::user()->id,
        ]);
        $user = User::where('restaurant_id', $request->restaurant_id)->first();
        $user->notify(new ChatNotification($request->message, auth::id()));
        return response()->json(['message' => 'Message sent successfully']);
    }
    public function chatAdmin()
    {
        $users = Message::with('user')
            ->select('sender_id')
            ->where('restaurant_id', Auth::user()->restaurant_id)
            ->groupBy('sender_id')
            ->get();
        return response()->view('controlPanel.chat', ['users' => $users]);
    }
    public function getMessages($user_id)
    {
        $messages = Message::where('sender_id', $user_id)
            ->where('restaurant_id', Auth::user()->restaurant_id)
            ->orderBy('created_at')
            ->get();
        return response()->json(['messages' => $messages]);
    }

    public function sendMessageCustomer(Request $request)
    {
        Message::create([
            'sender_id' => $request->input('receiver'),
            'restaurant_id' => Auth::user()->restaurant_id,
            'message' => $request->message,
        ]);
        $receiver_id = $request->input('receiver');
        $receiver = User::find($receiver_id);
        $user = auth()->user();
        $receiver->notify(new ChatNotification($request->message, $user));
        return response()->json(['message' => 'Message sent successfully']);
    }
}
