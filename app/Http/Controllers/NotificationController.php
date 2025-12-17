<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        $notifications = auth()->user()
            ->notifications()
            ->latest()
            ->paginate(20);
        
        return view('notifications.index', compact('notifications'));
    }
    
    public function getUnread()
    {
        if (!auth()->check()) {
            return response()->json([
                'notifications' => [],
                'unread_count' => 0
            ]);
        }
        
        $notifications = auth()->user()
            ->notifications()
            ->unread()
            ->latest()
            ->take(10)
            ->get();
        
        $unreadCount = auth()->user()->notifications()->unread()->count();
        
        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }
    
    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        
        return response()->json(['success' => true]);
    }
    
    public function markAllAsRead()
    {
        auth()->user()->notifications()->unread()->update(['read_at' => now()]);
        
        return back()->with('success', 'Đã đánh dấu tất cả thông báo là đã đọc');
    }
}
