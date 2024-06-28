<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            [
                'name' => 'Noodle',
                'slug' => 'Noodle',
                'status' => 1,
                'show_at_home'=>1,
            ],
            [
                'name' => 'Snack',
                'slug' => 'Snack',
                'status' => 1,
                'show_at_home'=>1,
            ],
            [
                'name' => 'Drinks',
                'slug' => 'Drinks',
                'status' => 1,
                'show_at_home'=>1,
            ],
        ]);
    }
}
