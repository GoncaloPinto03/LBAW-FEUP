<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Admin;

class AdminController extends Controller
{
    public function index() 
    {   
        return view('pages.admin');
    }

}
