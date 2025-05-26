<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(Request $request){
        return response()->json([
            "user" => $request-> user()
        ]);
    }

    public function update(Request $request){
        
        $user = $request->user();

        $validated = $request->validate([
            'firstname' => 'sometimes|string|max:120',
            'lastname' => 'sometimes|string|max:75',
            'date_of_birth' => 'sometimes|date',
            'username' => 'sometimes|string|max:255|unique:users,username,' . $user->id,
            'email' => 'sometimes|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $user
        ]);
    }
}
