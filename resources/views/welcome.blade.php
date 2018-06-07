@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mb-md-4">
        <div class="col-md-8">
            <h1 class="page-header">Articles</h1>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach ($articles as $article)
                @component('components.article-card')
                    @slot('title')
                        {{ $article->title }}
                    @endslot

                    @slot('link')
                        {{ route('articles.show', $article->id) }}
                    @endslot

                    @slot('author')
                        {{ $article->owner->name }}
                    @endslot

                    @slot('published_time')
                        {{ $article->created_at }}
                    @endslot

                    @slot('content')
                        {{ $article->excerpt() }}
                    @endslot
                @endcomponent
            @endforeach
        </div>
    </div>
    <div class="row justify-content-center mt-md-3">
        {{ $articles->links() }}
    </div>
</div>
@endsection
