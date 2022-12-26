<?php

namespace App\Policies;

use App\Models\Refference;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RefferencePolicy
{
  use HandlesAuthorization;

  public function viewAny(User $user): bool
  {

  }

  public function view(User $user, Refference $refference): bool
  {
  }

  public function create(User $user): bool
  {
  }

  public function update(User $user, Refference $refference): bool
  {
  }

  public function delete(User $user, Refference $refference): bool
  {
  }

  public function restore(User $user, Refference $refference): bool
  {
  }

  public function forceDelete(User $user, Refference $refference): bool
  {
  }
}
