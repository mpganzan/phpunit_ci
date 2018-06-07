<div class="card mb-md-3">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h4><a href="{{ $link }}">{{ $title }}</a></h4>
            <small> <i class="fa fa-clock-o"></i> {{ $published_time }}</small>
        </div>
        <small><i class="fa fa-user-o"></i> {{ $author }}</small>
    </div>

    <div class="card-body">
        {{ $content }}
    </div>
</div>
