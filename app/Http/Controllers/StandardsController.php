<?php

namespace App\Http\Controllers;

use App\Models\Standard;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StandardsController extends Controller
{
  public function index()
  {
    $standards = Standard::orderBy('number')->get()->map(fn($standard) => [
      'id' => $standard->id,
      'title' => $standard->title,
      'number' => $standard->number,
      'desc' => $standard->desc,
    ]);

    return Inertia::render('Operator/Standard/Index', compact('standards'));
  }

  public function create()
  {
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'title' => 'required|string',
      'number' => 'required|integer|unique:standards,number',
      'desc' => 'required|string',
    ]);

    Standard::create($validated);

    return redirect(route('standards.index'));
  }

  public function show(Standard $standard)
  {
  }

  public function edit(Standard $standard)
  {
  }

  public function update(Request $request, Standard $standard)
  {
    $validated = $request->validate([
      'id' => 'required',
      'title' => 'required|string',
      'number' => 'required|numeric',
      'desc' => 'required|string',
    ]);

    $standard->update($validated);

    return redirect(route('standards.index'));
  }

  public function destroy(Standard $standard)
  {
    $standard->forceDelete();

    return redirect(route('standards.index'));
  }
}
