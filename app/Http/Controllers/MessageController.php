<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display the private inbox and message creation form.
     */
    public function index()
    {
        // Get the currently logged-in user
        $user = Auth::user();

        // STRICT PRIVACY: Fetch messages where the receiver_username matches this user's name
        $incomingMessages = Message::where('receiver_username', $user->name)
            ->latest()
            ->get();

        // Send the private messages data to the view
        return view('messages.index', compact('incomingMessages'));
    }

    /**
     * Store a newly created message in the database.
     */
    public function store(Request $request)
    {
        // 1. Validate the user input form
        $request->validate([
            'receiver_username' => 'required|string|exists:users,name',
            'message_body' => 'required|string|max:1000',
        ], [
            'receiver_username.exists' => 'That username does not exist in our system.',
        ]);

        // 2. Save the message using the Model
        Message::create([
            'sender_id' => Auth::id(), // The logged-in user sending this
            'receiver_username' => $request->receiver_username,
            'message_body' => $request->message_body,
        ]);

        // 3. Redirect back to the screen with a success banner notice
        return redirect()->back()->with('success', 'Message sent successfully!');
    }
}