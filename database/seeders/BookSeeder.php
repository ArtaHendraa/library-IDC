<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Books;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        Books::factory()->count(500)->create();
    }
}
