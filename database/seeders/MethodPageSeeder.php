<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class MethodPageSeeder extends Seeder
{
    public function run(): void
    {
        $page = Page::updateOrCreate(
            ['slug' => 'method'],
            [
                'title' => 'The Method',
                'meta_title' => 'Apex Human — The Method',
                'meta_description' => 'One system. Personalised to your life. Built for life.',
                'is_published' => true,
                'sort_order' => 3,
            ]
        );

        $sections = [
            [
                'key' => 'hero',
                'type' => 'hero',
                'headline' => "The last coach you'll ever need",
                'subheadline' => 'One system. Personalised to your life. Built for life.',
                'sort_order' => 1,
            ],
            [
                'key' => 'outcomes',
                'type' => 'outcomes',
                'eyebrow' => 'WHAT YOU GET BACK',
                'headline' => 'The life on the other side',
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
                'sort_order' => 2,
            ],
            [
                'key' => 'pillars',
                'type' => 'pillars',
                'eyebrow' => 'THE SIX PILLARS',
                'headline' => 'The Apex Method',
                'metadata' => json_encode([
                    'pillars' => [
                        ['numeral' => 'I', 'title' => 'THE APEX PLATE', 'subtitle' => 'NUTRITION', 'body' => "Personalised to your lifestyle. Not a meal plan — a framework. One meal a day or three — your call. No foods are off-limits. No foods are banned. Treats stay. Nothing is banned. Designed for energy and longevity, not calorie obsession."],
                        ['numeral' => 'II', 'title' => 'THE APEX RECOVERY', 'subtitle' => 'SLEEP', 'body' => "The single biggest input that moves bloodwork, energy, and body composition. 7.5–9 hours. Magnesium glycinate (300–400mg before bed). Caffeine cut to 200mg, before 1 PM. Walk 15,000+ steps daily."],
                        ['numeral' => 'III', 'title' => 'THE APEX TRAINING', 'subtitle' => 'STRENGTH', 'body' => "Three sessions per week. 2 working sets per exercise. One exercise per muscle group. Rep ranges 4–10. Rest: 3 minutes between sets. Progressive overload — not the pump. Rotate exercises every 4–6 weeks."],
                        ['numeral' => 'IV', 'title' => 'THE APEX MIND', 'subtitle' => 'MINDSET', 'body' => "Simple beats complex. Done beats perfect. The system works when you stop chasing trends and commit. We don't sell motivation. We sell structure."],
                        ['numeral' => 'V', 'title' => 'THE APEX NERVOUS SYSTEM', 'subtitle' => 'STRESS & RESILIENCE', 'body' => "Walking, breath, stress hygiene. The overlooked pillar that compounds. High cortisol from overwork and over-training blocks every other result. We manage it deliberately."],
                        ['numeral' => 'VI', 'title' => 'THE APEX STACK', 'subtitle' => 'SUPPLEMENTATION', 'body' => "Creatine monohydrate (5g daily). Magnesium glycinate (300–400mg before bed). Vitamin D3 (4,000–5,000 IU daily). Ashwagandha KSM-66 (600mg daily). That's it. Evidence-based. No reliance."],
                    ],
                ]),
                'sort_order' => 3,
            ],
            [
                'key' => 'timeline',
                'type' => 'timeline',
                'eyebrow' => 'THE TIMELINE',
                'headline' => 'Twelve months. Four milestones',
                'metadata' => json_encode([
                    'milestones' => [
                        ['month' => 'Month 1', 'title' => 'System locked', 'body' => 'The plan fits in your life. Friction disappears.'],
                        ['month' => 'Month 3', 'title' => 'Visible results', 'body' => 'Energy stabilises. Body starts changing. Sleep is different.'],
                        ['month' => 'Month 6', 'title' => 'Stable', 'body' => 'Lean. The lifestyle is locked. No more decision fatigue.'],
                        ['month' => 'Month 12', 'title' => 'Lifestyle', 'body' => "The system is no longer a system. It's just how you live."],
                        ['month' => 'After 12', 'title' => 'Blueprint owned', 'body' => 'You keep every plan, every protocol. Forever.'],
                    ],
                ]),
                'sort_order' => 4,
            ],
            [
                'key' => 'how_it_works',
                'type' => 'content',
                'eyebrow' => 'HOW IT WORKS',
                'headline' => 'Your week with us',
                'metadata' => json_encode([
                    'items' => [
                        'Weekly check-in with your coach',
                        'Bloodwork review every 90 days',
                        'Unlimited messaging — same-day response',
                        'One-page blueprint — yours forever',
                    ],
                ]),
                'sort_order' => 5,
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
                'sort_order' => 6,
            ],
            [
                'key' => 'cta',
                'type' => 'content',
                'cta_text' => 'Apply for Coaching',
                'cta_url' => '/apply',
                'sort_order' => 7,
            ],
        ];

        foreach ($sections as $section) {
            $page->sections()->updateOrCreate(['key' => $section['key']], $section);
        }
    }
}
