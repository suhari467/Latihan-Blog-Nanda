@extends('layouts.main')
@section('content')
    <article class="blog-post mt-5">
        <h2 class="display-5 link-body-emphasis mb-1">{{ $post->title }}</h2>
        <p class="blog-post-meta">{{ date('d M Y', strtotime($post->created_at))}} ({{$post->created_at->diffForHumans()}}) by <a href="{{ url('posts/user')}}/{{ $post->user->id}}">{{$post->user->name}}</a> | <a href="{{ url('category_post') }}/{{ $post->category_post->slug }}">{{ $post->category_post->name }}</a></p>

        <div class="d-flex justify-content-center mb-3">
            <img src="{{ url('storage/post')}}/{{ $post->image }}" alt="{{ $post->title }}" class="w-50">
        </div>

        {!! $post->body !!}
    </article>
@endsection
