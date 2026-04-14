<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LeaveAssignmentController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // User Management Routes (available to both HR and Super Admin)
    Route::resource('users', UserController::class)->names([
        'index' => 'users.index',
        'create' => 'users.create',
        'store' => 'users.store',
        'show' => 'users.show',
        'edit' => 'users.edit',
        'update' => 'users.update',
        'destroy' => 'users.destroy',
    ]);
    
    // Leave Assignment Routes (available to both HR and Super Admin)
    Route::get('leave-assignments', [LeaveAssignmentController::class, 'index'])->name('leave-assignments.index');
    Route::get('leave-assignments/user/{user}', [LeaveAssignmentController::class, 'getUserAssignments'])->name('leave-assignments.getUser');
    Route::post('leave-assignments', [LeaveAssignmentController::class, 'store'])->name('leave-assignments.store');
    Route::put('leave-assignments/{leaveAssignment}', [LeaveAssignmentController::class, 'update'])->name('leave-assignments.update');
    Route::post('leave-assignments/bulk-update', [LeaveAssignmentController::class, 'bulkUpdate'])->name('leave-assignments.bulkUpdate');
    Route::delete('leave-assignments/{leaveAssignment}', [LeaveAssignmentController::class, 'destroy'])->name('leave-assignments.destroy');
    
    // Role Management Routes (Super Admin only)
    Route::middleware(['super.admin'])->group(function () {
        Route::resource('roles', RoleController::class)->names([
            'index' => 'roles.index',
            'create' => 'roles.create',
            'store' => 'roles.store',
            'show' => 'roles.show',
            'edit' => 'roles.edit',
            'update' => 'roles.update',
            'destroy' => 'roles.destroy',
        ]);
        
        // Permission Management Routes (Super Admin only)
        Route::resource('permissions', PermissionController::class)->names([
            'index' => 'permissions.index',
            'create' => 'permissions.create',
            'store' => 'permissions.store',
            'show' => 'permissions.show',
            'edit' => 'permissions.edit',
            'update' => 'permissions.update',
            'destroy' => 'permissions.destroy',
        ]);
    });
});
