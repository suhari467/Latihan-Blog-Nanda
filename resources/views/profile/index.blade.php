@extends('layouts.main')
@section('content')
    <div class="row mt-5">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4>Profile Account</h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <td>Nama Lengkap</td>
                            <td>:</td>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td>Alamat Email</td>
                            <td>:</td>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <td>Level Pengguna</td>
                            <td>:</td>
                            <td>{{ $user->role->keterangan }}</td>
                        </tr>
                        <tr>
                            <td>Terdaftar Sejak</td>
                            <td>:</td>
                            <td>{{ date('d/m/Y', strtotime($user->created_at)) }}</td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfile">Edit Profile</button>
                    <a class="btn btn-warning" href="{{ url('account/password') }}">Reset Password</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
<div class="modal fade" id="editProfile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Profile</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ url('account/update')}}" method="post">
            @csrf
        <div class="modal-body">
                <div class="mb-3">
                  <label for="name" class="form-label">Nama Lengkap</label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}">
                  @error('name')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Alamat Email</label>
                  <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}">
                  @error('email')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
              
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
      </div>
    </div>
  </div>
@endsection