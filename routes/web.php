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
 * First lesson simple mysql and sqlite db queries to get before seeded users.
 */
Route::get('/1', [\App\Http\Controllers\LessonController::class, 'firstLesson']);

/**
 * Second lesson simple pdo, query builder and eloquent ORM queries examples
 */
Route::get('/2', [\App\Http\Controllers\LessonController::class, 'secondLesson']);

/**
 * DB transactions and events
 */
Route::get('/3', [\App\Http\Controllers\LessonController::class, 'thirdLesson']);
