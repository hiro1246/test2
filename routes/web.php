<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products', [ProductController::class, 'index'])
    ->name('products.index');

Route::get('/products/{product}', [ProductController::class, 'show'])
    ->name('products.show');

Route::middleware('auth')->group(function () {
    Route::get('/products/create', [ProductController::class, 'create'])
        ->name('products.create');

    Route::post('/products/image/temp', [ProductController::class, 'uploadTemporaryImage'])
        ->name('products.image.temp.upload');

    Route::post('/products', [ProductController::class, 'store'])
        ->name('products.store');

    Route::get('/products/{product}/purchase', [ProductController::class, 'purchase'])
        ->name('products.purchase');

    Route::post('/products/{product}/purchase/complete', [ProductController::class, 'completePurchase'])
        ->name('products.purchase.complete');

    Route::get('/products/{product}/purchase/success', [ProductController::class, 'purchaseSuccess'])
        ->name('products.purchase.success');

    Route::get('/products/{product}/purchase/cancel', [ProductController::class, 'purchaseCancel'])
        ->name('products.purchase.cancel');

    Route::post('/products/{product}/purchase/image', [ProductController::class, 'updatePurchaseImage'])
        ->name('products.purchase.image.update');

    Route::get('/products/{product}/purchase/destination', [ProductController::class, 'purchaseDestination'])
        ->name('products.purchase.destination');

    Route::post('/products/{product}/purchase/destination', [ProductController::class, 'updatePurchaseDestination'])
        ->name('products.purchase.destination.update');

    Route::post('/products/{product}/comments', [ProductController::class, 'storeComment'])
        ->name('products.comments.store');

    Route::post('/products/{product}/favorite', [ProductController::class, 'toggleFavorite'])
        ->name('products.favorites.toggle');

    Route::get('/profile/setup', [ProfileController::class, 'edit'])
        ->name('profile.setup');
    Route::post('/profile/setup', [ProfileController::class, 'update'])
        ->name('profile.setup.update');
    Route::get('/profile', [ProfileController::class, 'show'])
        ->name('profile.show');
});

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (Request $request, string $id, string $hash) {
    $user = User::findOrFail($id);

    abort_unless(hash_equals($hash, sha1($user->getEmailForVerification())), 403);

    if (! $user->hasVerifiedEmail() && $user->markEmailAsVerified()) {
        event(new Verified($user));
    }

    Auth::login($user);
    $request->session()->regenerate();

    return redirect()->route('profile.setup');
})->middleware('signed')->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', '確認メールを再送しました。');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/setup', function () {
    if (Auth::check()) {
        Auth::logout();
    }

    return redirect()->route('login.show');
})->name('setup');

Route::get('/register', [RegisterController::class, 'show'])
    ->name('register.show');

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])
        ->name('login.show');
    Route::post('/login', [LoginController::class, 'store'])
        ->name('login.store');

    Route::post('/register', [RegisterController::class, 'store'])
        ->name('register.store');
});
