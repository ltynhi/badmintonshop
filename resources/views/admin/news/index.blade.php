@extends('admin.layout.app')

@section('title', 'Quản lý tin tức')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold" style="color: #2c3e50;">📰 Quản lý tin tức</h2>
        <p class="text-muted mb-0">Đăng và quản lý bài viết tin tức</p>
    </div>
    <a href="{{ route('admin.news.create') }}" class="btn btn-primary">+ Thêm tin tức</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tiêu đề</th>
                        <th>Tác giả</th>
                        <th>Trạng thái</th>
                        <th>Ngày xuất bản</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($news as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->user->name ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-{{ $item->is_published ? 'success' : 'secondary' }}">
                                {{ $item->is_published ? 'Đã xuất bản' : 'Nháp' }}
                            </span>
                        </td>
                        <td>{{ $item->published_at ? $item->published_at->format('d/m/Y') : '-' }}</td>
                        <td>
                            <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-sm btn-warning">Sửa</a>
                            <form action="{{ route('admin.news.destroy', $item) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Xác nhận xóa?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Chưa có tin tức nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $news->links() }}
        </div>
    </div>
</div>
@endsection
