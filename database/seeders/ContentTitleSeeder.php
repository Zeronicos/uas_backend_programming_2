<?php

namespace Database\Seeders;

use App\Models\SectionTitle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContentTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SectionTitle::insert([
            [
                'key' => 'content_top_title',
                'value' => 'Why Choose Us'
            ],
            [
                'key' => 'content_main_title',
                'value' => 'Why Choose Us'
            ],
            [
                'key' => 'content_sub_title',
                'value' => 'Experience the perfect blend of exquisite cuisine, exceptional service, and a welcoming atmosphere. Choose us to discover why we are the best choice'
            ],
        ]);
    }
}
