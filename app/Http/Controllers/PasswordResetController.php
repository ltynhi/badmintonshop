<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Notification;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    // Hiển thị form quên mật khẩu
    public function showForgotForm()
    {
        return view('fogot-pass');
    }

    // Xử lý gửi email reset
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'email.exists' => 'Email không tồn tại trong hệ thống'
        ]);

        // Tạo token
        $token = Str::random(64);

        // Xóa token cũ nếu có
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Lưu token mới
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        // Gửi email reset password (Bước 12-13 trong biểu đồ)
        try {
            Mail::send('emails.password-reset', ['token' => $token], function($message) use($request){
                $message->to($request->email);
                $message->subject('Đặt lại mật khẩu - Coza Shop');
                $message->from(config('mail.from.address', 'noreply@cozashop.com'), 'Coza Shop');
            });
            
            \Log::info('Password reset email sent', ['email' => $request->email, 'token' => $token]);
        } catch (\Exception $e) {
            \Log::error('Failed to send password reset email: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi gửi email. Vui lòng thử lại sau.');
        }

        return back()->with('success', 'Chúng tôi đã gửi link đặt lại mật khẩu đến email của bạn!');
    }

    // Hiển thị form reset password
    public function showResetForm($token)
    {
        return view('reset-password', ['token' => $token]);
    }

    // Xử lý reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:6|confirmed',
            'token' => 'required'
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'email.exists' => 'Email không tồn tại',
            'password.required' => 'Vui lòng nhập mật khẩu mới',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp'
        ]);

        // Kiểm tra token
        $updatePassword = DB::table('password_reset_tokens')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])
            ->first();

        if (!$updatePassword) {
            return back()->withInput()->with('error', 'Token không hợp lệ!');
        }

        // Kiểm tra token đã hết hạn chưa (60 phút)
        $tokenCreatedAt = Carbon::parse($updatePassword->created_at);
        if (Carbon::now()->diffInMinutes($tokenCreatedAt) > 60) {
            return back()->withInput()->with('error', 'Token đã hết hạn!');
        }

        // Cập nhật mật khẩu mới
        $user = User::where('email', $request->email)->first();
        $user->update(['password' => Hash::make($request->password)]);

        // Tạo notification đặt lại mật khẩu thành công
        Notification::create([
            'user_id' => $user->id,
            'type' => 'password_reset',
            'title' => 'Mật khẩu đã được đặt lại',
            'message' => 'Mật khẩu của bạn đã được đặt lại thành công lúc ' . now()->format('H:i d/m/Y'),
            'data' => [
                'reset_time' => now()->toISOString(),
                'ip_address' => $request->ip()
            ]
        ]);

        // Xóa token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Đặt lại mật khẩu thành công! Vui lòng đăng nhập.');
    }
}
