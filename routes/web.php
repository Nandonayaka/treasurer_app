<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [ClassroomController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('classrooms', ClassroomController::class);
    Route::post('/classrooms/{classroom}/next-period', [ClassroomController::class, 'nextPeriod'])->name('classrooms.next-period');
    Route::get('/classrooms/{classroom}/history', [ClassroomController::class, 'history'])->name('classrooms.history');
    
    Route::resource('transactions', TransactionController::class);
    Route::post('/members', [MemberController::class, 'store'])->name('members.store');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // PDF Routes
    Route::get('/transactions/{transaction}/receipt', [PdfController::class, 'downloadReceipt'])->name('pdf.receipt');
    Route::get('/classrooms/{classroom}/history-pdf', [PdfController::class, 'downloadHistory'])->name('pdf.history');
});

require __DIR__.'/auth.php';
