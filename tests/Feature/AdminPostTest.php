<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminPostTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        $user = User::factory()->create();
        $user->is_admin = true; // not mass-assignable, set directly
        $user->save();

        return $user;
    }

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'title' => 'The Apex Mindset',
            'slug' => '',
            'category' => 'Mindset',
            'excerpt' => 'A short excerpt.',
            'body' => '<p>Hello world</p>',
            'featured_image' => '',
            'featured_image_alt' => '',
            'meta_title' => '',
            'meta_description' => '',
            'reading_time' => '5 min read',
            'is_published' => false,
            'published_at' => '',
        ], $overrides);
    }

    public function test_slug_is_auto_generated_from_title_when_left_blank(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/posts', $this->validPayload())
            ->assertRedirect('/admin/posts')
            ->assertSessionHas('success');

        $this->assertDatabaseHas('posts', [
            'title' => 'The Apex Mindset',
            'slug' => 'the-apex-mindset',
        ]);
    }

    public function test_publishing_without_a_date_sets_published_at_and_makes_post_visible(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/posts', $this->validPayload(['is_published' => true, 'published_at' => '']));

        $post = Post::first();

        $this->assertTrue((bool) $post->is_published);
        $this->assertNotNull($post->published_at, 'published_at should be auto-filled when publishing');
        // The public journal scope requires both flags — confirm it now surfaces.
        $this->assertTrue(Post::published()->whereKey($post->id)->exists());
    }

    public function test_duplicate_slug_is_a_validation_error_not_a_500(): void
    {
        $admin = $this->admin();
        $this->actingAs($admin)->post('/admin/posts', $this->validPayload(['title' => 'Repeat', 'slug' => 'repeat']));

        $this->actingAs($admin)
            ->post('/admin/posts', $this->validPayload(['title' => 'Repeat', 'slug' => 'repeat']))
            ->assertSessionHasErrors('slug');

        $this->assertSame(1, Post::where('slug', 'repeat')->count());
    }

    public function test_missing_required_fields_return_validation_errors(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/posts', $this->validPayload(['title' => '', 'body' => '', 'category' => '']))
            ->assertSessionHasErrors(['title', 'body', 'category']);
    }

    public function test_updating_a_post_keeps_its_own_slug_without_a_unique_conflict(): void
    {
        $admin = $this->admin();
        $this->actingAs($admin)->post('/admin/posts', $this->validPayload(['title' => 'Keeper', 'slug' => 'keeper']));
        $post = Post::first();

        $this->actingAs($admin)
            ->put("/admin/posts/{$post->id}", $this->validPayload(['title' => 'Keeper Updated', 'slug' => 'keeper']))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('posts', ['id' => $post->id, 'title' => 'Keeper Updated', 'slug' => 'keeper']);
    }

    public function test_admin_can_upload_a_featured_image(): void
    {
        Storage::fake('public');

        $response = $this->actingAs($this->admin())
            ->post('/admin/media', [
                'file' => UploadedFile::fake()->image('cover.jpg', 1200, 675),
                'collection' => 'posts',
            ]);

        $response->assertOk()
            ->assertJsonStructure(['id', 'url', 'path', 'filename']);

        Storage::disk('public')->assertExists($response->json('path'));
        $this->assertDatabaseHas('media', ['collection' => 'posts', 'filename' => 'cover.jpg']);
    }

    public function test_media_upload_rejects_non_images(): void
    {
        Storage::fake('public');

        $this->actingAs($this->admin())
            ->post('/admin/media', ['file' => UploadedFile::fake()->create('malware.pdf', 10, 'application/pdf')])
            ->assertSessionHasErrors('file');
    }

    public function test_non_admins_cannot_create_posts(): void
    {
        $user = User::factory()->create(); // is_admin defaults to false

        $this->actingAs($user)
            ->post('/admin/posts', $this->validPayload())
            ->assertForbidden();
    }
}
