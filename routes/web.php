<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\DeployController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\DetectBrowserLocale;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Routes to redirect the user around the page
Route::middleware([
    DetectBrowserLocale::class,
])->group(function () {

    Auth::routes();

    Route::get('/', function () {
        return redirect()->route('login');
    });

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::middleware(['role:Admin|Super Admin'])->group(function () {
        Route::resources([
            'roles' => RoleController::class,
            'users' => UserController::class,
        ]);

        Route::get('/user-search', [UserController::class, 'search'])
            ->name('users.search');

        Route::resource('permissions',
            PermissionController::class)->only([
            'index', 'store', 'destroy'
        ]);

        Route::post('/deploy', [DeployController::class, 'deploy'])
            ->name('deploy');
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/user', [SettingController::class, 'edit'])->name('userSettings.edit');
        Route::put('/user', [SettingController::class, 'update'])->name('userSettings.update');
    });

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
    });

    Route::get('/export-contacts', [ContactController::class, 'export'])->name('contacts.export');
    Route::post('/contacts/import', [ContactController::class, 'import'])->name('contacts.import');
});
