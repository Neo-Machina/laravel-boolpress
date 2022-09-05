@extends('layouts.dashboard')

@section('content')
    <h1>Create a new post</h1>

    <form action="{{ route('admin.posts.store') }}" method="POST">
        @csrf

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
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="floatingTextarea" name="content" rows="7">{{ old('content') }}</textarea>
        </div>
          
        <input type="submit" value="Submit">
    </form>    
@endsection