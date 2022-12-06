<?php
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\KorisnikController;
use App\Http\Controllers\DateRangeController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::get('/',[FrontendController::class, 'index']);
Route::get('/gallery',[FrontendController::class, 'galerija']);
Route::get('/searchjs', [FrontendController::class, 'searchjs'])->name('searchjs');

Route::group(['middleware' => 'admin'], function() {

    Route::get('/order/destroy/{id}',[CartController::class, 'destroy']);

    Route::get('/order/send/{id}',[CartController::class, 'send'])->name('salji');
    // Upravljanje korisnicima


    Route::post('/users/store', [KorisnikController::class, 'store']);
    Route::get('/logs', [FrontendController::class, 'showlogs']);
    Route::get('/flogs', [DateRangeController::class, 'index']);

    Route::get('/users/destroy/{id}',[KorisnikController::class, 'destroy']);


});

Route::group(['middleware' => 'user'], function() {
    Route::get('/users/{id?}', [KorisnikController::class, 'show']);
    Route::post('/users/update/{id}',[KorisnikController::class, 'update']);
    Route::get('/posts/{id?}', [PostController::class, 'postshow']);
    Route::put('/posts/store', [PostController::class, 'store']);
    Route::put('/posts/update/{id}',[PostController::class, 'update']);
    Route::get('/posts/destroy/{id}',[PostController::class, 'destroy']);

    /*
    Rute za upravljanje komentarima
*/
    Route::get("/commentsjs/{sid}/{keyword}", [CommentsController::class, 'postCommentjs'])->name("postCommentjs");
    Route::post("/comments/{postId}", [CommentsController::class, 'postComment'])->name("postComment");
    Route::post("/post/{postId}/comments/{commentId?}", [CommentsController::class, 'editComment'])->name("editComment");
    Route::get("/comments/{commentId}/delete", [CommentsController::class, 'deleteComment'])->name("deleteComment");
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

});
Route::get("/search", [\App\Http\Controllers\FrontendController::class, "trazi"])->name("searchs");

Route::post("/cart", [\App\Http\Controllers\CartController::class, "index"]);
Route::get("/cart", [\App\Http\Controllers\CartController::class, "get"])->name("get-cart");
Route::post("/cart/adjustQuantity", [\App\Http\Controllers\CartController::class, "adjustQuantity"]);
Route::delete("/cart/{postId}", [\App\Http\Controllers\CartController::class, "remove"]);
Route::post("/checkout", [\App\Http\Controllers\CheckoutController::class, "index"]);
Route::get("/my-orders", [\App\Http\Controllers\CartController::class, "myOrders"])->name("my-orders");

Route::get('contact-us',[ContactUsController::class, 'index']);
Route::post('contact-us',[ContactUsController::class, 'handleForm']);




// Logovanje

Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/register', [KorisnikController::class, 'regshow']);
Route::post('/register/store', [KorisnikController::class, 'regstore']);

Route::get('/postjs/{id}',[FrontendController::class, 'getPostjs']);

Route::get('/post/{id}',[FrontendController::class, 'getPost']);

