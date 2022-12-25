<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Standard extends Model
{
  protected $fillable = [
    'desc',
    'title',
    'number',
  ];

  public function subs()
  {
    return $this->hasMany(Sub::class);
  }

  public function histories()
  {
    return $this->hasMany(History::class);
  }
}
