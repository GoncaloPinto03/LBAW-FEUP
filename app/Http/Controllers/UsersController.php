<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\User;

class UsersController extends Controller
{
    public function index(int $id) 
    {   
        $user = User::find($id);

        return view('profile', ['user' => $user]);
    }

    public function edit()
    {
        $user = Auth::User();
        //$this->authorize('editUser', Auth::user());
        
        return view('edit_profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        //$this->authorize('editUser', Auth::user());
        $request->validate([
            'name' => 'max:255',
            'emaiil' => 'required|email|max:250|unique:users'
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        return redirect('profile/'.$user->user_id);
    }

}
