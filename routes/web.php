<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/* 商品一覧 */

Route::get('/products', [ProductController::class, 'index'])->name('products.index');

/* 商品登録 */
Route::get('/products/register', [ProductController::class, 'create'])->name('products.register');
Route::post('/products/register', [ProductController::class, 'store'])->name('products.store');

/* 商品詳細 */
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

/* 商品更新 */
Route::put('/products/{id}/update', [ProductController::class, 'update'])->name('products.update');

/* 検索 */
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

/* 削除 */
Route::delete('/products/{id}/delete', [ProductController::class, 'destroy'])->name('products.destroy');

/* TOPリダイレクト */
Route::get('/', function () {
    return redirect()->route('products.index');
});
