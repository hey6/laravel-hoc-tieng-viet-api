<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\PhrasebookController;
use App\Http\Controllers\PhrasebookCategoryController;
use App\Http\Controllers\Discussion\DiscussionController;
use App\Http\Controllers\Discussion\TopicController;
use App\Http\Controllers\Discussion\ReplyController;
use App\Http\Controllers\Discussion\FavoriteDiscussionController;
use App\Http\Controllers\Discussion\FavoriteReplyController;
use App\Http\Controllers\FavoritePhrasebookController;

/*
|---------------------------------------------------------------------------------
| API Routes
|---------------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
|--------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------
*/
Route::prefix('/auth')->group(function() {
    Route::post('/register', RegisterController::class)->name('register');
    Route::post('/login', LoginController::class)->name('login');
    Route::post('/logout', LogoutController::class)->name('logout');
});

/*
|--------------------------------------------------------
| A User Routes
|--------------------------------------------------------
*/
Route::get('/user', UserController::class)->name('user');

/*
|--------------------------------------------------------
| Phrasebook Routes
|--------------------------------------------------------
*/
Route::name('phrasebook.')->group(function() {
    Route::prefix('/phrasebook')->group(function() {
        Route::apiResource('/category', PhrasebookCategoryController::class);
        /** Favorite phrasebook */
        Route::post('/favorite/{phrasebook}', [FavoritePhrasebookController::class, 'store'])
            ->name('favorite.store');
        Route::delete('/favorite/{phrasebook}', [FavoritePhrasebookController::class, 'destroy'])
            ->name('favorite.destroy');
    });
});
Route::apiResource('/phrasebook', PhrasebookController::class)
    ->except(['show']);

/*
|--------------------------------------------------------
| Discussion/Thread Routes
|--------------------------------------------------------
*/
Route::name('discussion.')->group(function() {
    Route::prefix('/discussion')->group(function() {
        Route::apiResource('/topic', TopicController::class);
        Route::apiResource('{discussion}/reply', ReplyController::class)
            ->except(['index', 'show']);
        /** Favorite discussion */
        Route::post('/favorite/{discussion}', [FavoriteDiscussionController::class, 'store'])
            ->name('favorite.store');
        Route::delete('/favorite/{discussion}', [FavoriteDiscussionController::class, 'destroy'])
            ->name('favorite.destroy');
        /** Favorite reply */
        Route::post('/reply/favorite/{reply}', [FavoriteReplyController::class, 'store'])
            ->name('reply.favorite.store');
        Route::delete('/reply/favorite/{reply}', [FavoriteReplyController::class, 'destroy'])
            ->name('reply.favorite.destroy');
    });
});
Route::apiResource('/discussion', DiscussionController::class);