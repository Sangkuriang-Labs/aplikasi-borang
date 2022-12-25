<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
  protected $fillable = [
    'major_id',
    'sub_id',
    'operation',
    'author',
    'title',
  ];

  public function major()
  {
    return $this->belongsTo(Major::class);
  }

  public function sub()
  {
    return $this->belongsTo(Sub::class);
  }
}
