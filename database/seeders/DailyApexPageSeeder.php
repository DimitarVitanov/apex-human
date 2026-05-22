<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class DailyApexPageSeeder extends Seeder
{
    public function run(): void
    {
        $page = Page::updateOrCreate(
            ['slug' => 'daily-apex'],
            [
                'title' => 'Daily Apex',
                'meta_title' => 'Apex Human — Daily Apex',
                'meta_description' => 'One truth a day. No filler. The unfiltered truth on training, nutrition, sleep, and longevity.',
                'is_published' => true,
                'sort_order' => 6,
            ]
        );

        $sections = [
            [
                'key' => 'hero',
                'type' => 'hero',
                'headline' => 'One truth a day. No filler.',
                'subheadline' => 'Get the Daily Apex in your inbox.',
                'sort_order' => 1,
            ],
        ];

        foreach ($sections as $section) {
            $page->sections()->updateOrCreate(['key' => $section['key']], $section);
        }
    }
}
