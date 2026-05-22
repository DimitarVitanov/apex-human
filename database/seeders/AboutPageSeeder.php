<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class AboutPageSeeder extends Seeder
{
    public function run(): void
    {
        $page = Page::updateOrCreate(
            ['slug' => 'about'],
            [
                'title' => 'About',
                'meta_title' => 'Apex Human — About',
                'meta_description' => 'Eight years. Three countries. One conclusion. The fundamentals work. Everything else is noise.',
                'is_published' => true,
                'sort_order' => 2,
            ]
        );

        $sections = [
            [
                'key' => 'hero',
                'type' => 'hero',
                'headline' => "We don't sell coaching. We sell clarity",
                'subheadline' => 'Eight years. Three countries. One conclusion. The fundamentals work. Everything else is noise.',
                'sort_order' => 1,
            ],
            [
                'key' => 'manifesto',
                'type' => 'content',
                'headline' => 'The Manifesto',
                'body' => "You built the career. You built the business. You built the life.\n\nBut somewhere along the way, the body stopped keeping up. The energy dipped. The sleep broke. The clarity that used to come for free started costing everything.\n\nYou don't need another protocol. You've tried them. You don't need another trainer who makes you feel like a beginner. You don't need a meal plan that doesn't survive Monday lunch.\n\nYou need a system. One system, built around your life — not the other way around.\n\nThat's Apex Human.\n\nWe work with eight men per quarter. Twelve months each. One coach, one system, one page.\n\nWe don't promise transformations. We don't sell motivation. We build the structure that gives you back your mornings, your energy, your edge — and a body that matches the life you've already earned.\n\nThe Apex isn't a body. It's a life.",
                'sort_order' => 2,
            ],
            [
                'key' => 'standards',
                'type' => 'standards',
                'eyebrow' => 'THE STANDARDS',
                'headline' => 'The Apex Standards',
                'metadata' => json_encode([
                    'standards' => [
                        ['number' => '01', 'title' => 'Private by Default', 'body' => 'No photos. No names. No public stories. Ever.'],
                        ['number' => '02', 'title' => 'Selective by Design', 'body' => 'Only 8 clients per quarter. 12-month commitment.'],
                        ['number' => '03', 'title' => 'One Coach. Yours. For Twelve Months', 'body' => 'No rotation. No handoffs.'],
                        ['number' => '04', 'title' => 'One System. Personalised to Your Life', 'body' => 'The framework never changes. The application is yours.'],
                        ['number' => '05', 'title' => 'Plans Fit on One Page', 'body' => "If they don't, we built it wrong."],
                        ['number' => '06', 'title' => 'Four Hours a Week. Total', 'body' => 'Fitness as fuel, not as identity.'],
                        ['number' => '07', 'title' => 'Built for Life', 'body' => 'Not the next photo.'],
                    ],
                ]),
                'sort_order' => 3,
            ],
            [
                'key' => 'promise',
                'type' => 'content',
                'quote' => "We don't promise outcomes. We promise the system, the standards, the confidentiality, and the full attention of your coach — and yours alone — for twelve months.",
                'cta_text' => 'Apply for Coaching',
                'cta_url' => '/apply',
                'sort_order' => 4,
            ],
        ];

        foreach ($sections as $section) {
            $page->sections()->updateOrCreate(['key' => $section['key']], $section);
        }
    }
}
