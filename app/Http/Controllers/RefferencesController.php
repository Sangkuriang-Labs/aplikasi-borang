<?php

namespace App\Http\Controllers;

use App\Models\Refference;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RefferencesController extends Controller
{
  public function index()
  {
    $refferences = Refference::all();

    return Inertia::render('Refference', compact('refferences'));
  }

  public function create()
  {
  }

  public function store(Request $request)
  {
  }

  public function show(Refference $refference)
  {
  }

  public function edit(Refference $refference)
  {
  }

  public function update(Request $request, Refference $refference)
  {
  }

  public function destroy(Refference $refference)
  {
  }
}
