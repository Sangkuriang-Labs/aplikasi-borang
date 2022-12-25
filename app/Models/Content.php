<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
  protected $fillable = [
    'user_id',
    'sub_id',
    'major_id',
    'file',
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function sub()
  {
    return $this->belongsTo(Sub::class);
  }

  public function major()
  {
    return $this->belongsTo(Major::class);
  }
}
