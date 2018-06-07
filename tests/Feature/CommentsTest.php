<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentsTest extends TestCase
{
    use RefreshDatabase;

    protected $article;

    public function setUp()
    {
        parent::setUp();

        $this->withExceptionHandling();

        $this->article = factory('App\Article')
            ->create([
                'user_id' => factory('App\User')->create()->id
            ]);
    }

    /** @test */
    public function it_should_prevent_unauthenticated_user_to_comment_to_an_article()
    {
        $comment = factory('App\Comment')->make();

        $this->post(route('articles.comments.store', $this->article->id), $comment->toArray())
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function it_should_allow_authenticated_user_to_post_a_comment()
    {
        $this->signIn();

        $comment = factory('App\Comment')->make();

        $this->post(route('articles.comments.store', $this->article->id), $comment->toArray());

        $this->assertDatabaseHas('comments', $comment->toArray());
    }
}
