<?php

namespace App\Http\Controllers;

use App\Models\Major;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MajorsController extends Controller
{
  public function index()
  {
    $majors = Major::orderBy('id')->get()->map(fn($major) => [
      'id' => $major->id,
      'name' => $major->name,
    ]);

    return Inertia::render('Operator/Major/Index', compact('majors'));
  }

  public function create()
  {
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|string',
    ]);

    Major::create($validated);

    return redirect(route('operator.majors.index'));
  }

  public function show(Major $major)
  {
  }

  public function edit(Major $major)
  {
  }

  public function update(Request $request, Major $major)
  {
    $validated = $request->validate([
      'name' => 'required|string'
    ]);

    $major->update($validated);

    return redirect(route('operator.majors.index'));
  }

  public function destroy(Major $major)
  {
    $major->forceDelete();

    return redirect(route('operator.majors.index'));
  }
}
