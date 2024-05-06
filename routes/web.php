<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ProjectDisplay;
use App\Livewire\Home;
use App\Livewire\RenewalPage;
use App\Livewire\DuePage;
use App\Livewire\NextPage;
use App\Livewire\ProjectCreator;
use App\Livewire\ProjectEditor;
use App\Livewire\SaleDisplay;
use App\Livewire\SaleCreator;
use App\Livewire\LayoutDisplay;
use App\Livewire\UserManagement;
use App\Models\User;
use App\Models\Project;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    //home
    Route::get('/home', Home::class)->name('home');
   
    //projects
    Route::get('/projects', ProjectDisplay::class)->name('projects');
    Route::get('/project/editor', ProjectEditor::class)->name('editor-project');
    

    //sales
    Route::get('/sales', SaleDisplay::class)->name('sales');
    Route::get('/sale/creator', SaleCreator::class)->name('creator-sales');

    //layouts
    Route::get('/layouts', LayoutDisplay::class)->name('layouts');

    //users
    Route::get('/admindepartment', UserManagement::class)->name('admin-department');

    //renewal
    Route::get('/renewal',RenewalPage::class)->name('renewal');
    Route::get('/duedate',DuePage::class)->name('duedate');
    Route::get('/nextmonth',NextPage::class)->name('nextmonth');
    
});
