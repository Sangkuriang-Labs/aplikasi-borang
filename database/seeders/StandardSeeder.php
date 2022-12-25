<?php

namespace Database\Seeders;

use App\Models\Standard;
use Illuminate\Database\Seeder;

class StandardSeeder extends Seeder
{
  public function run()
  {
    Standard::create(['title' => "Visi, Misi, Tujuan, dan Strategi", 'desc' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis, fugit.", 'number' => '1']);
    Standard::create(['title' => "Tata Pamong, Tata Kelola, dan Kerjasama", 'desc' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis, fugit.", 'number' => '2']);
    Standard::create(['title' => "Mahasiswa", 'desc' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis, fugit.", 'number' => '3']);
    Standard::create(['title' => "Sumber Daya Manusia", 'desc' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis, fugit.", 'number' => '4']);
    Standard::create(['title' => "Keuangan, Sarana, dan Prasarana", 'desc' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis, fugit.", 'number' => '5']);
    Standard::create(['title' => "Pendidikan", 'desc' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis, fugit.", 'number' => '6']);
    Standard::create(['title' => "Penelitian", 'desc' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis, fugit.", 'number' => '7']);
    Standard::create(['title' => "Pengabdian Kepada Masyarakat", 'desc' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis, fugit.", 'number' => '8']);
    Standard::create(['title' => "Luaran dan Capaian Tridharma", 'desc' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis, fugit.", 'number' => '9']);
  }
}
