<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class ApplyPageSeeder extends Seeder
{
    public function run(): void
    {
        $page = Page::updateOrCreate(
            ['slug' => 'apply'],
            [
                'title' => 'Apply',
                'meta_title' => 'Apex Human — Apply for Coaching',
                'meta_description' => 'We accept eight clients per quarter. If you are ready to commit twelve months, apply below.',
                'is_published' => true,
                'sort_order' => 4,
            ]
        );

        $sections = [
            [
                'key' => 'hero',
                'type' => 'hero',
                'headline' => "Think you're a fit? Let's find out.",
                'subheadline' => "We accept eight clients per quarter. We turn down most applicants. If you're ready to commit twelve months, fill out the application below. We review every application personally within 48 hours.",
                'sort_order' => 1,
            ],
            [
                'key' => 'form',
                'type' => 'form',
                'metadata' => json_encode([
                    'gates' => [
                        "I'm ready to commit to twelve months.",
                        'I can dedicate four hours a week to the system.',
                        'I understand pricing is discussed on the discovery call, not before.',
                        "I'm applying for myself, not to resell or repurpose this methodology.",
                    ],
                    'success_message' => "Application received. We review every application personally. You'll hear back within 48 hours.",
                ]),
                'sort_order' => 2,
            ],
        ];

        foreach ($sections as $section) {
            $page->sections()->updateOrCreate(['key' => $section['key']], $section);
        }
    }
}
