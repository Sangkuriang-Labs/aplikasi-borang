<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UsersController extends Controller
{
  public function index()
  {
    $users = User::with('major', 'position')->whereHas('position', function ($query) {
      return $query->where('name', '!=', 'Admin')->where('name', '!=', 'Operator');
    })->get()->map(fn($user) => [
      'id' => $user->id,
      'name' => $user->name,
      'email' => $user->email,
      'major_name' => $user->major === null ? "Tidak Terkait" : $user->major->name,
      'position_name' => $user->position->name,
    ]);

    return Inertia::render('Operator/User/Index', compact('users'));
  }

  public function create()
  {
  }

  public function store(Request $request)
  {
  }

  public function show(User $user)
  {
  }

  public function edit(User $user)
  {
  }

  public function update(Request $request, User $user)
  {
  }

  public function destroy(User $user)
  {
  }
}
