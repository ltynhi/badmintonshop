<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::with('repliedBy')->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $contacts = $query->paginate(20);

        return view('admin.contacts.index', compact('contacts'));
    }

    public function show(Contact $contact)
    {
        return view('admin.contacts.show', compact('contact'));
    }

    public function reply(Request $request, Contact $contact)
    {
        $request->validate([
            'admin_reply' => 'required|string|max:2000',
        ], [
            'admin_reply.required' => 'Vui lòng nhập nội dung trả lời',
        ]);

        $contact->update([
            'admin_reply' => $request->admin_reply,
            'status' => 'replied',
            'replied_at' => now(),
            'replied_by' => Auth::id(),
        ]);

        // Gửi email trả lời (tùy chọn - có thể bật/tắt)
        // Uncomment dòng dưới nếu muốn gửi email tự động
        /*
        try {
            Mail::send('emails.contact-reply', [
                'contact' => $contact,
                'reply' => $request->admin_reply
            ], function($message) use ($contact) {
                $message->to($contact->email, $contact->name)
                       ->subject('Phản hồi từ VNB Sports - ' . $contact->name);
            });
        } catch (\Exception $e) {
            // Log error nhưng vẫn cập nhật trạng thái
        }
        */

        return redirect()->route('admin.contacts.show', $contact)
                        ->with('success', 'Đã gửi phản hồi thành công!');
    }

    public function updateStatus(Request $request, Contact $contact)
    {
        $request->validate([
            'status' => 'required|in:pending,replied,closed'
        ]);

        $contact->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Đã cập nhật trạng thái!');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('admin.contacts.index')
                        ->with('success', 'Đã xóa liên hệ!');
    }
}