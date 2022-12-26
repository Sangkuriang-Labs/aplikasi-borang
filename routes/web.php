<?php

use App\Http\Controllers\ContentsController;
use App\Http\Controllers\GradingController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\RefferencesController;
use App\Http\Controllers\StandardsController;
use App\Http\Controllers\SubsController;
use App\Http\Controllers\UsersController;
use App\Models\Content;
use App\Models\History;
use App\Models\Major;
use App\Models\Refference;
use App\Models\Standard;
use App\Models\Sub;
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
])->group(callback: function () {

  Route::get('/dashboard', function () {
    $standards = Standard::with('subs')->get()->map(fn($standard) => [
      'id' => $standard->id,
      'title' => $standard->title,
      'count_sub' => Sub::where('standard_id', '=', $standard->id)
        ->where('child', '=', false)->count(),
      'total_grade' => Content::with('major', 'sub', 'user')->whereHas('sub', function ($query) use ($standard) {
        return $query->where('child', '=', false)->where('standard_id', '=', $standard->id);
      })->get()->sum('grade'),
    ]);

    $majors = Major::with('contents')->get()->map(fn($major) => [
      'id' => $major->id,
      'name' => $major->name,
      'contents' => Standard::with('subs')->get()->map(function ($standard) use ($major) {
        return [
          'id' => $standard->id,
          'title' => $standard->title,
          'count_sub' => Sub::where('standard_id', '=', $standard->id)
            ->where('child', '=', false)->count(),
          'total_grade' => Content::with('major', 'sub', 'user')->where('major_id', '=', $major->id)->whereHas('sub', function ($query) use ($standard) {
            return $query->where('child', '=', false)->where('standard_id', '=', $standard->id);
          })->get()->sum('grade'),
        ];
      }),
    ]);

    return Inertia::render('Dashboard', compact('standards', 'majors'));
  })->name('dashboard');

  Route::get('/download/content/{id}', function ($id) {
    $content = Content::find($id);
    return response()->download(storage_path('app/public/' . $content->file), explode("/", $content->file)[1]);
  })->name('download.content');

  Route::get('/download/refference/{id}', function ($id) {
    $refferences = Refference::find($id);
    return response()->download(storage_path('app/public/' . $refferences->file), explode("/", $refferences->file)[1]);
  })->name('download.refference');

  Route::post('/approved/{id}', function ($id) {
    $updated = Content::where('id', '=', $id)->update(['approved' => true]);

    if ($updated) {
      History::create([
        'title' => Sub::with('contents')->whereHas('contents', function ($content) use ($id) {
          return $content->where('id', '=', $id);
        })->first()->title,
        'author' => request()->user()->name,
        'operation' => 'APPROVE',
        'major_id' => Content::where('id', '=', $id)->first()->major_id,
        'sub_id' => Sub::with('contents')->whereHas('contents', function ($content) use ($id) {
          return $content->where('id', '=', $id);
        })->first()->id,
      ]);
    }

    return redirect(route('subs.show', Sub::with('contents')->whereHas('contents', function ($content) use ($id) {
      return $content->where('id', '=', $id);
    })->first()->id));
  })->name('approved')->middleware('level.2');

  Route::get('/operator/contents/create', [OperatorController::class, 'create'])->name('operator.contents.create')->middleware('level.3');
  Route::post('/operator/contents', [OperatorController::class, 'store'])->name('operator.contents.store')->middleware('level.3');
  Route::get('/operator/contents', [OperatorController::class, 'index'])->name('operator.contents.index')->middleware('level.3');
  Route::get('/opeartor/grading', [GradingController::class, 'index'])->name('operator.grading.index')->middleware('level.3');
  Route::patch('/operator/grading/{id}', [GradingController::class, 'update'])->name('operator.grading.store')->middleware('level.3');
  Route::patch('/operator/approve/{id}', [OperatorController::class, 'approve'])->name('operator.contents.approve')->middleware('level.3');
  Route::resource('refferences', RefferencesController::class)->only('index');
  Route::resource('subs', SubsController::class)->only('index', 'show')->middleware('level.1');
  Route::resource('contents', ContentsController::class)->only('create', 'store', 'destroy')->middleware('level.1');
  Route::resource('users', UsersController::class)->only('index')->middleware('level.3');
  Route::resource('standards', StandardsController::class)->only('index', 'store', 'destroy')->middleware('level.3');
});

