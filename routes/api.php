<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
//API route for register new user
Route::post('/register', [App\Http\Controllers\API\AuthController::class, 'register']);
//API route for login user
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::get('roles', [App\Http\Controllers\API\RolePermissionController::class,'getAllRole'])->name('roles');
Route::get('permissions', [App\Http\Controllers\API\RolePermissionController::class,'getAllPermission'])->name('permission');
Route::post('role-permission', [App\Http\Controllers\API\RolePermissionController::class,'getRolePermission'])->name('role_permission');
Route::post('set-role-permission', [App\Http\Controllers\API\RolePermissionController::class,'setRolePermission'])->name('set_role_permission');
Route::post('set-role-user', [App\Http\Controllers\API\RolePermissionController::class,'setRoleUser'])->name('user.set_role');

Route::get('user-authenticated', [App\Http\Controllers\UserController::class,'getUserLogin'])->name('user.authenticated');
Route::get('user-lists', [App\Http\Controllers\UserController::class,'userLists'])->name('user.index');
Route::group(['middleware' => 'auth:api'], function() {
    Route::resource('/article', ArticleController::class)->except(['show']);
});
//Protecting Routes
// Route::group(['middleware' => ['auth:sanctum','auth']], function () {
//     Route::get('/profile', function(Request $request) {
//         return auth()->user();
//     });

//     Route::resource('/article', ArticleController::class);
//     // API route for logout user
//     Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);
// });
