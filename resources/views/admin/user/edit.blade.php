@extends('layouts.main')
@section('content')
<div class="row mt-5">
  <div class="col">
    <form action="{{ route('user.index') }}/{{ $user->id }}" method="post">
      @method('put')
      @csrf
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
      <div class="mb-3">
        <label for="role_id" class="form-label">Level Pengguna</label>
        <select class="form-select @error('role_id') is-invalid @enderror" id="role_id" name="role_id" value="{{ old('role_id') }}">
          @foreach ($roles as $item)
          <option value="{{ $item->id }}" {{ old('role_id', $user->role_id) == $item->id ? 'selected' : ''}}> {{ $item->name }} </option>
          @endforeach
        </select>
        @error('role_id')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>
      
      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
</div>
@endsection