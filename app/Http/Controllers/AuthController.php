<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validation với thông báo lỗi chi tiết cho email trùng
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ], [
            'email.unique' => 'Email này đã được sử dụng. Vui lòng chọn email khác hoặc đăng nhập nếu đây là tài khoản của bạn.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'role' => 'customer',
        ]);

        // Tạo notification chào mừng (Bước 15 trong biểu đồ)
        Notification::create([
            'user_id' => $user->id,
            'type' => 'welcome',
            'title' => 'Chào mừng đến với Coza Shop!',
            'message' => 'Cảm ơn bạn đã đăng ký tài khoản. Chúc bạn có những trải nghiệm mua sắm tuyệt vời!',
            'data' => [
                'welcome_bonus' => true,
                'first_time_user' => true
            ]
        ]);

        // Gửi email xác thực/chào mừng (Bước 16 trong biểu đồ)
        try {
            Mail::to($user->email)->send(new WelcomeEmail($user));
        } catch (\Exception $e) {
            // Log lỗi nhưng không làm gián đoạn quá trình đăng ký
            \Log::error('Failed to send welcome email: ' . $e->getMessage());
        }

        Auth::login($user);

        return redirect()->route('home')
            ->with('success', 'Đăng ký thành công! Chào mừng bạn đến với Coza Shop. Vui lòng kiểm tra email để xem thông tin chào mừng.');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $user->update($validated);

        return redirect()->back()
            ->with('success', 'Cập nhật thông tin thành công!');
    }

    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng']);
        }

        $user->update([
            'password' => Hash::make($validated['password'])
        ]);

        return redirect()->back()
            ->with('success', 'Đổi mật khẩu thành công!');
    }
}
