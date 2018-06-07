<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_redirect_unauthenticated_user_to_login()
    {
        $this->get(route('articles.create'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function it_should_redirect_authenticated_user_to_create_page()
    {
        $this->signIn();

        $this->get(route('articles.create'))
            ->assertStatus(200)
            ->assertSee('Create Article Form');
    }

    /** @test */
    public function it_should_store_new_article_from_authenticated_user()
    {
        $this->signIn();

        $article = factory('App\Article')->make();

        $this->post(route('articles.store', $article->toArray()))
            ->assertSessionHas('success')
            ->assertRedirect(route('articles'));

        $this->assertDatabaseHas('articles', $article->toArray());
    }

    /** @test */
    public function it_should_not_store_article_from_unauthenticated_user()
    {
        $article = factory('App\Article')->make();

        $this->post(route('articles.store', $article->toArray()))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function it_should_require_a_title()
    {
        $this->publishArticle(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function it_should_require_a_content()
    {
        $this->publishArticle(['content' => null])
            ->assertSessionHasErrors('content');
    }

    protected function publishArticle($overrides = [])
    {
        $this->signIn();

        $overrides['user_id'] = auth()->id();

        $article = factory('App\Article')->make($overrides);

        return $this->post(route('articles.save', $article->toArray()));
    }
}
