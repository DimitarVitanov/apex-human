<?php

namespace Database\Seeders;

use App\Models\DailyApex;
use App\Models\NavigationItem;
use App\Models\Page;
use App\Models\Post;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ApexContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedAdmin();
        $this->seedSettings();
        $this->seedNavigation();
        $this->seedPages();
        $this->seedBlogPosts();
        $this->seedDailyApexPosts();
    }

    private function seedAdmin(): void
    {
        User::updateOrCreate(
            ['email' => 'coach@apexhuman.co'],
            [
                'name' => 'Apex Admin',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );
    }

    private function seedSettings(): void
    {
        $settings = [
            ['group' => 'brand', 'key' => 'site_name', 'value' => 'APEX HUMAN™', 'type' => 'text', 'label' => 'Site Name'],
            ['group' => 'brand', 'key' => 'tagline', 'value' => "The Apex isn't a body. It's a life.", 'type' => 'text', 'label' => 'Tagline'],
            ['group' => 'brand', 'key' => 'email', 'value' => 'coach@apexhuman.co', 'type' => 'text', 'label' => 'Contact Email'],
            ['group' => 'brand', 'key' => 'instagram', 'value' => '@apexhumansystem', 'type' => 'text', 'label' => 'Instagram Handle'],
            ['group' => 'brand', 'key' => 'instagram_url', 'value' => 'https://instagram.com/apexhumansystem', 'type' => 'text', 'label' => 'Instagram URL'],
            ['group' => 'brand', 'key' => 'copyright', 'value' => '© 2026 APEX HUMAN™ · ALL RIGHTS RESERVED · apexhuman.co', 'type' => 'text', 'label' => 'Copyright Line'],
            ['group' => 'seo', 'key' => 'default_meta_title', 'value' => 'Apex Human — The Complete Fitness System', 'type' => 'text', 'label' => 'Default Meta Title'],
            ['group' => 'seo', 'key' => 'default_meta_description', 'value' => 'One system. One coach. Twelve months. Built for men who refuse to make fitness a hobby.', 'type' => 'textarea', 'label' => 'Default Meta Description'],
            ['group' => 'seo', 'key' => 'og_image', 'value' => '/images/og-share.jpg', 'type' => 'text', 'label' => 'OG Image Path'],
            ['group' => 'footer', 'key' => 'footer_newsletter_headline', 'value' => 'Not ready to apply?', 'type' => 'text', 'label' => 'Footer Newsletter Headline'],
            ['group' => 'footer', 'key' => 'footer_newsletter_sub', 'value' => 'Get the Apex Letter. One email when it matters. No noise.', 'type' => 'text', 'label' => 'Footer Newsletter Sub'],
            ['group' => 'integrations', 'key' => 'calendly_url', 'value' => '', 'type' => 'text', 'label' => 'Calendly URL'],
            ['group' => 'integrations', 'key' => 'beehiiv_url', 'value' => '', 'type' => 'text', 'label' => 'Beehiiv Newsletter URL'],
        ];

        foreach ($settings as $s) {
            SiteSetting::updateOrCreate(['key' => $s['key']], $s);
        }
    }

    private function seedNavigation(): void
    {
        $items = [
            ['location' => 'header', 'label' => 'About', 'url' => '/about', 'sort_order' => 1],
            ['location' => 'header', 'label' => 'The Method', 'url' => '/method', 'sort_order' => 2],
            ['location' => 'header', 'label' => 'The Journal', 'url' => '/journal', 'sort_order' => 3],
            ['location' => 'header', 'label' => 'Contact', 'url' => '/contact', 'sort_order' => 4],
            ['location' => 'header', 'label' => 'Apply', 'url' => '/apply', 'sort_order' => 5, 'is_cta' => true],
            ['location' => 'footer', 'label' => 'Home', 'url' => '/', 'sort_order' => 1],
            ['location' => 'footer', 'label' => 'About', 'url' => '/about', 'sort_order' => 2],
            ['location' => 'footer', 'label' => 'Our Services', 'url' => '/method', 'sort_order' => 3],
            ['location' => 'footer', 'label' => 'The Journal', 'url' => '/journal', 'sort_order' => 4],
            ['location' => 'footer', 'label' => 'Daily Apex', 'url' => '/daily-apex', 'sort_order' => 5],
            ['location' => 'footer', 'label' => 'Contact', 'url' => '/contact', 'sort_order' => 6],
        ];

        foreach ($items as $item) {
            NavigationItem::updateOrCreate(
                ['location' => $item['location'], 'url' => $item['url']],
                $item
            );
        }
    }

    private function seedPages(): void
    {
        $this->call(HomePageSeeder::class);
        $this->call(AboutPageSeeder::class);
        $this->call(MethodPageSeeder::class);
        $this->call(ApplyPageSeeder::class);
        $this->call(JournalPageSeeder::class);
        $this->call(DailyApexPageSeeder::class);
        $this->call(ContactPageSeeder::class);
    }

    private function seedBlogPosts(): void
    {
        $this->call(BlogPostSeeder::class);
    }

    private function seedDailyApexPosts(): void
    {
        $this->call(DailyApexPostSeeder::class);
    }
}
