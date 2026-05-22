<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class HomePageSeeder extends Seeder
{
    public function run(): void
    {
        $page = Page::updateOrCreate(
            ['slug' => 'home'],
            [
                'title' => 'Home',
                'meta_title' => 'Apex Human — The Complete Fitness System',
                'meta_description' => 'One system. One coach. Twelve months. Built for men who refuse to make fitness a hobby.',
                'og_image' => '/images/og-share.jpg',
                'is_published' => true,
                'sort_order' => 1,
            ]
        );

        $sections = [
            [
                'key' => 'hero',
                'type' => 'hero',
                'eyebrow' => 'FOR THE MAN WHO REFUSES TO MAKE FITNESS A HOBBY',
                'headline' => 'The body to match the life you already built',
                'subheadline' => "Energy. Strength. Clarity. Longevity. Twelve months. One system. Built for men who don't have time to be a fitness project.",
                'quote' => "THE APEX ISN'T A BODY. IT'S A LIFE.",
                'cta_text' => 'Apply for Coaching',
                'cta_url' => '/apply',
                'image' => '/images/hero-atmospheric.webp',
                'image_alt' => 'Gold leaf texture',
                'sort_order' => 1,
            ],
            [
                'key' => 'problem',
                'type' => 'content',
                'eyebrow' => '01 · THE PROBLEM',
                'headline' => 'You already have what you wanted at twenty-five',
                'body' => "Except the body. The energy. The sleep. The clarity that used to come for free. You don't need more discipline. You've built a life on discipline. You don't need another protocol. You've tried them. You need a system that fits the life you've earned — not one that demands you rebuild your week around the gym.",
                'quote' => 'When did fitness stop fitting your life?',
                'sort_order' => 2,
            ],
            [
                'key' => 'transition_1',
                'type' => 'transition',
                'image' => '/images/transition-marble.webp',
                'image_alt' => 'Black marble with gold veins',
                'sort_order' => 3,
            ],
            [
                'key' => 'answer',
                'type' => 'content',
                'eyebrow' => '02 · THE ANSWER',
                'headline' => "You've tried the obvious things",
                'body' => "The trainer who turned every session into a workout for himself. The diet that worked for three weeks. The protocol that demanded six days in a gym you don't have time to visit. None of them were built for a man with a calendar. The Apex Method was. Built across eight years of working with men whose mornings are already accounted for — and who refuse to add another full-time job to their week.",
                'sort_order' => 4,
            ],
            [
                'key' => 'outcomes',
                'type' => 'outcomes',
                'eyebrow' => '03 · WHAT YOU GET BACK',
                'headline' => 'The life on the other side',
                'subheadline' => 'Not promises. The outcomes the system is built to deliver.',
                'metadata' => json_encode([
                    'outcomes' => [
                        'Energy that lasts the full day. No 3 PM crash. No second coffee at 5.',
                        'Sleep that actually resets the system. Hard mornings stop being a feature of your week.',
                        'Mental clarity for the decisions that matter — and the patience for the people who matter.',
                        'Bloodwork in the top decile for your age. Testosterone, thyroid, lipids, insulin — measured and moving.',
                        'A body that fits in suits, on beaches, and in mirrors. Lean, strong, and yours for decades.',
                        'Four hours a week. That\'s what the system asks of you. Total.',
                    ],
                ]),
                'sort_order' => 5,
            ],
            [
                'key' => 'method_intro',
                'type' => 'method',
                'body' => "The framework never changes. The application is yours alone. One meal a day. Three meals a day. Snacks between meetings. Training at 6 AM, or at 9 PM, or once on Tuesday and twice on Saturday. We don't have a single protocol. We have one system, applied to your life. Every plan fits on one page.",
                'image' => '/images/method-notebook.webp',
                'image_alt' => 'Leather notebook with fountain pen',
                'sort_order' => 6,
            ],
            [
                'key' => 'the_life',
                'type' => 'content',
                'eyebrow' => '04 · WHAT WE ACTUALLY SELL',
                'headline' => 'Not a body. A morning',
                'quote' => "Fitness shouldn't run your life. It should fuel it.",
                'body' => "We're not in the body composition business. We're in the life-margin business. The body is downstream of what we actually build: a system that gives you back your mornings, your evenings, your weekends, and your edge. The body comes. It always does. But it's not the product. The life is the product.",
                'sort_order' => 7,
            ],
            [
                'key' => 'transition_2',
                'type' => 'transition',
                'image' => '/images/transition-metal.webp',
                'image_alt' => 'Brushed metal surface with warm light',
                'sort_order' => 8,
            ],
            [
                'key' => 'standards',
                'type' => 'standards',
                'eyebrow' => '05 · HOW WE WORK',
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
                'sort_order' => 9,
            ],
            [
                'key' => 'stakes',
                'type' => 'stakes',
                'eyebrow' => '06 · THE STAKES',
                'quote' => "Another decade of the body you don't recognise. Or twelve months that hand you back your energy, your sleep, and your edge.",
                'image' => '/images/stakes-thread.webp',
                'image_alt' => 'Gold thread on black',
                'metadata' => json_encode([
                    'left_label' => 'The Drift',
                    'left_body' => 'Another protocol. Another supplement. Another year wondering when the energy stopped being free.',
                    'right_label' => 'The System',
                    'right_body' => 'One year. One coach. The body, the energy, and the blueprint you keep for life.',
                ]),
                'sort_order' => 10,
            ],
            [
                'key' => 'offer',
                'type' => 'offer',
                'eyebrow' => '07 · THE OFFER',
                'headline' => 'One coach. One system. Twelve months',
                'quote' => "We don't promise outcomes. We promise the system, the standards, the confidentiality, and the full attention of your coach — and yours alone — for twelve months.",
                'cta_text' => 'Apply for Coaching',
                'cta_url' => '/apply',
                'metadata' => json_encode([
                    'stats' => [
                        ['value' => '8', 'label' => 'Clients per quarter'],
                        ['value' => '12 mo.', 'label' => 'Commitment'],
                        ['value' => '1-on-1', 'label' => 'Format'],
                    ],
                ]),
                'sort_order' => 11,
            ],
            [
                'key' => 'manifesto',
                'type' => 'content',
                'eyebrow' => 'THE MANIFESTO',
                'headline' => 'Fitness shouldn\'t run your life. It should fuel it',
                'body' => "You didn't build what you have by accident. The career, the family, the momentum — all earned. But somewhere along the way, the body stopped keeping pace.\n\nNot because of laziness. Because of misplaced priorities, bad advice, and systems that were never designed for a man with an actual calendar.\n\nThe Apex Method exists for one reason: to give you back what used to come for free — the energy, the clarity, the physical edge — without asking you to become someone you're not.",
                'sort_order' => 12,
            ],
            [
                'key' => 'stats',
                'type' => 'stats',
                'metadata' => json_encode([
                    'stats' => [
                        ['value' => '8', 'label' => 'Clients per quarter'],
                        ['value' => '12', 'label' => 'Month commitment'],
                        ['value' => '4h', 'label' => 'Per week total'],
                        ['value' => '100%', 'label' => 'Private & confidential'],
                    ],
                ]),
                'sort_order' => 13,
            ],
            [
                'key' => 'pillars',
                'type' => 'pillars',
                'eyebrow' => 'THE SIX PILLARS',
                'headline' => 'One system. Six pillars. Built for life',
                'metadata' => json_encode([
                    'pillars' => [
                        ['numeral' => 'I', 'title' => 'Resistance Architecture', 'subtitle' => 'STRENGTH & STRUCTURE', 'body' => 'Compound movement patterns built around your schedule. Three to four sessions. Forty-five minutes. No ego lifting.'],
                        ['numeral' => 'II', 'title' => 'Nutritional Engineering', 'subtitle' => 'FUEL, NOT DIET', 'body' => 'One page. Your meals, your preferences, your travel schedule. We engineer nutrition around your life — not the other way around.'],
                        ['numeral' => 'III', 'title' => 'Recovery Systems', 'subtitle' => 'SLEEP & RESTORATION', 'body' => 'Sleep architecture, stress management, and recovery protocols. The most overlooked pillar — and the one that unlocks everything else.'],
                        ['numeral' => 'IV', 'title' => 'Metabolic Calibration', 'subtitle' => 'BLOODWORK & DATA', 'body' => 'Quarterly bloodwork. Testosterone, thyroid, lipids, insulin sensitivity. We measure what matters and move the numbers.'],
                        ['numeral' => 'V', 'title' => 'Movement Quality', 'subtitle' => 'MOBILITY & LONGEVITY', 'body' => 'Joint health, tissue quality, and movement patterns that keep you training at seventy. Prevention, not rehabilitation.'],
                        ['numeral' => 'VI', 'title' => 'Lifestyle Integration', 'subtitle' => 'CALENDAR & CONTEXT', 'body' => 'Travel protocols. Business dinner strategies. Weekend frameworks. The system bends to your calendar — never the reverse.'],
                    ],
                ]),
                'sort_order' => 14,
            ],
            [
                'key' => 'promise',
                'type' => 'quote',
                'quote' => 'The Apex isn\'t a body. It\'s a life. Master the basics. Ignore the rest.',
                'sort_order' => 15,
            ],
            [
                'key' => 'social_proof',
                'type' => 'social_proof',
                'eyebrow' => 'CLIENT RESULTS',
                'headline' => 'What the system delivers',
                'body' => 'We don\'t share names, photos, or stories without permission. We never will. Here\'s what our clients have chosen to share.',
                'metadata' => json_encode([
                    'testimonials' => [
                        ['name' => 'Client, 42 · CEO', 'quote' => 'I\'ve worked with trainers for fifteen years. This is the first time someone built a system around my calendar instead of asking me to build my calendar around a system.', 'result' => '-14kg body fat · bloodwork in top 5% for age'],
                        ['name' => 'Client, 38 · Founder', 'quote' => 'The sleep alone was worth it. I didn\'t realise how broken my recovery was until everything else started improving. Energy, focus, patience — all of it came back.', 'result' => 'Testosterone +40% · Sleep score 92'],
                        ['name' => 'Client, 45 · Managing Director', 'quote' => 'Four hours a week. That\'s what he asked for. I gave him four hours and got back my entire week. The clarity, the energy, the edge — it\'s all there again.', 'result' => '4h/week · 12 months · still going'],
                    ],
                ]),
                'sort_order' => 16,
            ],
            [
                'key' => 'for_whom',
                'type' => 'content',
                'eyebrow' => 'IS THIS FOR YOU?',
                'headline' => 'Built for men who already have what they wanted at twenty-five. Except the body',
                'body' => "You earn well. You lead teams, close deals, make decisions that matter. You've tried the obvious things — the trainer, the diet, the protocol that worked for three weeks.\n\nYou don't need more motivation. You don't need another app. You need a system that respects your time, fits your life, and delivers results you can measure.\n\nThe Apex Method is selective by design. Eight clients per quarter. Twelve-month commitment. One coach. Yours.",
                'sort_order' => 17,
            ],
            [
                'key' => 'newsletter',
                'type' => 'newsletter',
                'headline' => 'Not ready to apply?',
                'subheadline' => 'Get the Apex Letter. One email when it matters. No noise.',
                'sort_order' => 18,
            ],
            [
                'key' => 'cta',
                'type' => 'cta',
                'headline' => "The rest of your life starts here",
                'subheadline' => 'Eight spots per quarter. Application only. Twelve-month commitment.',
                'cta_text' => 'Apply for Coaching',
                'cta_url' => '/apply',
                'sort_order' => 19,
            ],
        ];

        foreach ($sections as $section) {
            $page->sections()->updateOrCreate(
                ['key' => $section['key']],
                $section
            );
        }
    }
}
