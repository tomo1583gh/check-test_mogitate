<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Season;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // 検索処理
        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        // 並び替え処理
        if ($request->sort === 'asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort === 'desc') {
            $query->orderBy('price', 'desc');
        }

        $products = $query->paginate(6)->appends($request->query());

        return view('products.index', [
            'products' => $products,
            'keyword' => $request->keyword,
            'sort' => $request->sort,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $seasons = Season::all();
        return view('products.register', compact('seasons'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        // ✅ season が未選択のときも空配列で扱う
        $validated['season'] = $request->input('season', []);

        // 画像保存
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $validated['image_path'] = $path;
        }

        // 商品保存
        $product = Product::create($validated);

        // 中間テーブルに季節を保存(多対多）
        $product->seasons()->sync($request->input('season', []));

        return redirect()->route('products.index')->with('success', '商品を登録しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $seasons = Season::all();
        return view('products.show', compact('product', 'seasons'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validated();

        // 画像をアップロードした場合のみ更新
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $data['image_path'] = $path;
        }

        $product->update($data);

        // 中間テーブルのseasonを更新（syncで差し替え）
        $product->seasons()->sync($request->input('season', []));

        return redirect()->route('products.index')->with('success', '商品を更新しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', '商品を削除しました');
    }
}
