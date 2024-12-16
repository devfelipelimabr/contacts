<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserController;

// Rotas protegidas por autenticação
Route::middleware('auth')->group(function () {
    // Redirecionar a rota raiz para a home
    Route::redirect('/', 'home');

    // Página inicial (Home)
    Route::view('/home', 'home')->name('home');

    // Rotas para o CRUD de contatos
    Route::resource('contacts', ContactController::class);
    Route::post('/contacts/store', [ContactController::class, 'store'])->name('contacts.store');

    
    // Rotas administrativas
    Route::middleware('can:admin')->group(function () {
        Route::resource('users', UserController::class)
            ->except(['show'])
            ->names([
                'index' => 'users',
                'store' => 'users.store',
                'update' => 'users.update',
                'destroy' => 'users.destroy',
            ]);
        Route::patch('users/{user}/status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    });
});
