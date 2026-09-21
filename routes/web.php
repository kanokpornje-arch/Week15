<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\HomeController;
use App\Models\Blog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;

Route::get('/', [BlogController::class, 'index'])->name('home');
Route::get('/detail/{id}', [BlogController::class, 'detail'])->name('detail');

Route::get('/about', fn() => view('about', [
    'name' => 'Kanokporn Jeamthong',
    'date' => '5 กรกฎาคม 2026',
]))->name('about');

Route::get('/blog', function () {
    $blog = Blog::where('status', true)->latest()->get();

    return view('blog', compact('blog'));
})->name('blog');

Route::prefix('author')->name('author.')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/about', [AdminController::class, 'about2'])->name('about');
    Route::get('/blog', [AdminController::class, 'blog2'])->name('blog');
    Route::get('/create', [AdminController::class, 'form'])->name('create');
    Route::post('/insert', [AdminController::class, 'insert'])->name('store');
    Route::patch('/blog/{blog}', [AdminController::class, 'update'])->name('update');
    Route::get('/blog/{blog}/edit', [AdminController::class, 'edit'])->name('edit');
    Route::patch('/blog/{blog}/status', [AdminController::class, 'change'])->name('status');
    Route::delete('/blog/{blog}', [AdminController::class, 'delete'])->name('delete');
    Route::get('/claim', [ClaimController::class, 'create'])->name('claim.create');
    Route::post('/claim/store', [ClaimController::class, 'store'])->name('claim.store');
});

Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();

        return 'เชื่อมต่อฐานข้อมูลสำเร็จ : ' . DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        return 'ไม่สามารถเชื่อมต่อฐานข้อมูลได้: ' . $e->getMessage();
    }
});

Auth::routes();
