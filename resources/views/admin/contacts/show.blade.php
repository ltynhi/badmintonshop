@extends('admin.layout.app')

@section('title', 'Chi tiết liên hệ')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Chi tiết liên hệ #{{ $contact->id }}</h1>
        <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="row">
        <!-- Thông tin liên hệ -->
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin liên hệ</h6>
                    <span class="badge badge-{{ $contact->status_color }} badge-lg">
                        {{ $contact->status_text }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Họ tên:</strong></div>
                        <div class="col-sm-9">{{ $contact->name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Email:</strong></div>
                        <div class="col-sm-9">
                            <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Điện thoại:</strong></div>
                        <div class="col-sm-9">
                            @if($contact->phone)
                                <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a>
                            @else
                                <span class="text-muted">Không có</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Ngày gửi:</strong></div>
                        <div class="col-sm-9">{{ $contact->created_at->format('d/m/Y H:i:s') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Nội dung:</strong></div>
                        <div class="col-sm-9">
                            <div class="border p-3 bg-light rounded">
                                {{ $contact->message }}
                            </div>
                        </div>
                    </div>

                    @if($contact->admin_reply)
                        <hr>
                        <div class="row mb-3">
                            <div class="col-sm-3"><strong>Phản hồi:</strong></div>
                            <div class="col-sm-9">
                                <div class="border p-3 bg-success text-white rounded">
                                    {{ $contact->admin_reply }}
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3"><strong>Người trả lời:</strong></div>
                            <div class="col-sm-9">{{ $contact->repliedBy->name ?? 'N/A' }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3"><strong>Thời gian trả lời:</strong></div>
                            <div class="col-sm-9">{{ $contact->replied_at ? $contact->replied_at->format('d/m/Y H:i:s') : 'N/A' }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Form trả lời -->
        <div class="col-md-4">
            @if($contact->status == 'pending' || $contact->status == 'replied')
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            {{ $contact->admin_reply ? 'Cập nhật phản hồi' : 'Trả lời liên hệ' }}
                        </h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.contacts.reply', $contact) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nội dung phản hồi *</label>
                                <textarea name="admin_reply" class="form-control @error('admin_reply') is-invalid @enderror" 
                                         rows="8" placeholder="Nhập nội dung trả lời..." required>{{ old('admin_reply', $contact->admin_reply) }}</textarea>
                                @error('admin_reply')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-reply"></i> {{ $contact->admin_reply ? 'Cập nhật phản hồi' : 'Gửi phản hồi' }}
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Cập nhật trạng thái -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Cập nhật trạng thái</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.contacts.update-status', $contact) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <select name="status" class="form-select" required>
                                <option value="pending" {{ $contact->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                <option value="replied" {{ $contact->status == 'replied' ? 'selected' : '' }}>Đã trả lời</option>
                                <option value="closed" {{ $contact->status == 'closed' ? 'selected' : '' }}>Đã đóng</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save"></i> Cập nhật trạng thái
                        </button>
                    </form>
                </div>
            </div>

            <!-- Xóa liên hệ -->
            <div class="card shadow border-danger">
                <div class="card-header py-3 bg-danger text-white">
                    <h6 class="m-0 font-weight-bold">Xóa liên hệ</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted small">Xóa liên hệ này vĩnh viễn khỏi hệ thống.</p>
                    <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" 
                          onsubmit="return confirm('Bạn có chắc muốn xóa liên hệ này? Hành động này không thể hoàn tác!')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash"></i> Xóa liên hệ
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection