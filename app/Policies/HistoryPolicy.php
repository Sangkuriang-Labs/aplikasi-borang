<?php

namespace App\Policies;

use App\Models\History;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class HistoryPolicy
{
  use HandlesAuthorization;

  public function viewAny(User $user): bool
  {

  }

  public function view(User $user, History $history): bool
  {
  }

  public function create(User $user): bool
  {
  }

  public function update(User $user, History $history): bool
  {
  }

  public function delete(User $user, History $history): bool
  {
  }

  public function restore(User $user, History $history): bool
  {
  }

  public function forceDelete(User $user, History $history): bool
  {
  }
}
