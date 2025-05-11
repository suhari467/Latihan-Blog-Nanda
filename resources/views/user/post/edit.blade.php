@extends('layouts.main')
@section('content')
<div class="row mt-5">
  <div class="col">
    <form action="{{ route('posts.index') }}/{{$post->slug}}" method="post" enctype="multipart/form-data">
      @method('put')
      @csrf
      <div class="mb-3">
        <label for="title" class="form-label">Judul Postingan</label>
        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $post->title) }}">
        @error('title')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="mb-3">
        <label for="slug" class="form-label">Slug</label>
        <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $post->slug) }}" readonly>
        @error('slug')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="mb-3">
        <label for="category_post_id" class="form-label">Kategori Postingan</label>
        <select name="category_post_id" id="category_post_id" class="form-control @error('category_post_id') is-invalid @enderror">
          @foreach ($category_post as $item)
              <option value="{{ $item->id }}" {{ old('category_post_id', $post->category_post_id) == $item->id ? 'selected' : ''}}>{{$item->name}}</option>
          @endforeach
        </select>
        @error('category_post_id')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="mb-3">
        <label for="body" class="form-label">Isi Postingan</label>
        <input type="hidden" class="form-control @error('body') is-invalid @enderror" id="body" name="body" value="{{ old('body', $post->body) }}">
        <trix-editor input="body"></trix-editor>
        @error('body')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="mb-3">
        <label for="image" class="form-label">Gambar</label>
        <div class="row">
          <div class="col-md-3">
            @if ($post->image)
              <img src="{{ url('storage/post') }}/{{ $post->image }}" alt="{{ $post->image }}" width="200" id="image-preview">
            @else
              <img src="{{ url('assets/img/blank-profile.png') }}" alt="Default-Profile" width="200" id="image-preview">
            @endif
          </div>
          <div class="col-md-9">
            <input type="hidden" name="old_image" value="{{ $post->image }}">
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" value="{{ old('image') }}" onchange="previewImage()">
            @error('image')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Edit</button>
    </form>
  </div>
</div>
@endsection

@section('javascript')
    <script type="text/javascript">
      const judul = document.querySelector('#title');
      const slug = document.querySelector('#slug');

      judul.addEventListener('change', function(){
        fetch('/user/check-slug/post?title=' + judul.value)
        .then(response => response.json())
        .then(data => slug.value = data.slug)
      });

      function previewImage(){
        const image = document.querySelector('#image');
        const imagePreview = document.querySelector('#image-preview');

        const oFRender = new FileReader();
        oFRender.readAsDataURL(image.files[0]);
        oFRender.onload = function(oFEvent) {
          imagePreview.src = oFEvent.target.result;
        }
      }
    </script>
@endsection