@extends('layouts.app')

@section('content')
<div class="detail-container">
    <div class="breadcrumb">
        <a href="{{ route('products.index') }}">商品一覧</a> ＞ {{ $product->name }}
    </div>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="detail-content">
            <div class="detail-image">
                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}">
                <input type="file" name="image" class="image-input">
                @error('image') <div class="error-message">{{ $message }}</div> @enderror
            </div>

            <div class="detail-form">
                <div class="form-group">
                    <label>商品名</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" placeholder="商品名を入力">
                    @error('name') <div class="error-message">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>値段</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" placeholder="値段を入力">
                    @error('price') <div class="error-message">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>季節</label><br>
                    @foreach (['春', '夏', '秋', '冬'] as $season)
                    <label>
                        <input type="checkbox" name="season[]" value="{{ $season }}"
                            {{ in_array($season, old('season', json_decode($product->season, true))) ? 'checked' : '' }}>
                        {{ $season }}
                    </label>
                    @endforeach
                    @error('season') <div class="error-message">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        <div class="detail-description">
            <label>商品説明</label>
            <textarea name="description" placeholder="商品の説明を入力">{{ old('description', $product->description) }}</textarea>
            @error('description') <div class="error-message">{{ $message }}</div> @enderror
        </div>

        <div class="detail-footer">
            <a href="{{ route('products.index') }}" class="btn-back">戻る</a>
            <button type="submit" class="btn-submit">変更を保存</button>
            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-form">
                @csrf @method('DELETE')
                <button type="submit" class="btn-delete" onclick="return confirm('本当に削除しますか？')">🗑</button>
            </form>
        </div>
    </form>
</div>
@endsection