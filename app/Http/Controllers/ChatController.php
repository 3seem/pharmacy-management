<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
   
    // public function show($conversationId)
    // {
    //     $conversation = Conversation::with('messages')
    //         ->findOrFail($conversationId);

    //     $user = Auth::user();
    //     if (
    //         ($user->role === 'admin' && $conversation->admin_id !== $user->id) ||
    //         ($user->role === 'customer' && $conversation->customer_id !== $user->id)
    //     ) {
    //         abort(403);
    //     }

    //     return view('chat.show', compact('conversation'));
    // }

    public function show($conversationId)
    {
            $conversation = Conversation::with('messages')->findOrFail($conversationId);

            $user = Auth::user();

            if (
                ($user->role === 'admin' && $conversation->admin_id !== $user->id) ||
                ($user->role === 'customer' && $conversation->customer_id !== $user->id)
            ) {
                abort(403);
            }

            if ($user->role === 'customer') {
                Message::where('conversation_id', $conversation->id)
                    ->where('sender_type', 'admin')
                    ->where('is_read', 0)
                    ->update(['is_read' => 1]);
            } elseif ($user->role === 'admin') {
                Message::where('conversation_id', $conversation->id)
                    ->where('sender_type', 'customer')
                    ->where('is_read', 0)
                    ->update(['is_read' => 1]);
            }

            return view('chat.show', compact('conversation'));
    }



    public function send(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'message' => 'required|string',
        ]);

        $user = Auth::user();

        Message::create([
            'conversation_id' => $request->conversation_id,
            'sender_type' => $user->role === 'admin' ? 'admin' : 'customer',
            'sender_id' => $user->id,
            'message' => $request->message,
        ]);

        return response()->json([
            'success' => true
        ]);
    }


    public function fetchMessages($conversationId)
    {
        $messages = Message::where('conversation_id', $conversationId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }
    
    


//     public function myChats()
// {
//     $user = auth()->user();

//     if ($user->role !== 'customer') {
//         abort(403);
//     }

//     $conversations = Conversation::with(['admin', 'latestMessage'])
//         ->where('customer_id', $user->id)
//         ->get();

//     return view('chat.list', compact('conversations'));
// }


//customer
public function myChats()
{
    $user = auth()->user();

    if ($user->role !== 'customer') {
        abort(403);
    }

    $conversations = Conversation::with(['admin', 'latestMessage'])
        ->where('customer_id', $user->id)
        ->get();

    foreach ($conversations as $conv) {
        $conv->unread_count = Message::where('conversation_id', $conv->id)
            ->where('sender_type', 'admin')
            ->where('is_read', 0)
            ->count();
    }
    $canStartChat = $conversations->isEmpty();

    return view('chat.list', compact('conversations', 'canStartChat'));
}


public function startChat(Request $request)
{
    $user = auth()->user();
    if ($user->role !== 'customer') abort(403);

    $admin = User::where('role', 'admin')->first();
    if (!$admin) {
        return redirect()->back()->with('error', 'no admin found now');
    }

    $conversation = Conversation::create([
        'customer_id' => $user->id,
        'admin_id' => $admin->id,
    ]);

    return redirect()->route('chat.show', $conversation->id);
}



        // public function adminChats()
        //     {
        //         $user = auth()->user();

        //         if ($user->role !== 'admin') {
        //             abort(403);
        //         }

        //         $conversations = Conversation::with(['customer', 'latestMessage'])
        //             ->where('admin_id', $user->id)
        //             ->get();

        //         return view('chat.admin_list', compact('conversations'));
        //     }
       
        public function adminChats()
        {
            $user = auth()->user();

            if ($user->role !== 'admin') {
                abort(403);
            }

            $conversations = Conversation::with(['customer', 'latestMessage'])
                ->where('admin_id', $user->id)
                ->get();

            foreach ($conversations as $conv) {
                $conv->unread_count = Message::where('conversation_id', $conv->id)
                    ->where('sender_type', 'customer')
                    ->where('is_read', 0)
                    ->count();
            }

            return view('chat.admin_list', compact('conversations'));
        }




}
