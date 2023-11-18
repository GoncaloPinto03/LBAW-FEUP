<?php
namespace App\Http\Controllers;

class UserController extends Controller
{
    public function list()
    { 
      if (!Auth::check()) {
        $users = User::all->get();
        return view('pages.home', ['users' => $users]);
      }
      $this->authorize('list', User::class);
      $users = Auth::user()->get();
      return view('pages.home', ['users' => $users]);
    }
}

