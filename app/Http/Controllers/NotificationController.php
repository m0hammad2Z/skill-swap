<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class NotificationController extends Controller
{
    // Get all notifications (GET)
    public function index(){
        $notifications = auth()->user()->notifications()->orderBy('created_at', 'desc')->get();
        return view('website.notifications', compact('notifications'));
    }

    // Mark a notification as read (POST)
    public function markAsRead($id){
        

        return redirect($notification->url);
    }
}
