<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UsersController extends Controller
{
    public function index(int $id) 
    {   
        $user = User::find($id);

        return view('profile', ['user' => $user]);
    }
}
