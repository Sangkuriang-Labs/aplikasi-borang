<?php

use App\Http\Controllers\ContentsController;
use App\Http\Controllers\SubsController;
use App\Models\Content;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
  return Inertia::render('Welcome', [
    'canLogin' => Route::has('login'),
    'canRegister' => Route::has('register'),
    'laravelVersion' => Application::VERSION,
    'phpVersion' => PHP_VERSION,
  ]);
});

Route::middleware([
  'auth:sanctum',
  config('jetstream.auth_session'),
  'verified',
])->group(function () {

  Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
  })->name('dashboard');

  Route::get('/download/{id}', function ($id) {
    $content = Content::find($id);
    return response()->download(storage_path('app/public/' . $content->file), explode("/", $content->file)[1]);
  })->name('download');

  Route::resource('subs', SubsController::class)->only('index', 'show');
  Route::resource('contents', ContentsController::class)->only('create', 'store', 'destroy');

});

