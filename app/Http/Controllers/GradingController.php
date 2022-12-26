<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\History;
use App\Models\Major;
use App\Models\Sub;
use Inertia\Inertia;

class GradingController extends Controller
{
  public function index()
  {
    $majors = Major::all()->map(fn($major) => [
      'id' => $major->id,
      'value' => $major->name,
    ]);
    $contents = Content::when(request()->query('majorId') !== null, function ($query) {
      return $query->where('approved', '=', true)->where('graded', '!=', true)->where('major_id', '=', request()->query('majorId'));
    }, function ($query) {
      return $query->where('approved', '=', true)->where('graded', '!=', true);
    })->get()->map(fn($content) => [
      'id' => $content->id,
      'number' => $content->sub->number,
      'title' => $content->sub->title,
      'major_name' => $content->major->name,
      'author' => $content->user->name,
      'file' => $content->file,
    ]);

    return Inertia::render('Operator/Grading/Index', compact('contents', 'majors'));
  }

  public function update($id)
  {
    $validated = request()->validate([
      'grade' => 'required',
    ]);

    Content::find($id)->update([
      'graded' => true,
      'grade' => $validated['grade'],
    ]);

    History::create([
      'title' => Sub::where('id', '=', Content::find($id)->sub_id)->first()->title,
      'author' => request()->user()->name,
      'operation' => 'GRADING',
      'major_id' => Content::find($id)->major_id,
      'sub_id' => Content::find($id)->sub_id,
    ]);

    Content::where('id', '!=', $id)
      ->where('major_id', '=', Content::find($id)->major_id)
      ->where('sub_id', '=', Content::find($id)->sub_id)
      ->delete();

    return redirect(route('operator.contents.index'));
  }
}
