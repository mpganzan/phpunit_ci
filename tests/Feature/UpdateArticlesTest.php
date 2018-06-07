<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateArticlesTest extends TestCase
{
    use RefreshDatabase;

    protected $article;

    public function setUp()
    {
        parent::setUp();

        $this->withExceptionHandling();

        $this->signIn();

        $this->article = factory('App\Article')->create(['user_id' => auth()->id()]);
    }

    /** @test */
    public function it_can_be_updated_by_its_owner()
    {
        $this->patch(route('articles.update', $this->article->id), [
            'title' => 'Changed',
            'content' => 'Changed content.'
        ]);

        tap($this->article->fresh(), function ($article) {
            $this->assertEquals('Changed', $article->title);
            $this->assertEquals('Changed content.', $article->content);
        });
    }

    /** @test */
    public function it_should_require_title_and_content()
    {
        $this->patch(route('articles.update', $this->article->id), [
            'title' => 'Changed'
        ])->assertSessionHasErrors('content');

        $this->patch(route('articles.update', $this->article->id), [
            'content' => 'Changed content.'
        ])->assertSessionHasErrors('title');
    }

    /** @test */
    public function it_should_prevent_unauthorize_user_to_update_article()
    {
        $article = factory('App\Article')->create([
            'user_id' => factory('App\User')->create()->id
        ]);

        $this->patch(route('articles.update', $article->id), [])
             ->assertStatus(403);
    }
}
