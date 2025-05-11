@extends('layouts.main')
@section('content')
        <div class="row mt-5">
          <div class="col-12 text-center">
            <h2>List Postingan 
              {{ $category_post ? ': Kategori ' . $category_post->name : ''}}
              {{ $user ? ': Author ' . $user->name : ''}}
              @if (request('search'))
                  : Search {{ request('search') }}
              @endif
              @if (request('category'))
                  : Kategori {{ request('category') }}
              @endif
            </h2>
          </div>
        </div>
        <div class="row justify-content-center mt-3">
          <div class="col-lg-6 col-12">
            <form action="{{ url('posts') }}">
              <div class="input-group mb-3">
                <input type="text" class="form-control" name="search" id="search" value="{{ old('search') }}" placeholder="Cari Data Postingan" aria-label="Cari Data Postingan" aria-describedby="button-search">
                <button class="btn btn-outline-secondary" type="submit" id="button-search"><i class="fas fa-search"></i> Cari</button>
              </div>
            </form>
          </div>
        </div>
        <div class="row row-cols-2 mb-2 mt-5">
            @foreach ($posts as $item)
            <div class="col">
              <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                <div class="col p-4 d-flex flex-column position-static">
                  <strong class="d-inline-block mb-2 text-primary-emphasis">
                    <a href="{{ url('posts') }}/?category={{ $item->category_post->slug }}">
                      {{ $item->category_post->name }}
                    </a>
                  </strong>
                  <h3 class="mb-0">{{ $item->title }}</h3>
                  <div class="mb-1 text-body-secondary">{{ date('d M Y', strtotime($item->created_at))}}</div>
                  <p class="card-text mb-auto">
                    {{ implode(' ', array_slice(preg_split('/\s+/', strip_tags($item->body), -1, PREG_SPLIT_NO_EMPTY), 0, 20)) }}
                  </p>
                  <a href="{{ url('posts/post') }}/{{ $item->slug }}" class="icon-link gap-1 icon-link-hover">
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
        <div class="row mb-5">
            <div class="col-12 d-flex justify-content-center">
                {{ $posts->links() }}
            </div>
        </div>
@endsection