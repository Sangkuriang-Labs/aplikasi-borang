<?php

namespace Database\Seeders;

use App\Models\Major;
use Illuminate\Database\Seeder;

class MajorSeeder extends Seeder
{
  public function run()
  {
    Major::create(['name' => 'Prodi 1']);
    Major::create(['name' => 'Prodi 2']);
    Major::create(['name' => 'Prodi 3']);
  }
}
