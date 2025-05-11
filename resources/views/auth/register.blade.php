@extends('layouts.guest')
@section('content')
<main class="form-signin w-100 m-auto">
    <form action="{{ url('register') }}" method="post">
        @csrf
      <h1 class="h3 mb-3 fw-normal">{{ $title }}</h1>
  
      <div class="form-floating">
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
        <label for="floatingInput">Nama Lengkap</label>
        @error('name')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="form-floating">
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}">
        <label for="floatingInput">Email address</label>
        @error('email')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="form-floating">
        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password">
        <label for="floatingPassword">Password</label>
        @error('password')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="form-floating">
        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="Password">
        <label for="floatingPassword">Confirm Password</label>
        @error('password_confirmation')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>
  
      <button class="btn btn-primary w-100 py-2" type="submit">Register Now</button>
      <p class="mt-5 mb-3 text-body-secondary">&copy; {{ date('D, d/m/Y') }}</p>
    </form>
  </main>
@endsection