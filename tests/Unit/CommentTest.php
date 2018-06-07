<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    protected $comment;

    public function setUp()
    {
        parent::setUp();

        $this->signIn();

        $article = factory('App\Article')->create([
            'user_id' => auth()->id()
        ]);

        $this->comment = factory('App\Comment')->create([
            'user_id' => auth()->id(),
            'article_id' => $article->id
        ]);
    }

    /** @test */
    public function it_should_have_a_creator()
    {
        $this->assertInstanceOf(\App\User::class, $this->comment->user);
    }

    /** @test */
    public function it_should_belong_to_an_article()
    {
        $this->assertInstanceOf(\App\Article::class, $this->comment->article);
    }
}
