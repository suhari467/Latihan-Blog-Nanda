@extends('layouts.main')
@section('content')
        <div class="p-4 p-md-5 mb-4 mt-5 rounded text-body-emphasis bg-body-secondary">
          <div class="col-lg-12 px-0">
            <h1 class="display-4 fst-italic">{{ $posts[0]->title }}</h1>
            <p class="lead my-3">
              {{ implode(' ', array_slice(preg_split('/\s+/', strip_tags($posts[0]->body), -1, PREG_SPLIT_NO_EMPTY), 0, 20)) }}
            </p>
            <p class="lead mb-0"><a href="{{ url('posts/post') }}/{{ $posts[0]->slug }}" class="text-body-emphasis fw-bold">Continue reading...</a></p>
          </div>
        </div>
      
        <div class="row row-cols-2 mb-2 mt-5">
          @foreach ($posts->skip(1) as $item)
          <div class="col">
            <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
              <div class="col p-4 d-flex flex-column position-static">
                <strong class="d-inline-block mb-2 text-primary-emphasis">{{ $item->category_post->name }}</strong>
                <h3 class="mb-0">{{ $item->title }}</h3>
                <div class="mb-1 text-body-secondary">{{ date('d M Y', strtotime($item->created_at))}}</div>
                <p class="card-text mb-auto">
                  {{ implode(' ', array_slice(preg_split('/\s+/', strip_tags($item->body), -1, PREG_SPLIT_NO_EMPTY), 0, 20)) }}
                </p>
                <a href="{{ url('posts/post') }}/{{ $item->slug }}" class="icon-link gap-1 icon-link-hover stretched-link">
                  Continue reading
                  <svg class="bi"><use xlink:href="#chevron-right"/></svg>
                </a>
              </div>
              <div class="col-auto d-none d-lg-block" style="width: 200px; height: 250px; overflow: hidden;">
                <img src="{{ url('storage/post') }}/{{ $item->image }}" alt="{{ $item->title }}" class="bd-placeholder-img img-fluid object-fit-cover w-100 h-100">
              </div>
            </div>
          </div>
          @endforeach
      </div>
@endsection