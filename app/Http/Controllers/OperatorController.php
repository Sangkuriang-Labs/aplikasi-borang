<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\History;
use App\Models\Major;
use App\Models\Standard;
use App\Models\Sub;
use Carbon\Carbon;
use Inertia\Inertia;

class OperatorController extends Controller
{
  public function index()
  {
    $majors = Major::all()->map(fn($major) => ['id' => $major->id, 'value' => $major->name]);
    $standards = Standard::orderBy('number')->get()->map(fn($standard) => ['id' => $standard->id, 'value' => $standard->title, 'desc' => $standard->desc]);
    $subs = Sub::orderBy('number')->when(request()->query('selectedStandard') !== "", function ($query) {
      return $query->where('standard_id', '=', request()->query('selectedStandard'));
    })->get()->map(fn($sub) => ['id' => $sub->id, 'value' => $sub->number . " - " . $sub->title]);

    $contents = Content::when(request()->query('selectedSub') !== "", function ($query) {
      return $query->where('major_id', '=', request()->query('selectedMajor'))->where('sub_id', '=', request()->query('selectedSub'));
    })->latest()->get()->map(fn($content) => [
      'id' => $content->id,
      'sub_id' => $content->sub->id,
      'number' => $content->sub->number,
      'title' => $content->sub->title,
      'approved' => $content->approved,
      'grade' => $content->grade,
      'graded' => $content->graded,
      'author' => $content->user->name,
      'updated_at' => $content->updated_at,
    ]);

    return Inertia::render('Operator/Dokumen/Index', compact('majors', 'standards', 'subs', 'contents'));
  }

  public function approve($id)
  {
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

    return redirect(route('dashboard'));
  }

  public function create()
  {
    $majors = Major::all()->map(fn($major) => [
      'id' => $major->id,
      'value' => $major->name,
    ]);

    $standards = Standard::orderBy('number')->get()->map(fn($standard) => [
      'id' => $standard->id,
      'value' => $standard->number . " - " . $standard->title,
    ]);

    $subs = Sub::orderBy('number')->when(request()->query('majorId') !== "" && request()->query('standardId') !== "", function ($query) {
      return $query->where('standard_id', '=', request()->query('standardId'));
    })->get()->map(fn($sub) => [
      'id' => $sub->id,
      'value' => $sub->number . " - " . $sub->title,
    ]);

    return Inertia::render('Operator/Dokumen/Create', compact('majors', 'standards', "subs"));
  }

  public function store()
  {
    $validated = request()->validate([
      'user_id' => 'required',
      'sub_id' => 'required',
      'major_id' => 'required',
      'file' => 'required|mimes:pdf|max:2048',
    ]);

    if (request()->hasFile('file')) {
      $randomNumber = Carbon::now()->unix();
      $extension = request()->file('file')->extension();
      $author = str_replace(" ", "_", request()->user()->name);
      $title = str_replace(" ", "_", Sub::where('id', '=', $validated['sub_id'])->first()->title);
      $image_path = request()->file('file')->storeAs('dokumen', $randomNumber . "_" . $title . "_" . $author . "." . $extension, "public");
    }

    Content::create([
      'user_id' => $validated['user_id'],
      'sub_id' => $validated['sub_id'],
      'major_id' => $validated['major_id'],
      'file' => $image_path,
      'approved' => true,
    ]);

    History::create([
      'title' => Sub::where('id', '=', $validated['sub_id'])->first()->title,
      'author' => request()->user()->name,
      'operation' => 'ADD',
      'major_id' => $validated['major_id'],
      'sub_id' => $validated['sub_id'],
    ])->create([
      'title' => Sub::where('id', '=', $validated['sub_id'])->first()->title,
      'author' => request()->user()->name,
      'operation' => 'APPROVE',
      'major_id' => $validated['major_id'],
      'sub_id' => $validated['sub_id'],
      'created_at' => Carbon::now()->addSeconds(10),
    ]);

    return redirect(route('operator.contents.index'));
  }
}
