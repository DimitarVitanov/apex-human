<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class JournalPageSeeder extends Seeder
{
    public function run(): void
    {
        $page = Page::updateOrCreate(
            ['slug' => 'journal'],
            [
                'title' => 'The Journal',
                'meta_title' => 'Apex Human — The Journal',
                'meta_description' => 'Deep articles. Evidence-based. Personal opinion. No trends. No bro-science.',
                'is_published' => true,
                'sort_order' => 5,
            ]
        );

        $sections = [
            [
                'key' => 'hero',
                'type' => 'hero',
                'headline' => 'The Apex Blog. No trends. No bro-science.',
                'subheadline' => 'Deep articles. Evidence-based. Personal opinion.',
                'sort_order' => 1,
            ],
        ];

        foreach ($sections as $section) {
            $page->sections()->updateOrCreate(['key' => $section['key']], $section);
        }
    }
}
