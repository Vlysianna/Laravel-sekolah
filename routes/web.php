    <?php

    use App\Http\Controllers\HomeController;
    use App\Http\Controllers\LoginController;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\VoucherController;

    // Route::get('/', function () {
    //     return view('welcome');
    // });

    Route::get('/', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'actionLogin'])->name('actionLogin');

    Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');
    Route::get('/logout', [LoginController::class, 'actionLogout'])->name('actionLogout')->middleware('auth');

    Route::get('/buy/{productName}', [HomeController::class, 'buy'])->name('buy')->middleware('auth');

    Route::get('/register', [LoginController::class, 'register'])->name('register');
    Route::post('/create', [LoginController::class, 'create'])->name('create');

    Route::get('/forgot-password', [LoginController::class, 'showForgotPassword'])->name('forgot.password');
    Route::post('/forgot-password', [LoginController::class, 'sendResetLink'])->name('forgot.password.send');
    Route::get('/reset-password/{token}', [LoginController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [LoginController::class, 'resetPassword'])->name('password.update');