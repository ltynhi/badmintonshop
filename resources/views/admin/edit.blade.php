@extends('layouts.app')

@section('title', 'Sửa sản phẩm')

@section('content')
<h1>Sửa sản phẩm</h1>

<form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
  @csrf
  @method('PUT')

  <label>Tên sản phẩm:</label>
  <input type="text" name="name" value="{{ $product->name }}" required><br>

  <label>Giá:</label>
  <input type="number" name="price" value="{{ $product->price }}" required><br>

  <label>Thương hiệu:</label>
  <input type="text" name="brand" value="{{ $product->brand }}"><br>

  <label>Danh mục:</label>
  <select name="category_id">
    <option value="">-- Chọn danh mục --</option>
    @foreach($categories as $category)
      <option value="{{ $category->id }}" @if($product->category_id == $category->id) selected @endif>
        {{ $category->name }}
      </option>
    @endforeach
  </select><br>

  <label>Mô tả:</label>
  <textarea name="description">{{ $product->description }}</textarea><br>

  <label>Ảnh hiện tại:</label>
  @if($product->image)
    <img src="{{ asset('storage/' . $product->image) }}" width="80"><br>
  @endif
  <input type="file" name="image"><br>

  <label>Hiển thị:</label>
  <input type="checkbox" name="status" value="1" @if($product->status) checked @endif><br>

  <button type="submit">Cập nhật</button>
</form>
@endsection
