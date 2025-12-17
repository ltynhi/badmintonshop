@extends('layouts.app')

@section('title', 'Quản lý sản phẩm')

@section('content')
<h1>Danh sách sản phẩm</h1>
<a href="{{ route('products.create') }}">Thêm sản phẩm mới</a>

<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Tên</th>
      <th>Giá</th>
      <th>Thương hiệu</th>
      <th>Thao tác</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($products as $product)
    <tr>
      <td>{{ $product->id }}</td>
      <td>{{ $product->name }}</td>
      <td>{{ number_format($product->price) }}đ</td>
      <td>{{ $product->brand }}</td>
      <td>
        <a href="{{ route('products.edit', $product->id) }}">Sửa</a> |
        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
          @csrf
          @method('DELETE')
          <button type="submit" onclick="return confirm('Xóa sản phẩm này?')">Xóa</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection
