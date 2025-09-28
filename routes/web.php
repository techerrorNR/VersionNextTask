<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use Illuminate\Console\View\Components\Task;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/records',        [TaskController::class, 'index'])->name('records.index');  
    Route::get('/records/data',   [TaskController::class, 'data'])->name('records.data'); 
    Route::get('/task/create',    [TaskController::class, 'create'])->name('task.create');   
    Route::post('/task/store',    [TaskController::class, 'store'])->name('task.store');   
    Route::get('/products/{product}/edit',   [TaskController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}',        [TaskController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}',     [TaskController::class, 'destroy'])->name('products.destroy');
});


require __DIR__.'/auth.php';
