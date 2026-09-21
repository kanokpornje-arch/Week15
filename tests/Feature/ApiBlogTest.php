<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApiBlogTest extends TestCase
{
    use RefreshDatabase;

    public function test_reading_is_public_and_writing_requires_authentication(): void
    {
        $blog = Blog::factory()->create();
        $this->getJson('/api/blogs')->assertOk();
        $this->getJson('/api/blogs/'.$blog->id)->assertOk();
        $this->postJson('/api/blogs', [])->assertUnauthorized();
        $this->putJson('/api/blogs/1', [])->assertUnauthorized();
        $this->deleteJson('/api/blogs/1')->assertUnauthorized();
    }

    public function test_show_update_and_destroy_a_blog(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $blog = Blog::factory()->create(['status' => true]);
        $url = '/api/blogs/'.$blog->id;

        $this->getJson($url)->assertOk()->assertJsonPath('data.id', $blog->id);
        $this->putJson($url, ['title' => 'Updated', 'content' => 'Updated content'])
            ->assertOk()->assertJsonPath('data.title', 'Updated');
        $this->putJson($url, ['title' => 'Partial update', 'status' => false])
            ->assertOk()->assertJsonPath('data.content', 'Updated content')
            ->assertJsonPath('data.status', true);
        $this->assertDatabaseHas('blogs', ['id' => $blog->id, 'title' => 'Partial update']);

        $this->deleteJson($url)->assertOk()->assertJsonPath('status', 'success');
        $this->assertDatabaseMissing('blogs', ['id' => $blog->id]);
        $this->getJson($url)->assertNotFound();
        $this->putJson($url, ['title' => 'Missing'])->assertNotFound();
        $this->deleteJson($url)->assertNotFound();
    }

    public function test_invalid_update_does_not_change_the_blog(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $blog = Blog::factory()->create();

        foreach ([['title' => ''], ['title' => str_repeat('a', 256)], ['content' => null]] as $fields) {
            $this->putJson('/api/blogs/'.$blog->id, $fields)
                ->assertUnprocessable()->assertJsonValidationErrors(array_keys($fields));
        }

        $this->assertDatabaseHas('blogs', [
            'id' => $blog->id, 'title' => $blog->title, 'content' => $blog->content,
        ]);
    }

    public function test_list_is_paginated_with_newest_blogs_first(): void
    {
        Sanctum::actingAs(User::factory()->create());
        Blog::factory()->count(11)->create(['created_at' => now()->subDay()]);
        $newest = Blog::factory()->create(['created_at' => now()]);

        $this->getJson('/api/blogs')->assertOk()
            ->assertJsonCount(10, 'data')
            ->assertJsonPath('data.0.id', $newest->id)
            ->assertJsonPath('meta.total', 12);
        $this->getJson('/api/blogs?page=2')->assertOk()->assertJsonCount(2, 'data');
    }

    public function test_store_validates_and_creates_a_blog_resource(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $this->postJson('/api/blogs', [])->assertUnprocessable()
            ->assertJsonValidationErrors(['title', 'content']);
        $this->postJson('/api/blogs', ['title' => str_repeat('a', 256), 'content' => 'Text'])
            ->assertUnprocessable()->assertJsonValidationErrors('title');
        $this->assertDatabaseCount('blogs', 0);

        $this->postJson('/api/blogs', ['title' => 'บทความทดสอบ', 'content' => 'เนื้อหาบทความ'])
            ->assertCreated()->assertJsonPath('data.title', 'บทความทดสอบ')
            ->assertJsonPath('data.status', true);
        $this->assertDatabaseHas('blogs', ['title' => 'บทความทดสอบ', 'content' => 'เนื้อหาบทความ', 'status' => 1]);
    }
}
