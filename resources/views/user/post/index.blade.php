@extends('layouts.main')
@section('content')
<div class="row mt-5">
  <div class="col">
    <a href="{{ route('posts.create') }}" class="btn btn-primary">Tambah Data</a>
    <table class="table table-striped" id="myTable">
      <thead>
        <tr>
          <th>No</th>
          <th>Judul</th>
          <th>Kategori</th>
          <th>Slug</th>
          <th>Image</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($posts as $post)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $post->title }}</td>
            <td>{{ $post->category_post->name }}</td>
            <td>{{ $post->slug }}</td>
            <td>
              @if ($post->image)
                  <img src="{{ url('storage/post') }}/{{ $post->image }}" alt="{{ $post->image }}" width="100">
              @endif
            </td>
            <td>
              <a href="{{ url('user/posts') }}/{{ $post->slug }}/edit" class="btn btn-sm btn-warning">Edit</a>
              <form action="{{ url('user/posts') }}/{{ $post->slug }}" method="post" id="hapusForm-{{ $post->slug }}" class="d-inline">
                @csrf
                @method('delete')
                <button class="btn btn-sm btn-danger hapus-post" name="hapusId" value="{{ $post->slug }}" type="button">Hapus</button>
              </form>
            </td>
          </tr>            
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection

@section('javascript')
    <script>
      $('.hapus-post').on('click', function(){
        let id = $(this).val();
        Swal.fire({
          title: 'Perhatian!',
          text: 'Apakah ingin menghapus data tersebut ?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Lanjut',
          cancelButtonColor: '#d33',
        }).then((result) => {
          if (result.value === true) {
            $('#hapusForm-'+id).submit()
          }
        })
      });
    </script>
@endsection