<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProfileController;
use App\Models\Person;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    $people = Person::query()->select('public_id', 'name', 'phone', 'email', 'document', 'created_at')->get();

    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'people' => $people,
    ]);
})->name('/');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::controller(PersonController::class)->prefix('people')->group(function () {
    Route::post('/', 'store')->name('people.store');
    Route::get('/{personPublicId}', 'show')->name('people.show');
    Route::put('/{personPublicId}', 'update')->name('people.update');
});

Route::controller(AddressController::class)->prefix('addresses')->group(function () {
    Route::put('/{address}', 'update')->name('addresses.update');
});

require __DIR__.'/auth.php';
