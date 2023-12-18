<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function show_notifs($id)
    {
        $user = User::find($id);
        print($id);

        $notifications = Notification::where('notified_user', $id)->get();
        
        if (!$notifications)
        {
            print("No notifications");
        }
        else {
            printf("Has notifs");
        }

        return view('notifications', compact('notifications'));
    }
}
