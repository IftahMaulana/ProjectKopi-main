<?php

use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransaksiAdminController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserLoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [TransaksiController::class, 'index'])->name('home');



Route::GET('/register', function () {
    return view('pelanggan.page.register');
})->name('halaman.register');



Route::POST('/storePelanggan', [UserController::class, 'storePelanggan'])->name('storePelanggan');
Route::GET('/loginuser', [UserLoginController::class, 'showLoginForm'])->middleware('guest:user')->name('loginuser');
Route::POST('/login_pelanggan', [UserLoginController::class, 'loginUser'])->middleware('guest:user')->name('loginproses.pelanggan');

Route::get('/shop', [Controller::class, 'shop'])->name('shop');
Route::get('/contact', [Controller::class, 'contact'])->name('contact');

Route::put('/updateQty/{id}', [Controller::class, 'updateQty'])->name('updateQty');


Route::middleware('auth:user')->group(function () {
    Route::POST('/addTocart', [TransaksiController::class, 'addTocart'])->middleware('auth')->name('addTocart');
    Route::get('/transaksi', [Controller::class, 'transaksi'])->name('transaksi');
    Route::get('/checkout', [Controller::class, 'checkout'])->name('checkout');
    Route::post('/checkout/proses', [Controller::class, 'prosesCheckout'])->name('checkout.product');
    // route batal checkout
    Route::get('/checkout/cancel', [Controller::class, 'cancelCheckout'])->name('cancel.checkout');

    
    Route::post('/checkout/prosesPembayaran', [Controller::class, 'prosesPembayaran'])->name('checkout.bayar');
    Route::get('/checkOut/{id}', [Controller::class, 'bayar'])->name('keranjang.bayar');
    Route::delete('/deleteFromCart/{id}', [TransaksiController::class, 'deleteFromCart'])->name('deleteFromCart');
    Route::GET('/logout_pelanggan', [UserLoginController::class, 'logout'])->name('logout.pelanggan');
    Route::post('/update-transaction-status', [TransaksiController::class, 'updateStatus']);
});







Route::get('/admin', [AdminLoginController::class, 'showLoginForm'])->middleware('guest:admin')->name('login');
Route::POST('/admin/loginProses', [AdminLoginController::class, 'loginAdmin'])->middleware('guest:admin')->name('loginProses');


Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/dashboard', [Controller::class, 'admin'])->name('admin');
    Route::get('/admin/product', [ProductController::class, 'index'])->name('product');
    Route::get('/admin/logout', [AdminLoginController::class, 'logout'])->name('logout');
    Route::get('/admin/addModal', [ProductController::class, 'addModal'])->name('addModal');

    Route::GET('/admin/user_management', [UserController::class, 'index'])->name('userManagement');
    Route::GET('/admin/user_management/addModalUser', [UserController::class, 'addModalUser'])->name('addModalUser');
    Route::POST('/admin/user_management/addData', [UserController::class, 'store'])->name('addDataUser');
    Route::get('/admin/user_management/editUser/{id}', [UserController::class, 'show'])->name('showDataUser');
    Route::PUT('/admin/user_management/updateDataUser/{id}', [UserController::class, 'update'])->name('updateDataUSer');
    Route::DELETE('/admin/user_management/deleteUSer/{id}', [UserController::class, 'destroy'])->name('destroyDataUser');

    Route::POST('/admin/addData', [ProductController::class, 'store'])->name('addData');
    Route::GET('/admin/editModal/{id}', [ProductController::class, 'show'])->name('editModal');
    Route::PUT('/admin/updateData/{id}', [ProductController::class, 'update'])->name('updateData');
    Route::DELETE('/admin/deleteData/{id}', [ProductController::class, 'destroy'])->name('deleteData');

    Route::GET('/admin/transaksi', [TransaksiAdminController::class, 'index'])->name('transaksi.admin');

    Route::delete('/transaksi/{id}', [TransaksiAdminController::class, 'destroy'])->name('transaksi.hapus');

});
