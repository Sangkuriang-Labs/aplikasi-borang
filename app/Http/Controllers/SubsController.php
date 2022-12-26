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

    if ($request->user()->position()->first()->level >= 3) {
      $contents = Sub::with('contents', 'standard')->when($request->query('standardId') != "", function ($sub) use ($request) {
        return $sub->where('standard_id', '=', $request->query('standardId'));
      })->get()
        ->map(fn($content) => [
          'id' => $content->id,
          'title' => $content->title,
          'number' => $content->number,
          'contents' => $content->contents,
          'grade' => count($content->contents->filter(function ($value, $key) {
            return $value->graded === true && $value->approved === true;
          })) > 0 ? $content->contents->filter(function ($value, $key) {
            return $value->graded === true && $value->approved === true;
          })->last()->grade : "Belum memiliki nilai",
          'updated' => [
            'time' => count($content->contents) > 0 ? $content->contents->last()->created_at : null,
            'author' => count($content->contents) > 0 ? $content->contents->last()->user()->first()->name : null,
          ]
        ]);
    } else {
      $contents = Sub::with('contents', 'standard')->when($request->query('standardId') != "", function ($sub) use ($request) {
        return $sub->where('standard_id', '=', $request->query('standardId'))->whereHas('contents', function ($content) use ($request) {
          return $content->with('user')->where('major_id', '=', $request->user()->major_id);
        });
      })->get()
        ->map(fn($content) => [
          'id' => $content->id,
          'title' => $content->title,
          'number' => $content->number,
          'contents' => [
            $content->contents->filter(function ($value, $key) {
              return $value->major_id === \request()->user()->major_id;
            })
          ],
          'grade' => count($content->contents->filter(function ($value, $key) {
            return $value->graded === true && $value->approved === true;
          })) > 0 ? $content->contents->filter(function ($value, $key) {
            return $value->graded === true && $value->approved === true;
          })->last()->grade : "Belum memiliki nilai",
          'updated' => [
            'time' => count($content->contents->filter(function ($value, $key) {
              return $value->major_id === \request()->user()->major_id;
            })) > 0 ? $content->contents->filter(function ($value, $key) {
              return $value->major_id === \request()->user()->major_id;
            })->last()->created_at : null,
            'author' => count($content->contents->filter(function ($value, $key) {
              return $value->major_id === \request()->user()->major_id;
            })) > 0 ? $content->contents->filter(function ($value, $key) {
              return $value->major_id === \request()->user()->major_id;
            })->last()->user()->first()->name : null,
          ]
        ]);
    }

    return Inertia::render('Subs/Index', compact('standards', 'contents'));
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
    $histories = History::where('sub_id', '=', $sub->id)->where('major_id', '=', \request()->user()->major_id)->latest()->get()->take(10);
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
