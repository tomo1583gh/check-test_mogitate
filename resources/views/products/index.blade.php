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
        <a href="{{ route('products.create') }}" class="btn-add">＋商品を追加</a>

        <div class="product-grid">
            @forelse ($products as $product)
            <a href="{{ route('products.show', $product->id) }}" class="product-card">
                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}">
                <h3>{{ $product->name }}</h3>
                <p>¥{{ number_format($product->price) }}</p>

                {{-- ✅ 季節の表示 --}}
                <div class="season-tags">
                    @foreach (json_decode($product->season ?? '[]', true) as $season)
                        <span class="season-label">{{ $season }}</span>
                    @endforeach

                </div>
            </a>
            @empty
            <p>商品が見つかりませんでした。</p>
            @endforelse
        </div>

        {{-- ✅ ページネーション --}}
        <div class="pagination">
            {{ $products->links() }}
        </div>
    </section>
</div>
@endsection