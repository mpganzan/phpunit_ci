<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateCommentTest extends TestCase
{
    use RefreshDatabase;

    protected $article;
    protected $comment;

    public function setUp()
    {
        parent::setUp();

        $this->signIn();

        $this->article = factory('App\Article')->create([
            'user_id' => factory('App\User')->create()->id
        ]);

        $this->comment = factory('App\Comment')->create([
            'user_id' => auth()->id(),
            'article_id' => $this->article->id
        ]);
    }

    /** @test */
    public function it_can_be_updated_by_its_owner()
    {
        $this->patch(route('articles.comments.update', $this->comment->id), [
            'content' => 'Changed comment.'
        ]);

        tap($this->comment->fresh(), function ($comment) {
            $this->assertEquals('Changed comment.', $comment->content);
        });
    }

    /** @test */
    public function it_should_require_content()
    {
        $this->patch(route('articles.comments.update', $this->comment->id), [])
             ->assertSessionHasErrors('content');
    }

    /** @test */
    public function it_should_prevent_user_to_delete_other_users_comment()
    {
        $comment = factory('App\Comment')->create([
            'user_id' => factory('App\User')->create()->id,
            'article_id' => $this->article->id
        ]);

        $this->patch(route('articles.comments.update', $comment->id), [])
             ->assertStatus(403);
    }
}
