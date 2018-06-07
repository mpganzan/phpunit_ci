@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mt-md-5">
            <div class="d-flex mb-md-1 ">
                <h4>{{ $article->title }}</h4>
            </div>
            <div class="mb-md-5">
                <small><i class="fa fa-user-o"></i> {{ $article->owner->name }}</small>
                <small> <i class="fa fa-clock-o"></i> {{ $article->created_at }}</small>
            </div>
            <div class="d-flex">
                {{ $article->content }}
            </div>

            @can('update', $article)
                <div class="d-flex mt-md-5">
                    <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-primary mr-md-1"><i class="fa fa-pencil"></i> Edit</a>
                    <delete-button :article-id="{{ $article->id }}"></delete-button>
                </div>
            @endcan

            <comment-section :article-id="{{ $article->id }}" :auth-check="{{ auth()->check() ? auth()->id() : 0 }}"></comment-section>
        </div>
    </div>
</div>
@endsection
