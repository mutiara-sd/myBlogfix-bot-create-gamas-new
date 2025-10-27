<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

// Controllers
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlertPengawalanHsiImportController;
use App\Http\Controllers\Assurance\Bot\BotCreateGamasController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TelegramOTPController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\MinuteController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskProgressController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\MinuteDecisionController;
use App\Http\Controllers\AgendaController;

// Middleware
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\EnsureAuthenticated;
use App\Http\Middleware\EnsureLogin;


/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware([EnsureAuthenticated::class])->group(function () {

    // Redirect root to dashboard
    Route::get('/', fn() => redirect()->route('dashboard'));

    Route::get('/dashboard', fn() => view('dashboard', ['title' => 'Dashboard']))->name('dashboard');

    // Static pages
    Route::view('/calendar', 'app-calendar', ['title' => 'Calendar']);
    Route::view('/chat', 'chat', ['title' => 'Chat']);
    Route::view('/inbox-mail', 'inbox-email', ['title' => 'Inbox']);
    Route::view('/read-email', 'read-email', ['title' => 'Read Email']);
    Route::view('/invoices-list', 'invoices-list', ['title' => 'Invoices List']);
    Route::view('/invoices-detail', 'invoices-detail', ['title' => 'Invoices Detail']);
    Route::view('/contact', 'contact', ['title' => 'Contact']);

    // Profile
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update']);

    // Theme
    Route::get('/get-theme', [ThemeController::class, 'getTheme']);
    Route::post('/save-theme', [ThemeController::class, 'saveTheme'])->name('save.theme');

    // Admin Area
    Route::middleware([AdminMiddleware::class])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    });

    // Menu Management
    Route::post('/menus/store', [MenuController::class, 'store'])->name('menus.store');
    Route::put('/menus/update', [MenuController::class, 'update'])->name('menus.update');
    Route::delete('/menus/delete', [MenuController::class, 'destroy'])->name('menus.destroy');

    // Bot & Alert
    Route::get('/bot-create-gamas', [BotCreateGamasController::class, 'botCreateGamas'])->name('botCreateGamas');
    Route::get('/alert-pengawalan-hsi-import', [AlertPengawalanHsiImportController::class, 'alertPengawalanHsiImport'])->name('alertPengawalanHsiImport');
});


/*
|--------------------------------------------------------------------------
| LOGIN & REGISTRATION ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware([EnsureLogin::class])->group(function () {
    Route::get('/signin', [LoginController::class, 'LoginForm'])->name('signin');
    Route::post('/signin', [LoginController::class, 'auth']);
    Route::post('/signout', [LoginController::class, 'logout']);

    Route::get('/signup', [RegisterController::class, 'RegisterForm'])->name('signup');
    Route::post('/signup', [RegisterController::class, 'DataRegister']);

    Route::get('/otp', [TelegramOTPController::class, 'index'])->name('verifyotp');
    Route::post('/otp/send', [TelegramOTPController::class, 'sendOtp'])->name('otp.send');
    Route::post('/otp/verify', [TelegramOTPController::class, 'verifyOtp'])->name('otp.verify');
});

Route::get('/refresh-captcha', [LoginController::class, 'reloadCaptcha']);


/*
|--------------------------------------------------------------------------
| TELEGRAM WEBHOOK
|--------------------------------------------------------------------------
*/
Route::post('/telegram/webhook', function (Request $request) {
    $update = $request->all();

    if (isset($update['message'])) {
        $from = $update['message']['from'];
        $chatId = $from['id'];
        $firstName = $from['first_name'] ?? '';
        $username = $from['username'] ?? '';

        $text = "Halo {$firstName} 👋\n\n".
                "Telegram ID kamu: `{$chatId}`\n".
                "Username: @{$username}";

        Http::post("https://api.telegram.org/bot" . env('TELEGRAM_BOT_TOKEN') . "/sendMessage", [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'Markdown'
        ]);
    }

    return response('ok', 200);
});


/*
|--------------------------------------------------------------------------
| PROJECT, MEETING, MINUTES & RELATED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // PROJECT
    Route::resource('projects', ProjectController::class);
    Route::patch('projects/{project}/archive', [ProjectController::class, 'archive'])->name('projects.archive');
    Route::patch('projects/{project}/activate', [ProjectController::class, 'activate'])->name('projects.activate');

    // API-like routes (AJAX)
    Route::prefix('api/projects')->name('api.projects.')->group(function () {
        Route::get('/', [ProjectController::class, 'index']);
        Route::post('/', [ProjectController::class, 'store']);
        Route::get('{project}', [ProjectController::class, 'show']);
        Route::patch('{project}', [ProjectController::class, 'update']);
        Route::delete('{project}', [ProjectController::class, 'destroy']);
        Route::patch('{project}/archive', [ProjectController::class, 'archive']);
        Route::patch('{project}/activate', [ProjectController::class, 'activate']);
    });

    // MEETING
    Route::resource('meetings', MeetingController::class);
    
    // MINUTES (Decision)
    Route::resource('minutes', MinuteController::class)
        ->only(['show', 'create', 'store', 'edit', 'update']);

    Route::post('/meetings/{meeting}/decisions', [MinuteDecisionController::class, 'store'])
        ->name('decisions.store');
    Route::delete('/decisions/{decision}', [MinuteDecisionController::class, 'destroy'])
        ->name('decisions.destroy');
    Route::put('/decisions/{decision}', [MinuteDecisionController::class, 'update'])
        ->name('decisions.update');

    // AGENDAS
    // (tanpa route GET karena semua tampil di meetings/index)
    Route::post('/meetings/{meeting}/agendas', [AgendaController::class, 'store'])
        ->name('agendas.store');
    Route::delete('/agendas/{agenda}', [AgendaController::class, 'destroy'])
        ->name('agendas.destroy');
    Route::put('/agendas/{agenda}', [AgendaController::class, 'update'])
        ->name('agendas.update');



    // TASKS, COMMENTS, ATTACHMENTS, REMINDERS
    Route::resource('tasks', TaskController::class);
    Route::post('tasks/{task}/progress', [TaskProgressController::class, 'store'])->name('tasks.progress.store');
    Route::post('comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('attachments', [AttachmentController::class, 'store'])->name('attachments.store');
    Route::post('reminders', [ReminderController::class, 'store'])->name('reminders.store');
});
