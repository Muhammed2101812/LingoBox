<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Language;
// use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Language::create(['name' => 'Türkçe', 'code' => 'tr']);
        Language::create(['name' => 'English', 'code' => 'en']);
        Language::create(['name' => 'العربية', 'code' => 'ar']);

        // DB::table('languages')->insert([
        //     ['name' => 'Türkçe', 'code' => 'tr', 'created_at' => now(), 'updated_at' => now()],
        //     ['name' => 'English', 'code' => 'en', 'created_at' => now(), 'updated_at' => now()],
        //     ['name' => 'العربية', 'code' => 'ar', 'created_at' => now(), 'updated_at' => now()],
        // ]);
    }
}
