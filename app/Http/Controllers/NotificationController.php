<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;

class NotificationController extends Controller
{
    // Get all notifications (GET)
    public function index(){
        $notifications = auth()->user()->notifications()->orderBy('created_at', 'desc')->get();
        return view('website.notifications', compact('notifications'));
    }

    // Mark a notification as read (POST)
    public function markNotificationAsRead($id){
        Notification::markAsRead($id);
        return jsonResponese(true, 'success', 200);
    }
}
