<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:الاشعارات', ['only' => ['index', 'MarkAsReadAll']]);
    }

    public function index()
    {
        $notifications = Auth::user()->unreadNotifications;
        return view('notification.notification', compact('notifications'));
    }
    public function MarkAsReadAll(Request $request)
    {
        $userUnreadNotification = Auth::user()->unreadNotifications;
        if ($userUnreadNotification) {
            $userUnreadNotification->MarkAsReadAll();
            return back();
        }
    }
}
