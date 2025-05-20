@extends('layouts.app')

@section('content')
<div class="product-form-wrapper">
    <h2>商品登録</h2>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>
                商品名
                <span class="required-label">必須</span>
            </label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="商品名を入力">
            @error('name') <div class="error-message">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>
                値段
                <span class="required-label">必須</span>
            </label>
            <input type="number" name="price" value="{{ old('price') }}" placeholder="値段を入力">
            @error('price') <div class="error-message">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>
                商品画像
                <span class="required-label">必須</span>
            </label>
            <input type="file" name="image" accept=".jpeg,.png">
            @error('image') <div class="error-message">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <div class="label-row">
            <label>
                季節（複数選択可）
                <span class="required-label">必須</span>
            </label><br>
            </div>

            <div class="season-options">
                @foreach (['春', '夏', '秋', '冬'] as $season)
                    <label>
                        <input type="checkbox" name="season[]" value="{{ $season }}"
                            {{ is_array(old('season')) && in_array($season, old('season')) ? 'checked' : '' }}> {{ $season }}</label><br>
                @endforeach
            </div>

            @error('season') <div class="error-message">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>
                商品説明
                <span class="required-label">必須</span>
            </label>
            <textarea name="description" placeholder="商品の説明を入力">{{ old('description') }}</textarea>
            @error('description') <div class="error-message">{{ $message }}</div> @enderror
        </div>

        <div class="form-footer">
            <a href="{{ route('products.index') }}" class="btn-back">戻る</a>
            <button type="submit" class="btn-submit">登録</button>
        </div>
    </form>
</div>
@endsection