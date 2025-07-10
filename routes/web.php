<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\DeployController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PasswordChangeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\DetectBrowserLocale;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ----------------------
// Laravel Authentication// Routes to redirect the user around the page

// ----------------------
Auth::routes(['register' => false]);

// Disable /register URL
Route::get('/register', function () {
    abort(404);
})->name('register');

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Home dashboard route
Route::get('/home', [HomeController::class, 'index'])->name('home');

// ----------------------
// Admin & Super Admin Only
// ----------------------
Route::middleware(['role:Admin|Super Admin'])->group(function () {

    // Roles and Users resource controllers
    Route::resources([
        'roles' => RoleController::class,
        'users' => UserController::class,
    ]);

    // User search & restore
    Route::get('/user-search', [UserController::class, 'search'])->name('users.search');
    Route::post('/users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');

    // Permissions: only index, store, destroy
    Route::resource('permissions',
        PermissionController::class)->only([
        'index', 'store', 'destroy'
    ]);

    // Deploy project
    Route::post('/deploy', [DeployController::class, 'deploy'])
        ->name('deploy');
});

// ----------------------
// Authenticated Users
// ----------------------
Route::middleware(['auth'])->group(function () {
    // Force password change
    Route::get('/password/change', [PasswordChangeController::class, 'showChangeForm'])->name('forcepassword.change');
    Route::post('/password/change', [PasswordChangeController::class, 'update'])->name('forcepassword.update');

    // User settings
    Route::get('/user', [SettingController::class, 'edit'])->name('userSettings.edit');
    Route::put('/user', [SettingController::class, 'update'])->name('userSettings.update');
});

// ----------------------
// Contacts (Permission: view-contact)
// ----------------------
Route::group(['middleware' => ['permission:view-contact']], function () {

    Route::get('/contacts', [ContactController::class, 'index'])
        ->name('contacts.index');

    Route::put('/create', [ContactController::class, 'store'])
        ->middleware('permission:create-contact')
        ->name('contacts.create');

    Route::get('/contacts/{id}', [ContactController::class, 'show'])
        ->name('contacts.show');

    Route::put('/contacts/{id}', [ContactController::class, 'update'])
        ->middleware('permission:edit-contact')
        ->name('contacts.update');

    Route::put('/contacts/{id}/ticket', [ContactController::class, 'updateTicket'])
        ->middleware('permission:edit-contact')
        ->name('contacts.updateTicket');

    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])
        ->middleware('permission:delete-contact')
        ->name('contacts.destroy');

    Route::post('/contacts/{id}/restore', [ContactController::class, 'restore'])
        ->middleware('role:admin|super-admin')
        ->name('contacts.restore');
});

// ----------------------
// Export / Import
// ----------------------
Route::get('/export-contacts', [ContactController::class, 'export'])->name('contacts.export');
Route::post('/contacts/import', [ContactController::class, 'import'])->name('contacts.import');
