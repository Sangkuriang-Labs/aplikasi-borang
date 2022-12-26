<?php

namespace Database\Seeders;

use App\Models\Major;
use Illuminate\Database\Seeder;

class MajorSeeder extends Seeder
{
  public function run()
  {
    Major::create(['name' => 'Perdagangan Internasional (S-1)']);
    Major::create(['name' => 'Perpustakaan & Sains Informasi (S-1)']);
    Major::create(['name' => 'Film & Televisi (Sarjana Vokasi / D4)']);
  }
}
