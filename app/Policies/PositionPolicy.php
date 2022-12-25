<?php

namespace App\Policies;

use App\Models\Position;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PositionPolicy
{
  use HandlesAuthorization;

  public function viewAny(User $user): bool
  {
    return true;
  }

  public function view(User $user, Position $position): bool
  {
    return true;
  }

  public function create(User $user): bool
  {
    return true;
  }

  public function update(User $user, Position $position): bool
  {
    return true;
  }

  public function delete(User $user, Position $position): bool
  {
    return true;
  }

  public function restore(User $user, Position $position): bool
  {
    return true;
  }

  public function forceDelete(User $user, Position $position): bool
  {
    return true;
  }
}
