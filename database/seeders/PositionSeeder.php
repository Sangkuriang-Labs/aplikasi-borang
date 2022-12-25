<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
  public function run()
  {
    Position::create([
      'name' => 'Admin',
      'level' => 4,
    ]);

    Position::create([
      'name' => 'Operator',
      'level' => 3,
    ]);

    Position::create([
      'name' => 'Dekan',
      'level' => 0,
    ]);

    Position::create([
      'name' => 'Ketua Program Studi',
      'level' => 2,
    ]);

    Position::create([
      'name' => 'Dosen',
      'level' => 1,
    ]);
  }
}
