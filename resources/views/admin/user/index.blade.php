@extends('layouts.main')
@section('content')
<div class="row mt-5">
  <div class="col">
    <a href="{{ route('user.create') }}" class="btn btn-primary">Tambah Data</a>
    <table class="table table-striped" id="myTable">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Email</th>
          <th>Level Pengguna</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($users as $user)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role->keterangan }}</td>
            <td>
              <a href="{{ url('admin/user') }}/{{ $user->id }}/edit" class="btn btn-sm btn-warning">Edit</a>
              <a href="{{ url('admin/user') }}/{{ $user->id }}/reset-password" class="btn btn-sm btn-secondary">Reset Password</a>
              <form action="{{ url('admin/user') }}/{{ $user->id }}" method="post" id="hapusForm-{{ $user->id }}" class="d-inline">
                @csrf
                @method('delete')
                <button class="btn btn-sm btn-danger hapus-user" name="hapusId" value="{{ $user->id }}" type="button">Hapus</button>
              </form>
            </td>
          </tr>            
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection