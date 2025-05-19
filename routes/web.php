<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\TranslateController;
use App\Http\Controllers\FlashcardController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Translation Routes
    Route::resource('translations', TranslationController::class);
    
    // Translate API Routes
    Route::get('/translate', [TranslateController::class, 'index'])->name('translate.index');
    Route::post('/translate', [TranslateController::class, 'translate'])->name('translate.process');
    Route::post('/translate/save', [TranslateController::class, 'save'])->name('translate.save');
    
    // Translation Lists Routes
    Route::post('/translate/lists', [TranslateController::class, 'createList'])->name('translate.lists.create');
    Route::get('/translate/lists', [TranslateController::class, 'getLists'])->name('translate.lists.index');
    Route::get('/translate/lists/{list}', [TranslateController::class, 'showList'])->name('translate.lists.show');
    Route::patch('/translate/lists/{list}', [TranslateController::class, 'updateList'])->name('translate.lists.update');
    Route::delete('/translate/lists/{list}', [TranslateController::class, 'destroyList'])->name('translate.lists.destroy');
    
    // Flashcard Routes
    Route::get('/flashcards', [FlashcardController::class, 'index'])->name('flashcards.index');
    Route::post('/flashcards/start', [FlashcardController::class, 'start'])->name('flashcards.start');
    Route::post('/flashcards/update-status', [FlashcardController::class, 'updateStatus'])->name('flashcards.update-status');
    Route::post('/flashcards/study-unknown', [FlashcardController::class, 'studyUnknown'])->name('flashcards.study-unknown');
    Route::get('/flashcards/stats', [FlashcardController::class, 'stats'])->name('flashcards.stats');
});

require __DIR__.'/auth.php';
