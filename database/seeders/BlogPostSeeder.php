<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'The Six-Day Training Lie.',
                'slug' => 'the-six-day-training-lie',
                'category' => 'Training',
                'excerpt' => 'Why three sessions a week beats six — and what the research really says.',
                'reading_time' => '7 min read',
                'featured_image' => '/images/blog-training.webp',
                'featured_image_alt' => 'Training shoe on wooden floor',
                'meta_title' => 'The Six-Day Training Lie — Apex Human',
                'meta_description' => 'Why three sessions a week beats six — and what the research really says about training frequency.',
                'body' => "<p>If your training plan has you in the gym five, six, or seven days a week — and your body still looks the same — the problem isn't your work ethic. It's the program.</p>\n<p>The fitness industry sold you a lie. The lie says: more sessions, more volume, more time in the gym equals more muscle. The truth is simpler — and the science backs it.</p>\n<blockquote>You don't grow in the gym. You grow when you recover from the gym.</blockquote>\n<h2>What the Research Actually Says</h2>\n<p>The most cited meta-analysis on training frequency was conducted by Brad Schoenfeld and colleagues in 2016, then expanded in 2019. Their conclusion, after reviewing 25 experimental studies: when total weekly volume is equal, there is no significant difference in muscle growth between training a muscle group two times a week or six times a week.</p>\n<p>Read that again. Two sessions per muscle group per week produces the same hypertrophy as six — as long as total volume is matched.</p>\n<h2>Why More Isn't Better</h2>\n<p>Every set you perform is a stress signal sent to the body. A productive signal tells the body to adapt — get stronger, build more muscle, recover. A junk signal tells the body it's under attack and to defend itself by raising cortisol, suppressing testosterone, and disrupting sleep.</p>\n<p>The hidden cost of overtraining:</p>\n<ul>\n<li>Cortisol stays elevated — your body holds onto fat, especially around the midsection</li>\n<li>Sleep quality drops — recovery is impaired, hormones get dysregulated</li>\n<li>CNS fatigue accumulates — strength stalls, motivation crashes</li>\n<li>Joints and connective tissue break down — niggles become injuries</li>\n<li>You miss life — the gym eats your time, energy, and social bandwidth</li>\n</ul>\n<p>Six days a week in the gym is not discipline. It's a tax on every other part of your life. And the body it builds is rarely better than the body built in three.</p>\n<h2>The Apex Human Training Protocol</h2>\n<p>Three sessions per week. Each muscle group hit once or twice. Compound movements as the foundation. Every set works toward progressive overload — not the pump.</p>\n<h2>The Takeaway</h2>\n<ul>\n<li>Train three days per week, not six.</li>\n<li>Two working sets per exercise. More is junk volume.</li>\n<li>Rest three minutes between sets. Always.</li>\n<li>Work in the 4–10 rep range. Progressive overload, not pump.</li>\n<li>Rotate one exercise per movement pattern every 4–6 weeks.</li>\n<li>If the weight on the bar isn't going up, your physique isn't either.</li>\n</ul>\n<p><em>Apex Human accepts eight clients per quarter. If the system speaks to you, apply for coaching at apexhuman.co.</em></p>",
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(3),
            ],
            [
                'title' => 'You Don\'t Have a Diet Problem. You Have a Framework Problem.',
                'slug' => 'you-dont-have-a-diet-problem',
                'category' => 'Nutrition',
                'excerpt' => 'Why every diet you\'ve tried worked — and why every diet you\'ve tried failed.',
                'reading_time' => '7 min read',
                'featured_image' => '/images/morning-scene.webp',
                'featured_image_alt' => 'Minimalist room with morning light',
                'meta_title' => 'You Don\'t Have a Diet Problem — Apex Human',
                'meta_description' => 'Why every diet you tried worked and failed. The difference between a diet and a framework.',
                'body' => "<p>Every diet you've tried worked. Keto worked. Intermittent fasting worked. Paleo worked. The Mediterranean diet worked. Carnivore worked. They all worked — for three weeks, maybe six, maybe twelve if you were disciplined.</p>\n<p>Then they stopped. Not because the science was wrong. Because the application was impossible.</p>\n<blockquote>Diets fail because they require you to become someone else. Frameworks succeed because they adapt to who you already are.</blockquote>\n<h2>The Problem With Diets</h2>\n<p>Every diet shares the same fatal flaw: rigidity. They demand you reshape your entire week around a set of rules written for someone who doesn't have your schedule, your travel pattern, your Monday lunch meeting, your Thursday dinner with clients.</p>\n<p>The moment the diet meets reality, reality wins. And then comes the guilt spiral — which produces cortisol, which produces fat storage, which produces the exact body composition the diet was supposed to fix.</p>\n<h2>What a Framework Looks Like</h2>\n<p>A framework gives you boundaries, not rules. It tells you where the guardrails are and lets you drive. The Apex Nutrition Framework operates on four principles:</p>\n<ul>\n<li><strong>Protein target:</strong> 1.6–2.2g per kg of body weight, daily. Hit this number. Everything else has flexibility.</li>\n<li><strong>Meal timing is irrelevant:</strong> One meal, three meals, six meals — your call. Total daily intake is what matters.</li>\n<li><strong>Nothing is banned:</strong> Treats stay. Alcohol stays (within reason). The moment you ban a food, you create a craving.</li>\n<li><strong>Energy balance over time:</strong> Weekly averages matter more than daily perfection. A bad Tuesday means nothing if Saturday corrects.</li>\n</ul>\n<h2>The Takeaway</h2>\n<ul>\n<li>Stop following diets. Build a framework.</li>\n<li>Hit your protein target. Every day.</li>\n<li>Eat when it fits your schedule, not when a plan tells you to.</li>\n<li>Ban nothing. Moderate everything.</li>\n<li>Track weekly averages, not daily perfection.</li>\n</ul>\n<p><em>Apex Human accepts eight clients per quarter. If the system speaks to you, apply for coaching at apexhuman.co.</em></p>",
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(7),
            ],
            [
                'title' => 'Sleep Is Not a Reward. It\'s the Foundation.',
                'slug' => 'sleep-is-not-a-reward',
                'category' => 'Recovery',
                'excerpt' => 'Why sleep is the single highest-leverage input in the entire system — and how to fix yours.',
                'reading_time' => '7 min read',
                'featured_image' => '/images/gold-key.webp',
                'featured_image_alt' => 'Ornate gold key on dark velvet',
                'meta_title' => 'Sleep Is Not a Reward — Apex Human',
                'meta_description' => 'Why sleep is the single highest-leverage input in the fitness system and how to fix yours.',
                'body' => "<p>Most men treat sleep as a reward for finishing the day. It's the thing that happens after everything else is done — after the emails, after the show, after the scroll.</p>\n<p>This is backwards. Sleep is not the end of the day. Sleep is the beginning of tomorrow. And if tomorrow's performance matters to you — in the boardroom, in the gym, in the mirror — then sleep is the single highest-leverage input in the entire system.</p>\n<blockquote>Fix the sleep. Everything else follows.</blockquote>\n<h2>What the Research Says</h2>\n<p>Matthew Walker's research at UC Berkeley established what sports scientists had suspected: even moderate sleep restriction (6 hours instead of 8) reduces testosterone by 10–15%, impairs glucose metabolism, increases cortisol, and reduces muscle protein synthesis.</p>\n<p>The effects compound. One bad night is recoverable. Five bad nights change your blood chemistry.</p>\n<h2>The Apex Sleep Protocol</h2>\n<ul>\n<li><strong>Duration:</strong> 7.5–9 hours. Non-negotiable. If you say you function on 6, your bloodwork disagrees.</li>\n<li><strong>Caffeine:</strong> Cap at 200mg. None after 1 PM. Yes, even if you \"don't feel it.\"</li>\n<li><strong>Magnesium glycinate:</strong> 300–400mg, 30 minutes before bed. The single most effective legal sleep supplement.</li>\n<li><strong>Temperature:</strong> 18–19°C. Cool room, warm bed.</li>\n<li><strong>Screens:</strong> Off 60 minutes before bed. Or use blue-light blocking glasses if you must.</li>\n<li><strong>Consistency:</strong> Same bed time, same wake time. Weekends included.</li>\n</ul>\n<h2>The Takeaway</h2>\n<ul>\n<li>Sleep is the foundation. Not a luxury. Not a reward.</li>\n<li>Fix sleep before fixing training or nutrition.</li>\n<li>7.5 hours minimum. Track it.</li>\n<li>Magnesium glycinate before bed. Every night.</li>\n<li>Caffeine before 1 PM only.</li>\n</ul>\n<p><em>Apex Human accepts eight clients per quarter. If the system speaks to you, apply for coaching at apexhuman.co.</em></p>",
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(14),
            ],
        ];

        foreach ($posts as $post) {
            Post::updateOrCreate(['slug' => $post['slug']], $post);
        }
    }
}
