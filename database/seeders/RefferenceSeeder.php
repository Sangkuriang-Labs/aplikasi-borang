<?php

namespace Database\Seeders;

use App\Models\Refference;
use Illuminate\Database\Seeder;

class RefferenceSeeder extends Seeder
{
  public function run()
  {
    \Storage::delete(\Storage::files('referensi'));

    $files = \File::files(public_path('storage/referensi'));

    foreach ($files as $file) {
      $filename = 'referensi/' . $file->getFilename();
      Refference::create([
        'name' => $file->getFilename(),
        'file' => $filename,
      ]);
    }
  }
}
