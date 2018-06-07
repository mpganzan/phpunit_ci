<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteCommentTest extends TestCase
{
    use RefreshDatabase;

    protected $article;
    protected $comment;

    public function setUp()
    {
        parent::setUp();

        $this->article = factory('App\Article')->create([
            'user_id' => factory('App\User')->create()->id
        ]);

        $this->comment = factory('App\Comment')->create([
            'user_id' => factory('App\User')->create()->id,
            'article_id' => $this->article->id
        ]);

    }

    /** @test */
    public function it_should_allow_comment_owner_to_delete_his_comment()
    {
        $this->signIn();

        $comment = factory('App\Comment')->create([
            'user_id' => auth()->id(),
            'article_id' => $this->article->id
        ]);

        $this->delete(route('articles.comments.delete', $comment->id))
             ->assertStatus(204);

        $this->assertDatabaseMissing('comments', $this->article->toArray());
    }

    /** @test */
    public function it_should_not_allow_other_users_to_delete_other_users_comment()
    {
        $this->signIn();

        $this->delete(route('articles.comments.delete', $this->comment->id))
             ->assertStatus(403);
    }

    /** @test */
    public function it_should_not_allow_unauthenticated_user_to_delete_a_comment()
    {
        $this->delete(route('articles.comments.delete', $this->comment->id))
             ->assertRedirect(route('login'));
    }
}
