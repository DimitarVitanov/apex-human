<?php

namespace Database\Seeders;

use App\Models\DailyApex;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DailyApexPostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            ['headline' => 'On Energy', 'body' => "Most men don't have a fitness problem. They have an energy problem. Fix the sleep. Fix the bloodwork. Fix the steps. The body shows up second — and stays that way.", 'category' => 'Energy'],
            ['headline' => 'On Four Hours a Week', 'body' => "Four hours a week. That's what the system costs you. Three short training sessions. A walk every day. The food doesn't take extra time — you were going to eat anyway.", 'category' => 'Training'],
            ['headline' => 'On Bloodwork', 'body' => "If your coach hasn't asked for your bloodwork, he's guessing. Energy, sleep, body composition, mood — all downstream of numbers most men never check. Get the panel. Read it. Move it.", 'category' => 'Recovery'],
            ['headline' => 'On the 3 PM Crash', 'body' => "Most men chase the 3 PM crash with more coffee. The crash isn't a caffeine problem. It's a sleep problem. A bloodwork problem. A blood-sugar problem. A nervous-system problem. Coffee just hides it for two hours.", 'category' => 'Energy'],
            ['headline' => 'On Fitness as Hobby', 'body' => "When fitness becomes a hobby, it eats your week. We don't sell fitness as a hobby. We sell fitness as a tool. The system runs in the background. The life runs in the foreground.", 'category' => 'Mindset'],
            ['headline' => 'On Longevity', 'body' => "The body you have at fifty is built by what you do at forty. The body you have at seventy is built by what you do at fifty. Start now. The compound matters more than the intensity.", 'category' => 'Longevity'],
            ['headline' => 'On Decisions', 'body' => "The men who make the best decisions at work sleep eight hours, walk fifteen thousand steps, and lift three times a week. This isn't a fitness insight. It's a leadership insight.", 'category' => 'Mindset'],
            ['headline' => 'On the Suit Test', 'body' => "The mirror lies. The scale lies. The suit doesn't. If your suits fit the same in twelve months, your training was wrong. If they fit better, the rest takes care of itself.", 'category' => 'Training'],
            ['headline' => 'On Privacy', 'body' => "We don't post transformations. We don't share names. We don't run client photos. Discretion isn't a feature we offer. It's the condition of working with us.", 'category' => 'Mindset'],
            ['headline' => 'On Training for Life', 'body' => "Train for life. Not the next thirty days. Most fitness advice optimises for a photo. We optimise for a life.", 'category' => 'Longevity'],
        ];

        foreach ($posts as $i => $post) {
            DailyApex::updateOrCreate(
                ['headline' => $post['headline']],
                array_merge($post, [
                    'is_published' => true,
                    'published_at' => Carbon::now()->subDays($i),
                ])
            );
        }
    }
}
