<?php

namespace App\Http\Controllers;

use App\Models\Standard;
use App\Models\Sub;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubsOperatorController extends Controller
{
  public function index()
  {
    $subs = Sub::with('standard')->orderBy('number')->get()->map(fn($sub) => [
      'id' => $sub->id,
      'standard_id' => $sub->standard->id,
      'number_standard' => $sub->standard->number,
      'number_sub' => $sub->number,
      'type' => $sub->child,
      'title' => $sub->title,
      'desc' => $sub->desc,
    ]);

    $standards = Standard::orderBy('number')->get()->map(fn($standard) => [
      'id' => $standard->id,
      'value' => $standard->number . " - " . $standard->title
    ]);

    return Inertia::render('Operator/Subs/Index', compact('subs', 'standards'));
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'standard_id' => 'required',
      'title' => 'required|string',
      'number' => 'required|unique:subs,number',
      'child' => 'required|boolean',
      'desc' => 'required',
    ]);

    Sub::create([
      'title' => $validated['title'],
      'number' => $validated['number'],
      'desc' => $validated['desc'],
      'child' => $validated['child'],
      'standard_id' => $validated['standard_id'],
    ]);

    return redirect(route('operator.subs.index'));
  }

  public function create()
  {
  }

  public function show(Sub $sub)
  {
  }

  public function edit(Sub $sub)
  {
  }

  public function update(Request $request, Sub $sub)
  {
    $validated = $request->validate([
      'standard_id' => 'required',
      'title' => 'required|string',
      'number' => 'required|string',
      'child' => 'required|boolean',
      'desc' => 'required|string',
    ]);

    $sub->update($validated);

    return redirect(route('operator.subs.index'));
  }

  public function destroy(Sub $sub)
  {
    $sub->forceDelete();

    return redirect(route('operator.subs.index'));
  }
}
