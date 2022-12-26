<?php

namespace Database\Seeders;

use App\Models\Sub;
use Illuminate\Database\Seeder;

class SubSeeder extends Seeder
{
  public function run()
  {
    Sub::create(['standard_id' => 1, 'title' => 'Visi, Misi, dan Tujuan Program Studi', 'number' => '1.1', 'child' => true, 'desc' => 'Sub standar ini mencakup informasi tentang visi, misi, dan tujuan program studi yang ingin diakreditasi. Visi merupakan cita-cita yang ingin dicapai oleh program studi tersebut, misi merupakan fungsi dan peran yang ingin dicapai oleh program studi tersebut, dan tujuan merupakan sasaran yang ingin dicapai oleh program studi tersebut.']);
    Sub::create(['standard_id' => 1, 'title' => 'Visi, Misi, dan Tujuan Program Studi', 'number' => '1.1.1', 'desc' => 'Butir ini mencakup informasi tentang visi, misi, dan tujuan program studi yang ingin diakreditasi. Visi merupakan cita-cita yang ingin dicapai oleh program studi tersebut, misi merupakan fungsi dan peran yang ingin dicapai oleh program studi tersebut, dan tujuan merupakan sasaran yang ingin dicapai oleh program studi tersebut.']);

    Sub::create(['standard_id' => 1, 'title' => 'Strategi Program Studi', 'number' => '1.2', 'child' => true, 'desc' => 'Sub standar ini mencakup informasi tentang bagaimana program studi tersebut akan mencapai visi, misi, dan tujuannya. Strategi merupakan dokumen yang menjelaskan bagaimana program studi tersebut akan mencapai visi, misi, dan tujuannya dengan menggunakan sumber daya yang tersedia, seperti sumber daya manusia, finansial, sarana dan prasarana, dan lain-lain']);
    Sub::create(['standard_id' => 1, 'title' => 'Struktur Organisasi Program Studi', 'number' => '1.2.1', 'desc' => 'Butir ini mencakup informasi tentang struktur organisasi program studi, yaitu bagaimana program studi tersebut terorganisir dan terstruktur. Struktur organisasi program studi harus dapat menunjang keberlangsungan dan keberhasilan program studi']);
    Sub::create(['standard_id' => 1, 'title' => 'Sistem Penjaminan Mutu Program Studi', 'number' => '1.2.2', 'desc' => 'Butir ini mencakup informasi tentang sistem penjaminan mutu yang digunakan oleh program studi tersebut. Sistem penjaminan mutu merupakan sistem yang digunakan untuk memastikan bahwa program studi tersebut memenuhi standar mutu yang telah ditetapkan']);
  }
}
