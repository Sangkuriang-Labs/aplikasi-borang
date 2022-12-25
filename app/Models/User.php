<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
  use HasApiTokens;
  use HasFactory;
  use HasProfilePhoto;
  use Notifiable;
  use TwoFactorAuthenticatable;

  protected $fillable = [
    'position_id',
    'major_id',
    'name',
    'email',
    'password',
  ];

  protected $hidden = [
    'password',
    'remember_token',
    'two_factor_recovery_codes',
    'two_factor_secret',
  ];

  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  protected $appends = [
    'profile_photo_url',
  ];

  public function position()
  {
    return $this->belongsTo(Position::class);
  }

  public function major()
  {
    return $this->belongsTo(Major::class);
  }

  public function contents()
  {
    return $this->hasMany(Content::class);
  }
}
