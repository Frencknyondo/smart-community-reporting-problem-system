<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\NotificationController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\ReportController;
use App\Http\Controllers\Dashboard\UserManagementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
require __DIR__.'/auth.php';
Route::view('/home', 'home');
Route::view('/about', 'about')->name('about');
Route::get('/report', function (Request $request) {
    if (! $request->user()) {
        return redirect()
            ->route('login')
            ->with('status', 'Please login as a citizen to report an issue.');
    }

    if ($request->user()->role === 'citizen') {
        return redirect()->route('dashboard.citizen.reports.create');
    }

    return redirect()
        ->route('dashboard.index')
        ->with('error', 'Only citizen accounts can submit public issue reports.');
})->name('report.start');

Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/admin', [DashboardController::class, 'admin'])->middleware('role:admin')->name('admin.index');
    Route::get('/council', [DashboardController::class, 'council'])->middleware('role:council')->name('council.index');
    Route::get('/citizen', [DashboardController::class, 'citizen'])->middleware('role:citizen')->name('citizen.index');
    Route::get('/citizen/report-issue', [ReportController::class, 'create'])->middleware('role:citizen')->name('citizen.reports.create');
    Route::post('/citizen/report-issue', [ReportController::class, 'store'])->middleware('role:citizen')->name('citizen.reports.store');
    Route::get('/citizen/track-reports', [ReportController::class, 'trackReports'])->middleware('role:citizen')->name('citizen.reports.track');
    Route::get('/reported-issues', [ReportController::class, 'index'])->middleware('role:admin,council,citizen')->name('reports.index');
    Route::patch('/reported-issues/{report}/status', [ReportController::class, 'updateStatus'])->middleware('role:admin,council')->name('reports.status.update');
    Route::get('/user-management', [UserManagementController::class, 'index'])->middleware('role:admin')->name('users.index');
    Route::get('/user-management/create', [UserManagementController::class, 'create'])->middleware('role:admin')->name('users.create');
    Route::post('/user-management', [UserManagementController::class, 'store'])->middleware('role:admin')->name('users.store');
    Route::get('/user-management/{user}/edit', [UserManagementController::class, 'edit'])->middleware('role:admin')->name('users.edit');
    Route::put('/user-management/{user}', [UserManagementController::class, 'update'])->middleware('role:admin')->name('users.update');
    Route::delete('/user-management/{user}', [UserManagementController::class, 'destroy'])->middleware('role:admin')->name('users.destroy');
    
    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/dropdown-data', [NotificationController::class, 'dropdownData'])->name('notifications.dropdown-data');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');
    Route::get('/notifications/{notificationId}', [NotificationController::class, 'show'])->name('notifications.show');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/e-learning', fn () => redirect()->route('login'))->name('e-learning');
