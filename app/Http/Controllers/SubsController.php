<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\History;
use App\Models\Standard;
use App\Models\Sub;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubsController extends Controller
{
  public function index(Request $request)
  {
    $standards = Standard::all()->map(fn($standard) => ['id' => $standard->id, 'value' => $standard->title, 'number' => $standard->number, 'desc' => $standard->desc]);

    $contents = Sub::with('contents', 'standard')->when($request->query('standardId') != "", function ($sub) use ($request) {
      return $sub->where('standard_id', '=', $request->query('standardId'))->whereHas('contents', function ($content) use ($request) {
        return $content->with('user')->where('major_id', '=', $request->user()->major_id);
      });
    })->get()
      ->map(fn($content) => [
        'id' => $content->id,
        'title' => $content->title,
        'number' => $content->number,
        'contents' => $content->contents,
        'updated' => [
          'time' => count($content->contents) > 0 ? $content->contents->filter(function ($value, $key) use ($request) {
            return $value->major_id === $request->user()->major_id;
          })->last()->created_at : null,
          'author' => count($content->contents) > 0 ? $content->contents->filter(function ($value, $key) use ($request) {
            return $value->major_id === $request->user()->major_id;
          })->last()->user()->first()->name : null,
        ]
      ]);

    $histories = History::with('sub', 'major')->where('major_id', '=', $request->user()->major_id)->whereHas('sub', function ($sub) use ($request) {
      return $sub->where('standard_id', '=', $request->query('standardId'));
    })->latest()->limit(10)->get();

    return Inertia::render('Subs/Index', compact('standards', 'contents', 'histories'));
  }

  public function create()
  {
  }

  public function store(Request $request)
  {
  }

  public function show(Sub $sub)
  {
    $sub = $sub->load('standard');
    $contents = Content::with('user', 'major')->where('major_id', '=', \request()->user()->major_id)->where('sub_id', '=', $sub->id)->latest()->get();
    $histories = History::where('sub_id', '=', $sub->id)->where('major_id', '=', \request()->user()->major_id)->latest()->limit(10)->get();
    return Inertia::render('Subs/Show', compact('sub', 'contents', 'histories'));
  }

  public function edit(Sub $sub)
  {
  }

  public function update(Request $request, Sub $sub)
  {
  }

  public function destroy(Sub $sub)
  {
  }
}
