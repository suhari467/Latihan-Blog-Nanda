@extends('layouts.main')
@section('content')
<div class="row mt-5">
  <div class="col">
    <form action="{{ url('account/password')}}" method="post">
      @csrf
      <div class="mb-3">
        <label for="old_password" class="form-label">Old Password</label>
        <input type="password" class="form-control @error('old_password') is-invalid @enderror" id="old_password" name="old_password">
        @error('old_password')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
        @error('password')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="mb-3">
        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation">
        @error('password_confirmation')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>
      <button type="submit" class="btn btn-primary">Reset</button>
    </form>
  </div>
</div>
@endsection