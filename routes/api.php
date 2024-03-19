<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\CommentsController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Middleware\CorsMiddleware;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



//User
Route::get('/User', [UserController::class, 'list']);
Route::get('/User/{id}', [UserController::class, 'id']);
Route::post('/User', [UserController::class, 'create']);
Route::post('/User', [UserController::class, 'update']);


//Auth
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

//Games
Route::get('/Game', [GameController::class, 'game']);
Route::get('/Game/{id}', [GameController::class, 'gameid'] );



//Comments
Route::get('/Comment', [CommentsController::class, 'comments']);
Route::get('/Comment/{id_game}', [CommentsController::class, 'getCommentsByGameId']);


///Categorys
Route::get('/Category', [CategoryController::class, 'category']);
Route::get('/Category/{id}', [CategoryController::class, 'categoryId']);

//liks
Route::get('/likes', [LikeController::class, 'list']);


Route::middleware([CorsMiddleware::class])->group(function () {
    
    Route::post('/likes', [LikeController::class, 'store']);
    Route::post('/Game', [GameController::class, 'create']);
    Route::delete('/delet/{id}', [GameController::class, 'deleteGame']);
    Route::post('/Comment', [CommentsController::class, 'createComment']);
    Route::put('/update-profile', [AuthController::class, 'updateProfile']);
    Route::get('/user-data', [AuthController::class, 'user']);


    

});




