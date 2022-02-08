<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

/**
 * Intro Routes
 */
Route::prefix('intro')->group(function() {
    /**
     * First lesson simple mysql and sqlite db queries to get before seeded users.
     */
    Route::get('/1', [\App\Http\Controllers\IntroLessonController::class, 'firstLesson']);

    /**
     * Second lesson simple pdo, query builder and eloquent ORM queries examples
     */
    Route::get('/2', [\App\Http\Controllers\IntroLessonController::class, 'secondLesson']);

    /**
     * DB transactions and events
     */
    Route::get('/3', [\App\Http\Controllers\IntroLessonController::class, 'thirdLesson']);

    /**
     * DB transactions and events
     */
    Route::get('/4', [\App\Http\Controllers\IntroLessonController::class, 'fourthLesson']);
});

/**
 * Query builder routes
 */
Route::prefix('q-builder')->group(function () {
    /**
     * Getting data.
     * Simple select, where clauses and aggregate functions.
     */
    Route::get('/1', [\App\Http\Controllers\QueryBuilderController::class, 'firstLesson']);

    /**
     * Advanced Where clause with operators
     */
    Route::get('/2', [\App\Http\Controllers\QueryBuilderController::class, 'secondLesson']);

    /**
     * Advanced Where clause with operators
     */
    Route::get('/3', [\App\Http\Controllers\QueryBuilderController::class, 'thirdLesson']);

    /**
     * Text search
     * Pagination
     * Row sql expression
     */
    Route::get('/4', [\App\Http\Controllers\QueryBuilderController::class, 'fourthLesson']);

    /**
     * Order group limit offset conditionals and chunks
     */
    Route::get('/5', [\App\Http\Controllers\QueryBuilderController::class, 'fifthLesson']);

    /**
     * Simple and advanced joins, union, insert, update, delete.
     */
    Route::get('/6', [\App\Http\Controllers\QueryBuilderController::class, 'sixthLesson']);
});


/**
 * Eloquent routes
 */
Route::prefix('eloquent')->group(function () {

    Route::get('/1', [\App\Http\Controllers\EloquentController::class, 'firstLesson']);

    /**
     * Collection and additional operations
     */
    Route::get('/2', [\App\Http\Controllers\EloquentController::class, 'secondLesson']);

    /**
     * Insert delete update data using eloquent
     */
    Route::get('/3', [\App\Http\Controllers\EloquentController::class, 'thirdLesson']);

    /**
     * One to One relationship eloquent hasOne belongsTo
     * One to Many relationship eloquent hasMany belongsTo
     */
    Route::get('/4', [\App\Http\Controllers\EloquentController::class, 'fourthLesson']);

    /**
     * Many-To-Many relationship eloquent belongsToMany - BelongsToMany
     * Has one through relationship eloquent
     * Has many through relationship
     */
    Route::get('/5', [\App\Http\Controllers\EloquentController::class, 'fifthLesson']);

    /**
     * Polymorphic database relationship
     * One to one poly relationship morphOne morphsTo
     */
    Route::get('/6', [\App\Http\Controllers\EloquentController::class, 'sixthLesson']);

    /**
     * Querying and counting relationships
     */
    Route::get('/7',[\App\Http\Controllers\EloquentController::class, 'seventhLesson']);

    /**
     * Insert update delete relationships
     */
    Route::get('/8',[\App\Http\Controllers\EloquentController::class, 'eighthLesson']);
});
