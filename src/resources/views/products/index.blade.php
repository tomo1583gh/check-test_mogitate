@extends('layouts.app')

@section('content')
<div class="product-page">

    <!-- ✅ 左：検索・並び替え -->
    <aside class="sidebar">
        <h2>商品一覧</h2>

        {{-- 検索フォーム --}}
        <form method="GET" action="{{ route('products.index') }}" class="search-form">
            <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="商品名で検索">
            <button type="submit" class="btn-search">検索</button>

            {{-- 並び替えセレクト --}}
            <label for="sort" class="sort-label">価格順で表示</label>
            <select name="sort" id="sort" onchange="this.form.submit()">
                <option value="">価格順で選ぶ</option>
                <option value="asc" {{ request('sort') === 'asc' ? 'selected' : '' }}>安い順</option>
                <option value="desc" {{ request('sort') === 'desc' ? 'selected' : '' }}>高い順</option>
            </select>
        </form>

        {{-- 並び替えタグの表示 --}}
        @if(request('sort'))
        <div class="sort-tag">
            {{ request('sort') === 'asc' ? '安い順' : '高い順' }}
            <a href="{{ route('products.index', array_filter(request()->except('sort'))) }}" class="tag-remove">×</a>
        </div>
        @endif
    </aside>

    <!-- ✅ 右：商品カード一覧 -->
    <section class="product-list">
        <div class="product-list-header">
            <div class="spacer"></div>
            <a href="{{ route('products.register') }}" class="btn-add">＋商品を追加</a>
        </div>

        <div class="product-grid">
            @forelse ($products as $product)
            <a href="{{ route('products.show', $product->id) }}" class="product-card">
                <img src="{{ asset('storage/'. $product->image_path) }}" alt="{{ $product->name }}">

                <div class="product-info-row">
                    <span class="product-name">{{ $product->name }}</span>
                    <span class="product-price">¥{{ number_format($product->price) }}</span>
                </div>

            </a>
            @empty
            <p>商品が見つかりませんでした。</p>
            @endforelse
        </div>

        {{-- ✅ ページネーション --}}
        @if ($products->lastPage() > 1)
        <div class="pagination">
            {{-- 前へ --}}
            @if ($products->onFirstPage())
            <span class="page-link disabled">&lt;</span>
            @else
            <a href="{{ $products->previousPageUrl() }}" class="page-link">&lt;</a>
            @endif

            {{-- ページ番号 --}}
            @for ($i = 1; $i <= $products->lastPage(); $i++)
                @if ($i == $products->currentPage())
                <span class="page-link active">{{ $i }}</span>
                @else
                <a href="{{ $products->url($i) }}" class="page-link">{{ $i }}</a>
                @endif
                @endfor

                {{-- 次へ --}}
                @if ($products->hasMorePages())
                <a href="{{ $products->nextPageUrl() }}" class="page-link">&gt;</a>
                @else
                <span class="page-link disabled">&gt;</span>
                @endif
        </div>
        @endif

    </section>
</div>
@endsection