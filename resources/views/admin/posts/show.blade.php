@extends('layouts.dashboard')

@section('content')
    <div class="card showed_card">
        <div class="card-body">
            <h1 class="card-title">{{ $post->title }}</h1>

            <div>
                <span class="bold_text">Created at:</span> {{ $post->created_at }}
            </div>

            <div>
                <span class="bold_text">Updated at:</span> {{ $post->updated_at }}
            </div>

            <div>
                <span class="bold_text">Slug:</span> {{ $post->slug }}
            </div>

            <p class="card-text mt-5">
                <span class="bold_text">Text:</span> {{ $post->content }}
            </p>

            <a class="btn btn-primary" href="{{ route('admin.posts.edit', ['post' => $post->id]) }}" role="button">Edit</a>
        </div>
    </div>
@endsection