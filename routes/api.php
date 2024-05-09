<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\HospitalController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [ApiController::class, 'authenticate']);
Route::post('register', [ApiController::class, 'register']);
Route::get('hospital', [HospitalController::class, 'index']);
Route::post('hospital', [HospitalController::class, 'create']);
Route::patch('hospital/{id}', [HospitalController::class, 'update']);
Route::delete('hospital/{id}', [HospitalController::class, 'destroy']);
Route::get('hospital/{id}', [HospitalController::class, 'show']);
Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('logout', [ApiController::class, 'logout']);
    Route::get('getuser', [ApiController::class, 'get_user']);
    /**
      * Silahkan tambahkan route anda disini ...
    */
   
});