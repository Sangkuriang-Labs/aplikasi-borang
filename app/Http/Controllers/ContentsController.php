<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\History;
use App\Models\Major;
use App\Models\Standard;
use App\Models\Sub;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContentsController extends Controller
{
  public function index()
  {

  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'user_id' => 'required',
      'sub_id' => 'required',
      'major_id' => 'required',
      'file' => 'required|mimes:pdf|max:2048',
    ]);

    if ($request->hasFile('file')) {
      $randomNumber = Carbon::now()->unix();
      $extension = $request->file('file')->extension();
      $author = str_replace(" ", "_", $request->user()->name);
      $title = str_replace(" ", "_", Sub::where('id', '=', $validated['sub_id'])->first()->title);
      $image_path = $request->file('file')->storeAs('dokumen', $randomNumber . "_" . $title . "_" . $author . "." . $extension, "public");
    }

    if ($request->user()->position()->first()->level >= 2) {
      Content::create([
        'user_id' => $validated['user_id'],
        'sub_id' => $validated['sub_id'],
        'major_id' => $validated['major_id'],
        'file' => $image_path,
        'approved' => true,
      ]);

      History::create([
        'title' => Sub::where('id', '=', $validated['sub_id'])->first()->title,
        'author' => $request->user()->name,
        'operation' => 'ADD',
        'major_id' => $validated['major_id'],
        'sub_id' => $validated['sub_id'],
      ])->create([
        'title' => Sub::where('id', '=', $validated['sub_id'])->first()->title,
        'author' => $request->user()->name,
        'operation' => 'APPROVE',
        'major_id' => $validated['major_id'],
        'sub_id' => $validated['sub_id'],
        'created_at' => Carbon::now()->addSeconds(10),
      ]);
    } else {
      Content::create([
        'user_id' => $validated['user_id'],
        'sub_id' => $validated['sub_id'],
        'major_id' => $validated['major_id'],
        'file' => $image_path,
      ]);

      History::create([
        'title' => Sub::where('id', '=', $validated['sub_id'])->first()->title,
        'author' => $request->user()->name,
        'operation' => 'ADD',
        'major_id' => $validated['major_id'],
        'sub_id' => $validated['sub_id'],
      ]);
    }

    return redirect(route('subs.index'));
  }

  public function create(Request $request)
  {
    $standards = Standard::orderBy('number')->get()->map(fn($standard) => ['id' => $standard->id, 'value' => $standard->number . " - " . $standard->title]);
    $subs = Sub::orderBy('number')->when($request->query('standardId') != "", function ($query) use ($request) {
      return $query->where('standard_id', '=', $request->query('standardId'));
    })->get()->map(fn($sub) => ['id' => $sub->id, 'value' => $sub->number . " - " . $sub->title]);
    $majors = Major::all()->map(fn($major) => ['id' => $major->id, 'value' => $major->name]);

    return Inertia::render('Contents/Create', compact('standards', 'subs', 'majors'));
  }

  public function show(Content $content)
  {

  }

  public function edit(Content $content)
  {
  }

  public function update(Request $request, Content $content)
  {
  }

  public function destroy(Content $content)
  {
    $content->delete();

    History::create([
      'sub_id' => $content->sub_id,
      'major_id' => $content->major_id,
      'operation' => 'DELETE',
      'author' => \Auth::user()->name,
      'title' => Sub::where('id', '=', $content->sub_id)->first()->title,
    ]);

    return redirect(route('dashboard'));
  }
}
