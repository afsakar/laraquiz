<?php

use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\QuizController;

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

Route::group(['middleware' => 'auth'], function (){
   Route::get('dashboard', [MainController::class, 'dashboard'])->name('dashboard');
   Route::get('quiz/detail/{slug}', [MainController::class, 'quizDetail'])->name('quiz.detail');
   Route::get('quiz/{slug}', [MainController::class, 'quizJoin'])->name('quiz.join');
   Route::post('quiz/{slug}/result', [MainController::class, 'quizResult'])->name('quiz.result');
});

Route::group(['middleware' => ['auth', 'AdminCheck'], 'prefix' => 'admin',], function () {
    /* Quiz Route */
    Route::get('quizzes/{id}', [QuizController::class, 'destroy'])->whereNumber('id')->name('quizzes.destroy');
    Route::get('quizzes/{id}/detail', [QuizController::class, 'show'])->whereNumber('id')->name('quizzes.detail');
    Route::resource('quizzes', QuizController::class);

    /* Question Route */
    Route::get('quiz/{quiz_id}/questions/{id}', [QuestionController::class, 'destroy'])->whereNumber('id')->name('questions.destroy');
    Route::get('quiz/{quiz_id}/questions/{id}', [QuestionController::class, 'deleteImage'])->whereNumber('id')->name('questions.deleteImage');
    Route::resource('quiz/{quiz_id}/questions', QuestionController::class)->whereNumber('quiz_id');
});
