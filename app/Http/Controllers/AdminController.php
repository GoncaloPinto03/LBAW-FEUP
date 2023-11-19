<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
<<<<<<< HEAD

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('pages.admin', compact('users'));
    }


=======
use App\Models\Admin;

class AdminController extends Controller
{
    public function index() 
    {   
        return view('pages.admin');
    }

>>>>>>> home_page
}
