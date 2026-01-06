<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HabitController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\HabitManagementController;
use App\Http\Controllers\Admin\QuestManagementController;
use App\Http\Controllers\Admin\UserManagementController;
use Illuminate\Support\Facades\Route;




Route::get('/', [HomeController::class, 'index'])->name('home');


Route::middleware(['auth', 'verified'])->prefix('user')->group(function () {

    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    
    Route::prefix('habits')->name('habits.')->group(function () {
        Route::get('/', [HabitController::class, 'index'])->name('index');
        Route::post('/', [HabitController::class, 'store'])->name('store');
        Route::put('/{habit}', [HabitController::class, 'update'])->name('update');
        Route::patch('/{habit}/toggle', [HabitController::class, 'toggle'])->name('toggle');
        Route::delete('/{habit}', [HabitController::class, 'destroy'])->name('destroy');
    });

    
    Route::prefix('quests')->name('quests.')->group(function () {
        Route::get('/', [QuestController::class, 'index'])->name('index');
        Route::post('/', [QuestController::class, 'store'])->name('store');
        Route::put('/{quest}', [QuestController::class, 'update'])->name('update');
        Route::patch('/{quest}/complete', [QuestController::class, 'complete'])->name('complete');
        Route::delete('/{quest}', [QuestController::class, 'destroy'])->name('destroy');
    });

});


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('index');
        Route::get('/{user}', [UserManagementController::class, 'show'])->name('show');
        Route::put('/{user}', [UserManagementController::class, 'update'])->name('update');
        Route::patch('/{user}/toggle-ban', [UserManagementController::class, 'toggleBan'])->name('toggle-ban');
        Route::delete('/{user}', [UserManagementController::class, 'destroy'])->name('destroy');
    });

    
    Route::prefix('habits')->name('habits.')->group(function () {
        Route::get('/', [HabitManagementController::class, 'index'])->name('index');
        Route::get('/{habit}', [HabitManagementController::class, 'show'])->name('show');
        Route::put('/{habit}', [HabitManagementController::class, 'update'])->name('update');
        Route::delete('/{habit}', [HabitManagementController::class, 'destroy'])->name('destroy');
    });

    
    Route::prefix('quests')->name('quests.')->group(function () {
        Route::get('/', [QuestManagementController::class, 'index'])->name('index');
        Route::get('/{quest}', [QuestManagementController::class, 'show'])->name('show');
        Route::put('/{quest}', [QuestManagementController::class, 'update'])->name('update');
        Route::delete('/{quest}', [QuestManagementController::class, 'destroy'])->name('destroy');
    });

});

require __DIR__.'/auth.php';
