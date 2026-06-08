<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function store(Request $request, Chirp $chirp)
    {
        $validated = $request->validate([
            'reply_message' => 'required|string|max:255',
        ]);

        $chirp->replies()->create([
            'user_id' => auth()->id(),
            'message' => $validated['reply_message'],
        ]);

        return back()->with('success', 'Reply added!');
    }
}