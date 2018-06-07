<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    protected $article;

    public function setUp()
    {
        parent::setUp();

        $this->signIn();
        $this->article = factory('App\Article')->create(['user_id' => auth()->id()]);
    }

    /** @test */
    public function it_should_have_an_owner()
    {
        $this->assertInstanceOf(\App\User::class, $this->article->owner);
    }

    /** @test */
    public function it_should_have_an_excerpt()
    {
        $this->assertLessThanOrEqual(strlen($this->article->excerpt()), 240);
    }
}
