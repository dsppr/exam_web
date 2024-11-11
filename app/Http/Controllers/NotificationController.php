<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class NotificationController extends Controller
{
    public function index()
    {
        // Menggunakan unreadNotifications daripada notifications() secara langsung
        $notifications = Auth::user()->unreadNotifications;

        return Inertia::render('Notifications/Index', compact('notifications'));
    }

    public function markAsRead($notificationId)
    {
        $notification = Auth::user()->unreadNotifications->find($notificationId);

        if ($notification) {
            $notification->markAsRead();
            return redirect()->back()->with('success', 'Notification marked as read.');
        }

        return redirect()->back()->with('error', 'Notification not found.');
    }
}
