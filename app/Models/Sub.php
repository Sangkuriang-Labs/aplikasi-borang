<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sub extends Model
{
  protected $fillable = [
    'title',
    'number',
    'child',
    'standard_id',
    'desc',
  ];

  public function standard()
  {
    return $this->belongsTo(Standard::class);
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
