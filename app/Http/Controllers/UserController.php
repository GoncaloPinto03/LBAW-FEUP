<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Admin;
use App\Models\Photo;

class UserController extends Controller
{
    function showUsersList() {
        $users = User::all();
        return view('pages.admin', ['users' => $users]); 
    }

    public function index(int $id) 
    {   
        $user = User::find($id);

        if(Auth::guard('admin')->check()) {
            return view('profile', ['user' => $user]);    
        }
        if(!Auth::check()) {
            return redirect()->intended('/home');
        }

        return view('profile', ['user' => $user]);
    }

    public function edit($id)
    {
        //$user = Auth::User();
        //$this->authorize('editUser', Auth::user());
        $user = User::find($id);

        // Check if the authenticated user is an admin
        if (Auth::guard('admin')->check()) {
            // If the authenticated user is an admin, pass the user information for editing
            return view('edit_profile', ['user' => $user]);
        } elseif (Auth::user()->user_id == $user->user_id) {
            // If the authenticated user is the owner of the profile, allow editing
            return view('edit_profile', ['user' => $user]);
        }
        // If the authenticated user is neither an admin nor the owner of the profile, redirect to home
        return redirect()->intended('/home');
    }

    public function update(Request $request, $id)

    {
        $user = User::find($id);
        //$user = Auth::user();
        //$this->authorize('editUser', Auth::user());
        $request->validate([
            'name' => 'unique:users,name,'.$user->user_id.',user_id|max:255',
            'email' => 'email|unique:users,email,'.$user->user_id.',user_id|max:255'
        ]);
        if($request->file('image')){
            if( !in_array(pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION),['jpg','jpeg','png'])) {
                return redirect('profile/edit');
            }
            $request->validate([
                'image' =>  'mimes:png,jpeg,jpg',
            ]);
            PhotoController::update($user->user_id, 'profile', $request);
        }
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        return redirect('profile/'.$user->user_id);
    }

    public function showArticles(int $id)
    {
        $user = User::find($id);

        $articles = $user->articles;

        return view('user-articles', compact('user', 'articles'));
    }

    public function showLinkRequestForm()
    {
        return view('partials.send_mail');
    }

    public function showUpdatePassForm()
    {
        return view('partials.recover_password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:250',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::where('email', '=', $request->input('email'))->first();
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect()->route('home')
            ->withSuccess('You have successfully changed your password!');
    }

}

