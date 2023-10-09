<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\User_addressController;
use App\Http\Controllers\API\PostsController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\AssetController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ShopController;
use App\Http\Controllers\API\Shop_addressController;
use App\Http\Controllers\API\PriceController;
use App\Http\Controllers\API\Working_daysController;
use App\Http\Controllers\API\Product_categoryController;
use App\Http\Controllers\API\holidaysController;
use App\Http\Controllers\API\DocumentController;

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

Route::get('users', [UserController::class, 'index']);
Route::get('users/{id}', [UserController::class, 'show']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);


/*Route::get('email/verify/{id}', 'VerificationApiController@verify')->name('verificationapi.verify');
Route::get('email/resend', 'VerificationApiController@resend')->name('verificationapi.resend');*/


Route::get('/login/{provider}', [AuthController::class,'redirectToProvider']);
Route::get('/login/{provider}/callback', [AuthController::class,'handleProviderCallback']);

Route::get('posts', [PostsController::class, 'index']);

Route::get('comments', [CommentController::class, 'index']);

Route::get('assets', [AssetController::class, 'index']);

Route::get('shops', [ShopController::class, 'index']);
Route::get('shops/{id}', [ShopController::class, 'show']);

Route::get('prices', [PriceController::class, 'index']);

Route::get('Working_days', [Working_daysController::class, 'index']);

Route::get('holidays', [holidaysController::class, 'index']);

Route::get('Product_category', [Product_categoryController::class, 'index']);

Route::get('Document', [DocumentController::class, 'index']);

Route::get('Code_vat', [Code_vatController::class, 'index']);

//Route user...
Route::middleware('auth:sanctum')->group(function (){

    //créé un post, update et delete
    Route::post('posts/create', [PostsController::class, 'store']);
    Route::put('posts/edit/{post}', [PostsController::class, 'update']);
    Route::delete('posts/{post}', [PostsController::class, 'delete']);
    
    //créé un commentaire, update, delete
    Route::post('comments/create', [CommentController::class, 'store']);
    Route::put('comments/edit/{comments}', [CommentController::class, 'update']);
    Route::delete('comments/{comments}', [CommentController::class, 'delete']);

    //créé un asset, update, delete
    Route::post('assets/create', [AssetController::class, 'store']);
    Route::put('assets/edit/{asset}', [AssetController::class, 'update']);
    Route::delete('assets/{asset}', [AssetController::class, 'delete']);

    //créé un prix, update, delete
    Route::post('prices/create', [PriceController::class, 'store']);
    Route::put('prices/edit/{price}', [PriceController::class, 'update']);
    Route::delete('prices/{price}', [PriceController::class, 'delete']);

    //créé un working_days, update, delete
    Route::post('working_days/create', [Working_daysController::class, 'store']);
    Route::put('working_days/edit/{days}', [Working_daysController::class, 'update']);
    Route::delete('working_days/{days}', [Working_daysController::class, 'delete']);

    //créé un holidays, update, delete
    Route::post('holidays/create', [holidaysController::class, 'store']);
    Route::put('holidays/edit/{holidays}', [holidaysController::class, 'update']);
    Route::delete('holidays/{holidays}', [holidaysController::class, 'delete']);

    //créé un product_category, update, delete
    Route::post('Product_category/create', [Product_categoryController::class, 'store']);
    Route::put('Product_category/edit/{Product_category}', [Product_categoryController::class, 'update']);
    Route::delete('Product_category/{Product_category}', [Product_categoryController::class, 'delete']);

    //créé un document
    Route::post('Document/create', [DocumentController::class, 'store']);

    //ajouté, updaté adresse utilisateur
    Route::post('user_address/create', [User_addressController::class, 'store']);
    Route::post('user_address/edit/{user_address}', [User_addressController::class, 'update']);
    Route::delete('user_address/{user_address}', [User_addressController::class, 'delete']);

    //ajouté, updaté adresse shop
    Route::post('shop_address/create', [Shop_addressController::class, 'store']);
    Route::put('shop_address/edit/{shop_address}', [Shop_addressController::class, 'update']);

    //ajouté shop, updaté shop
    Route::post('shop/create', [ShopController::class, 'store']);
    Route::post('shop/edit/{shop}', [ShopController::class, 'update']);

    Route::post('users/edit/{user}', [UserController::class, 'update']);

    //like Post route
    Route::post('posts/{post}/like', [LikeController::class, 'store']);
    Route::delete('posts/{post}/like', [LikeController::class, 'destroy']);

    //Retourner l'utilisateur actuellement connecté
    Route::get('/user', function (Request $request) {
    return $request->user()->load(['user_address', 'shop', 'shop_address']);
    });

});