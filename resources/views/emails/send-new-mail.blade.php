<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Questa è l'email</h1>

    <div>Title: {{ $new_post->title }}</div>

    <div>Content: {{ $new_post->content }}</div>

    @if ($new_post->cover)
        <div>Image:</div>
        <img class="w-25" src="{{ asset('storage/' . $new_post->cover) }}" alt="{{ $new_post->title }}">
    @endif

    <a href="{{ route('admin.posts.show', ['post' => $new_post->id]) }}">Go to the post page</a>
</body>
</html>