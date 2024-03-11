<?php

use App\Http\Controllers\RecipeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//user authentication
Route::post('/create',[UserController::class,'store']);
Route::get('/all',[UserController::class,'all']);
Route::post('/check',[UserController::class,'authenticate']);

//recipes
Route::post('/create-recipe',[RecipeController::class,'storeRecipe']);
Route::get('/all-recipe',[RecipeController::class,'index']);
Route::put('/edit-recipe/{id}',[RecipeController::class,'editRecipe']);
Route::delete('delete/{id}',[RecipeController::class,'deleteRecipe']);
//with views
Route::get('/show/{id}',[RecipeController::class,'showRecipe']);

//category
Route::get('/breakfast',[RecipeController::class,'breakfastCategory']);
Route::get('/lunch',[RecipeController::class,'lunchCategory']);
Route::get('/dinner',[RecipeController::class,'dinnerCategory']);
Route::get('/snacks',[RecipeController::class,'snackCategory']);

//most-recent
Route::get('/recent',[RecipeController::class,'recentRecipe']);
// most-viewed
Route::get('/views',[RecipeController::class,'mostViewed']);
