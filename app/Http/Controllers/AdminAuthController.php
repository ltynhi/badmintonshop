<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        // Debug logging
        \Log::info('Login attempt', [
            'email' => $request->email,
            'credentials' => $credentials
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            \Log::info('Login successful', [
                'user_id' => Auth::user()->id,
                'user_role' => Auth::user()->role,
                'is_admin' => Auth::user()->isAdmin()
            ]);
            
            // Tạo notification đăng nhập thành công (Bước 11 trong biểu đồ)
            Notification::create([
                'user_id' => Auth::user()->id,
                'type' => 'login_success',
                'title' => 'Đăng nhập thành công',
                'message' => 'Bạn đã đăng nhập vào hệ thống lúc ' . now()->format('H:i d/m/Y'),
                'data' => [
                    'login_time' => now()->toISOString(),
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent()
                ]
            ]);
            
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            
            return redirect()->route('home');
        }

        \Log::info('Login failed', ['email' => $request->email]);

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không đúng.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home');
    }
}
