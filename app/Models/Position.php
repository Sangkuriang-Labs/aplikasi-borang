<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
  protected $fillable = [
    'name',
    'level',
  ];

  public function users()
  {
    return $this->hasMany(User::class);
  }
}
