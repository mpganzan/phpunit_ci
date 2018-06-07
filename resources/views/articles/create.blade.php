@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Article Form</div>

                <div class="card-body">
                    <form action="{{ route('articles.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control">
                            @if ($errors->has('title'))
                                <small class="help-block text-danger">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </small>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea name="content" class="form-control" rows="5"></textarea>
                            @if ($errors->has('content'))
                                <small class="help-block text-danger">
                                    <strong>{{ $errors->first('content') }}</strong>
                                </small>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
