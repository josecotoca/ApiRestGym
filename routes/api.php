<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\ReceiptController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Login
 */
Route::middleware(['throttle:login'])->group(function () {
    Route::post('login', [LoginController::class, 'login']);
});

/**
 * Register
 */
Route::post('register', [RegisterController::class, 'register']);

$router->group(['prefix' => 'customers'], function () use ($router) {
    $router->post('/', [CustomerController::class, 'register']);
    $router->get('/{id}', [CustomerController::class, 'find']);
    $router->patch('/{id}', [CustomerController::class, 'update']);
    $router->delete('/{id}', [CustomerController::class, 'remove']);
    $router->get('/paginated/{perPage}', [CustomerController::class, 'paginate']);
})->middleware(['auth:sanctum']);

$router->group(['prefix' => 'coupons'], function () use ($router) {
    $router->post('/', [CouponController::class, 'register']);
    $router->get('/{id}', [CouponController::class, 'find']);
    $router->patch('/{id}', [CouponController::class, 'update']);
    $router->delete('/{id}', [CouponController::class, 'remove']);
    $router->get('/paginated/{perPage}', [CouponController::class, 'paginate']);
})->middleware(['auth:sanctum']);

$router->group(['prefix' => 'memberships'], function () use ($router) {
    $router->post('/', [MembershipController::class, 'register']);
    $router->get('/{id}', [MembershipController::class, 'find']);
    $router->patch('/{id}', [MembershipController::class, 'update']);
    $router->delete('/{id}', [MembershipController::class, 'remove']);
    $router->get('/paginated/{perPage}', [MembershipController::class, 'paginate']);
})->middleware(['auth:sanctum']);

$router->group(['prefix' => 'instructors'], function () use ($router) {
    $router->post('/', [InstructorController::class, 'register']);
    $router->post('/registerbyperson', [InstructorController::class, 'registerByPerson']);
    $router->get('/{id}', [InstructorController::class, 'find']);
    $router->patch('/{id}', [InstructorController::class, 'update']);
    $router->delete('/{id}', [InstructorController::class, 'remove']);
    $router->get('/paginated/{perPage}', [InstructorController::class, 'paginate']);
})->middleware(['auth:sanctum']);

$router->group(['prefix' => 'contracts'], function () use ($router) {
    $router->post('/', [ContractController::class, 'register']);
    $router->post('/receipt/{id}', [ContractController::class, 'register']);
    $router->get('/{id}', [ContractController::class, 'find']);
    $router->patch('/{id}', [ContractController::class, 'update']);
    $router->delete('/{id}', [ContractController::class, 'remove']);
    $router->get('/paginated/{perPage}', [ContractController::class, 'paginate']);
})->middleware(['auth:sanctum']);

$router->group(['prefix' => 'receipts'], function () use ($router) {
    $router->post('/contract/{idContract}', [ReceiptController::class, 'register']);
    $router->get('/{id}', [ReceiptController::class, 'find']);
    $router->patch('/{id}', [ReceiptController::class, 'update']);
    $router->delete('/{id}', [ReceiptController::class, 'remove']);
    $router->get('/paginated/{perPage}', [ReceiptController::class, 'paginate']);
})->middleware(['auth:sanctum']);

$router->group(['prefix' => 'courses'], function () use ($router) {
    $router->post('/', [CourseController::class, 'register']);
    $router->get('/{id}', [CourseController::class, 'find']);
    $router->patch('/{id}', [CourseController::class, 'update']);
    $router->delete('/{id}', [CourseController::class, 'remove']);
    $router->get('/paginated/{perPage}', [CourseController::class, 'paginate']);
});

$router->group(['prefix' => 'entries'], function () use ($router) {
    $router->post('/', [EntryController::class, 'register']);
    $router->get('/paginated/{perPage}', [EntryController::class, 'paginate']);
})->middleware(['auth:sanctum']);


