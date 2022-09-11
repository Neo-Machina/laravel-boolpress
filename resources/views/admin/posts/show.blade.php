@extends('layouts.dashboard')

@section('content')
    <div class="card showed_card">
        <div class="card-body">
            <h1 class="card-title">{{ $post->title }}</h1>

            <div>
                <span class="bold_text">Created at:</span> {{ $post->created_at->format('Y F j') }}
            </div>

            @if ($dates_diff > 0)
                <div>
                    <span>Created {{ $dates_diff }} day{{ $dates_diff > 1 ? 's' : '' }} ago</span>
                </div>
                @else 
                <div>Created today</div>
            @endif

            <div>
                <span class="bold_text">Updated at:</span> {{ $post->updated_at->format('Y F j') }}
            </div>

            <div>
                <span class="bold_text">Slug:</span> {{ $post->slug }}
            </div>

            @if ($post->category)
                <div>
                    <span class="bold_text">Category:</span> {{ $post->category->name  }}
                </div>

                @else 
                <div>
                    <span class="bold_text">Category:</span> None
                </div>
            @endif

            <div>
                <span class="bold_text">Tags:</span> 

                @forelse ($post->tags as $tag)
                    {{ ($tag->name)}}{{!$loop->last ? ',' : ''}}
                @empty
                    none
                @endforelse
            </div>     

            <p class="card-text mt-5">
                <span class="bold_text">Text:</span> {{ $post->content }}
            </p>

            <a class="btn btn-primary mb-4" href="{{ route('admin.posts.edit', ['post' => $post->id]) }}" role="button">Edit</a>
            
            <form action="{{ route('admin.posts.destroy', ['post' => $post->id]) }}" method="post">
                @csrf
                @method('DELETE')

                <input type="submit" value="Delete" type="button" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">
            </form>
        </div>
    </div>
@endsection