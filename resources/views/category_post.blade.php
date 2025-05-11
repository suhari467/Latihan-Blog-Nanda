@extends('layouts.main')
@section('content')      
        <div class="row row-cols-4 mb-2 mt-5">
            @foreach ($category_post as $item)
            <div class="col">
              <div class="card" style="width: 18rem;">
                  <div style="width: 18rem; height: 250px; overflow: hidden;">
                    <img src="{{ url('storage/category_post') }}/{{ $item->image }}" class="card-img-top img-fluid object-fit-cover w-100 h-100" alt="{{ $item->image }}">
                  </div>
                  <div class="card-body">
                    <h5 class="card-title">{{ $item->name }}</h5>
                    <p class="card-text">{{ $item->keterangan}}</p>
                    <a href="{{ url('posts') }}/?category={{ $item->slug }}" class="btn btn-primary">Lihat Postingan</a>
                  </div>
                </div>
            </div>
            @endforeach
        </div>
@endsection