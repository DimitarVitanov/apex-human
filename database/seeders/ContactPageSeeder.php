<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class ContactPageSeeder extends Seeder
{
    public function run(): void
    {
        $page = Page::updateOrCreate(
            ['slug' => 'contact'],
            [
                'title' => 'Contact',
                'meta_title' => 'Apex Human — Contact',
                'meta_description' => 'One email. We respond within 48 hours.',
                'is_published' => true,
                'sort_order' => 7,
            ]
        );

        $sections = [
            [
                'key' => 'hero',
                'type' => 'hero',
                'headline' => 'One email. We respond within 48 hours',
                'sort_order' => 1,
            ],
            [
                'key' => 'form',
                'type' => 'form',
                'metadata' => json_encode([
                    'success_message' => "Message sent. We'll respond within 48 hours.",
                    'email' => 'coach@apexhuman.co',
                    'instagram' => '@apexhumansystem',
                ]),
                'sort_order' => 2,
            ],
        ];

        foreach ($sections as $section) {
            $page->sections()->updateOrCreate(['key' => $section['key']], $section);
        }
    }
}
