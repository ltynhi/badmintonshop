@extends('layouts.app')

@section('title', 'Thêm sản phẩm')

@section('content')
<h1>Thêm sản phẩm mới</h1>

<form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
  @csrf
  <label>Tên sản phẩm:</label>
  <input type="text" name="name" required><br>

  <label>Giá:</label>
  <input type="number" name="price" required><br>

  <label>Thương hiệu:</label>
  <input type="text" name="brand"><br>

  <label>Danh mục:</label>
  <select name="category_id">
    <option value="">-- Chọn danh mục --</option>
    @foreach($categories as $category)
      <option value="{{ $category->id }}">{{ $category->name }}</option>
    @endforeach
  </select><br>

  <label>Mô tả:</label>
  <textarea name="description"></textarea><br>

  <label>Ảnh:</label>
  <input type="file" name="image"><br>

  <label>Hiển thị:</label>
  <input type="checkbox" name="status" value="1" checked><br>

  <button type="submit">Thêm sản phẩm</button>
</form>
@endsection
