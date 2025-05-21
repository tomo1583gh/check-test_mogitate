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
            {{-- 左：画像 --}}
            <div class="detail-image">
                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}">
                <input type="file" name="image" class="image-input">

                @foreach ($errors->get('image') as $message)
                <div class="error-message">{{ $message }}</div>
                @endforeach
            </div>

            {{-- 右：フォーム --}}
            <div class="detail-form">
                <div class="form-group">
                    <label>商品名</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}">

                    @foreach ($errors->get('name') as $message)
                    <div class="error-message">{{ $message }}</div>
                    @endforeach
                </div>

                <div class="form-group">
                    <label>値段</label>
                    <input type="text" name="price" value="{{ old('price', $product->price) }}">

                    @foreach ($errors->get('price') as $message)
                    <div class="error-message">{{ $message }}</div>
                    @endforeach
                </div>

                <div class="form-group">
                    <label>季節</label><br>
                    <div class="season-options">
                        @foreach (['春','夏','秋','冬'] as $season)
                        <label>
                            <input type="checkbox" name="season[]" value="{{ $season }}"
                                {{ in_array($season, old('season', $product->season ?? [])) ? 'checked' : '' }}>
                            {{ $season }}
                        </label>
                        @endforeach
                    </div>

                    @foreach ($errors->get('season') as $message)
                    <div class="error-message">{{ $message }}</div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- 商品説明 --}}
        <div class="detail-description">
            <label>商品説明</label>
            <textarea name="description">{{ old('description', $product->description) }}</textarea>

            @foreach ($errors->get('description') as $message)
            <div class="error-message">{{ $message }}</div>
            @endforeach
        </div>

        {{-- フッター：ボタン --}}
        <div class="detail-footer">
            {{-- 左：中央寄せの戻る・保存 --}}
            <div class="footer-center">
                <a href="{{ route('products.index') }}" class="btn-back">戻る</a>
                <button type="submit" class="btn-submit">変更を保存</button>
            </div>
        </div>
    </form>

    {{-- 右：削除ボタン --}}
    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="footer-delete">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-delete" onclick="return confirm('本当に削除しますか？')">🗑</button>
    </form>
</div>
@endsection