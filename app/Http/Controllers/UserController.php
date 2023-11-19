<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

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

}

