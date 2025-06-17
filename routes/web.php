<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resources([
    'roles' => RoleController::class,
    'users' => UserController::class,
]);

Route::middleware(['auth'])->group(function () {
    Route::get('/user', [SettingController::class, 'edit'])->name('userSettings.edit');
    Route::put('/user', [SettingController::class, 'update'])->name('userSettings.update');
});

Route::get('/admin', function () {
    return view('users.admin');
})->name('admin.dashboard');

Route::get('/user-search', [UserController::class, 'search'])
    ->name('users.search');

Route::group(['middleware' => ['permission:view-contact']], function () {

    Route::get('/contacts', function () {
        $contacts = Contact::query()->paginate(8);
        return view('contacts.index', ['contacts' => $contacts]);
    })->name('contacts');

    Route::get('/search', [ContactController::class, 'search'])
        ->name('contacts.search');

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
