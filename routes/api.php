<?php

    use App\Http\Controllers\Auth\AuthController;
    use App\Http\Controllers\Tasks\TaskController;
    use App\Http\Controllers\Tasks\UserController;
    use Illuminate\Support\Facades\Route;

    /*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
    */
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup');
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user-info', [AuthController::class, 'userInfo'])->name('userInfo');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::group(['prefix' => 'task'], function () {
        Route::get('index', [TaskController::class, 'index'])->name('task.index');
        Route::post('store', [TaskController::class, 'store'])->name('task.store');
        Route::delete('delete/{task}', [TaskController::class, 'delete'])->name('task.delete');
    });

});

