<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SprintController;
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
    return redirect()->route('voyager.dashboard');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    Route::get('/export/sprints/{id}', [SprintController::class, 'export'])->name('sprints.export');
});

