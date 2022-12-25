<?php

namespace App\Policies;

use App\Models\Content;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContentPolicy
{
  use HandlesAuthorization;

  public function viewAny(User $user): bool
  {
    return true;
  }

  public function view(User $user, Content $content): bool
  {
    return true;
  }

  public function create(User $user): bool
  {
    dd($user->position()->first()->level);
    return $user->position()->first()->level < 0;
  }

  public function update(User $user, Content $content): bool
  {
    return true;
  }

  public function delete(User $user, Content $content): bool
  {
    return true;
  }

  public function restore(User $user, Content $content): bool
  {
    return true;
  }

  public function forceDelete(User $user, Content $content): bool
  {
    return true;
  }
}
