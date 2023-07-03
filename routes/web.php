<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ForumController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    // Forum gösterimi
    Route::get('/forum', [ForumController::class, 'show'])->name('forum.show');

    // Yeni forum oluşturma
    Route::post('/forum/create', [ForumController::class, 'create'])->name('forum.create');

    // Forum sorusu güncelleme
    Route::put('/forum/{id}', [ForumController::class, 'update'])->name('forum.update');

    // Forum sorusu silme
    Route::delete('/forum/{id}', [ForumController::class, 'delete'])->name('forum.delete');

    // Cevap ekleme
    Route::post('/forum/{questionId}/answer', [ForumController::class, 'answer'])->name('forum.answer');

    // Cevap güncelleme
    Route::put('/forum/answer/{answerId}', [ForumController::class, 'updateAnswer'])->name('forum.updateAnswer');

    // Cevap silme
    Route::delete('/forum/answer/{answerId}', [ForumController::class, 'deleteAnswer'])->name('forum.deleteAnswer');
});
