<?php
use SecTheater\Http\Route;
use App\Controllers\HomeController;
use App\Controllers\PostControllers;
// GET
Route::get("/",[HomeController::class,'index' ]);
Route::get("/login",[HomeController::class,'login']);
Route::get("/home",[HomeController::class,'index']);
Route::get("/items",[HomeController::class,'items']);
Route::get("/categorys",[HomeController::class,'Categorys']);
Route::get("/user",[HomeController::class,'user']);
Route::get("/orders",[HomeController::class,'orders']);
Route::get("/addorders",[HomeController::class,'Addorders']);
Route::get("/customers",[HomeController::class,'customers']);
Route::get("/expenses",[HomeController::class,'expenses']);
Route::get("/dashboard",[HomeController::class,'dashboard']);
Route::get("/brands",[HomeController::class,'brands']);
Route::get("/Accounts",[HomeController::class,'Accounts']);







// POST
Route::post("/info",[PostControllers::class,'info']);
Route::post("/App/User/",[PostControllers::class,'user']);
Route::post("/App/items",[PostControllers::class,'items']);
Route::post('/App/Login',[PostControllers::class,'Login']);
Route::post('/App/Category',[PostControllers::class,'Category']);
Route::post('/Add/Customers',[PostControllers::class,'customers']);
Route::post('/Add/Orders',[PostControllers::class,'Orders']);
Route::post('/App/expenses',[PostControllers::class,'expenses']);
Route::post('/App/handlers',[PostControllers::class,'handlers']);
Route::post('/App/brand',[PostControllers::class,'brand']);
Route::post('/App/Accounts',[PostControllers::class,'Accounts']);
Route::post('/App/AotuTatol',[PostControllers::class,'AotuTatol']);