<?php

use App\Http\Controllers\JiraController;
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

//    return redirect()->route('voyager.dashboard');
});

Route::get('/test/{projectKey}', [SprintController::class, 'fetchSprints']);
Route::get('/slack', [SprintController::class, 'createThread']);

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    Route::get('/export/sprints/{id}', [SprintController::class, 'export'])->name('sprints.export');
    Route::get('/jira/sprints', [JiraController::class, 'allSprints'])->name('jira.all.sprints');
    Route::get('/jira/sprint/{jiraSprintId}', [JiraController::class, 'getSprint'])->name('jira.detail.sprint');
    Route::post('/jira/create/sprint', [JiraController::class, 'createSprint'])->name('jira.create.sprint');
});

