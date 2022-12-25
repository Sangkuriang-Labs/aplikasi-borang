<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
  protected $fillable = [
    'name'
  ];

  public function users()
  {
    return $this->hasMany(User::class);
  }

  public function contents()
  {
    return $this->hasMany(Content::class);
  }

  public function histories()
  {
    return $this->hasMany(History::class);
  }
}
