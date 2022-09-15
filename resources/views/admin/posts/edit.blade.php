@extends('layouts.dashboard')

@section('content')
    <h1>Edit the post</h1>

    <form action="{{ route('admin.posts.update', ['post' => $post->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $post->title) }}">
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select class="form-select" id="category_id" name="category_id" aria-label="Default select example">
                <option value="">None</option>

                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <div><strong>Tags</strong></div>

            @foreach ($tags as $tag)
                @if ($errors->any())
                    <div class="form-check">
                        <input class="form-check-input" 
                                type="checkbox" 
                                value="{{ $tag->id }}" 
                                id="tag-{{ $tag->id }}" 
                                name="tags[]"
                                {{ in_array($tag->id,old('tags', [])) ? 'checked' : ''}}>
                        <label class="form-check-label" for="tag-{{ $tag->id }}">
                            {{ $tag->name }}
                        </label>
                    </div>

                @else
                    <div class="form-check">
                        <input class="form-check-input" 
                                type="checkbox" 
                                value="{{ $tag->id }}" 
                                id="tag-{{ $tag->id }}" 
                                name="tags[]"
                                {{ $post->tags->contains($tag) ? 'checked' : ''}}>
                        <label class="form-check-label" for="tag-{{ $tag->id }}">
                            {{ $tag->name }}
                        </label>
                    </div>
                @endif
            @endforeach
        </div>
        

        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="floatingTextarea" name="content" rows="7">{{ old('content', $post->content) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input class="form-control" type="file" id="image" name="image">

            @if ($post->cover)
                <div class="mt-2">Currently image:</div>
                <img class="w-25 mt-3" src="{{ asset('storage/' . $post->cover) }}" alt="{{ $post->name }}">
            @endif
        </div>

        <div class="form-check">
            <input class="form-check-input" 
                    type="checkbox" 
                    value="remove-image" 
                    id="remove-image" 
                    name="remove-image">
            <label class="form-check-label" for="remove-image">
                Remove image
            </label>
        </div>
          
        <input type="submit" value="Edit">
    </form>    
@endsection