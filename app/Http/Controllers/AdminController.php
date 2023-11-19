<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Admin;

class AdminController extends Controller
{
    public function index() 
    {   
        $users = $this->getUsersList();

        return view('pages.admin', compact('users'));
    }

    function showUsers() {
        $users = User::all();
        return view('pages.admin', ['users' => $users]); 
    }
    private function getUsersList()
    {
        $adminController = new AdminController();
        return $adminController->showUsers()->getData()['users'];
    }
}
