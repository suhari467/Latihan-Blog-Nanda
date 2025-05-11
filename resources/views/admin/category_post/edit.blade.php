@extends('layouts.main')
@section('content')
<div class="row mt-5">
  <div class="col">
    <form action="{{ route('category_post.index') }}/{{$category_post->slug}}" method="post" enctype="multipart/form-data">
      @method('put')
      @csrf
      <div class="mb-3">
        <label for="name" class="form-label">Nama Kategori</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $category_post->name) }}">
        @error('name')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="mb-3">
        <label for="slug" class="form-label">Slug</label>
        <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $category_post->slug) }}" readonly>
        @error('slug')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="mb-3">
        <label for="keterangan" class="form-label">Keterangan</label>
        <input type="text" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" value="{{ old('keterangan', $category_post->keterangan) }}">
        @error('keterangan')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="mb-3">
        <label for="image" class="form-label">Gambar</label>
        <div class="row">
          <div class="col-md-3">
            @if ($category_post->image)
              <img src="{{ url('storage/category_post') }}/{{ $category_post->image }}" alt="{{ $category_post->image }}" width="200" id="image-preview">
            @else
              <img src="{{ url('assets/img/blank-profile.png') }}" alt="Default-Profile" width="200" id="image-preview">
            @endif
          </div>
          <div class="col-md-9">
            <input type="hidden" name="old_image" value="{{ $category_post->image }}">
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" value="{{ old('image') }}" onchange="previewImage()">
            @error('image')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
</div>
@endsection

@section('javascript')
    <script>
      const name = document.querySelector('#name');
      const slug = document.querySelector('#slug');

      name.addEventListener('change', function(){
        fetch('/admin/check-slug/category_post?name=' + name.value)
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