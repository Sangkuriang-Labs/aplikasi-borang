<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    // \App\Models\User::factory(10)->create();

    // \App\Models\User::factory()->create([
    //     'name' => 'Test User',
    //     'email' => 'test@example.com',
    // ]);

    $this->call([
      PositionSeeder::class,
      MajorSeeder::class,
      StandardSeeder::class,
      SubSeeder::class,
      RefferenceSeeder::class,
    ]);

    User::factory()->create([
      'name' => 'Operator',
      'email' => 'operator.borang@widyatama.ac.id',
      'position_id' => Position::where('name', '=', 'Operator')->first()->id,
    ]);
  }
}
