@extends('layouts.main')
@section('content')
<div class="row mt-5">
  <div class="col">
    <a href="{{ route('category_post.create') }}" class="btn btn-primary">Tambah Data</a>
    <table class="table table-striped" id="myTable">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Slug</th>
          <th>Image</th>
          <th>Jumlah Post</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($category_posts as $category_post)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $category_post->name }}</td>
            <td>{{ $category_post->slug }}</td>
            <td>
              @if ($category_post->image)
                  <img src="{{ url('storage/category_post') }}/{{ $category_post->image }}" alt="{{ $category_post->image }}" width="100">
              @endif
            </td>
            <td>{{ $category_post->posts->count()}}</td>
            <td>
              <a href="{{ url('admin/category_post') }}/{{ $category_post->slug }}/edit" class="btn btn-sm btn-warning">Edit</a>
              <form action="{{ url('admin/category_post') }}/{{ $category_post->slug }}" method="post" id="hapusForm-{{ $category_post->slug }}" class="d-inline">
                @csrf
                @method('delete')
                <button class="btn btn-sm btn-danger hapus-category-post" name="hapusId" value="{{ $category_post->slug }}" type="button">Hapus</button>
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
      $('.hapus-category-post').on('click', function(){
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