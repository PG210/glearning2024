<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NivelCateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('nivelcate')->insert([
            ['nombre' => 'Default', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Oro', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Plata', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Bronce', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
