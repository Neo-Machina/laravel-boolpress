@extends('layouts.dashboard')

@section('content')
    <h1>Posts List</h1>

    @if ($deleted_post_alert === 'yes')
        <div class="alert alert-primary" role="alert">
            Post successfully deleted!
        </div>
    @endif

    <div class="row row-cols-3">
        @foreach ($posts as $post)
            <div class="col mb-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">{{ $post->title }}</h3>
                        <a href="{{ route('admin.posts.show', ['post' => $post->id]) }}" class="btn btn-primary">Submit</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{ $posts->links() }}
@endsection