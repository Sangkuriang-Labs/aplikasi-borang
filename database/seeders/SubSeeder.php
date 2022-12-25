<?php

namespace Database\Seeders;

use App\Models\Standard;
use App\Models\Sub;
use Illuminate\Database\Seeder;

class SubSeeder extends Seeder
{
  public function run()
  {
    $standardId = Standard::first()->id;

    Sub::create(['standard_id' => $standardId, 'title' => 'Standard 1 Sub 1', 'number' => '1.1', 'child' => true, 'desc' => 'Keterangan Dokumen']);
    Sub::create(['standard_id' => $standardId, 'title' => 'Standard 1 Sub 2', 'number' => '1.1.1', 'desc' => 'Keterangan Dokumen']);
    Sub::create(['standard_id' => $standardId, 'title' => 'Standard 1 Sub 3', 'number' => '1.1.2', 'desc' => 'Keterangan Dokumen']);
  }
}
