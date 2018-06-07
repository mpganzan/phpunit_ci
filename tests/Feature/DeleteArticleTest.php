<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteArticleTest extends TestCase
{
    use RefreshDatabase;

    protected $article;

    public function setUp()
    {
        parent::setUp();

        $this->article = factory('App\Article')->create([
            'user_id' => factory('App\User')->create()->id
        ]);
    }

    /** @test */
    public function it_should_allow_owner_to_delete_their_article()
    {
        // $this->signIn();

        $article = factory('App\Article')->create(['user_id' => auth()->id()]);

        $this->delete(route('articles.delete', $article->id))
             ->assertStatus(204);

        $this->assertDatabaseMissing('articles', $article->toArray());
    }

    /** @test */
    public function it_should_prevent_users_to_delete_other_users_article()
    {
        $this->signIn();

        $this->delete(route('articles.delete', $this->article->id))
             ->assertStatus(403);
    }

    /** @test */
    public function it_should_prevent_unauthorize_user_to_delete_an_article()
    {
        $this->delete(route('articles.delete', $this->article->id))
             ->assertRedirect(route('login'));
    }
}
