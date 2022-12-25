<?php

namespace App\Actions\Fortify;

use App\Models\Position;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
  use PasswordValidationRules;

  /**
   * Validate and create a newly registered user.
   *
   * @param array $input
   * @return \App\Models\User
   */
  public function create(array $input)
  {
    $dekanId = Position::where('name', '=', 'Dekan')->first()->id;

    Validator::make($input, [
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'position_id' => ['required'],
      'major_id' => ["required_unless:position_id,=,$dekanId"],
      'password' => $this->passwordRules(),
      'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
    ])->validate();

    return User::create([
      'name' => $input['name'],
      'position_id' => $input['position_id'],
      'major_id' => $input['major_id'],
      'email' => $input['email'],
      'password' => Hash::make($input['password']),
    ]);
  }
}
