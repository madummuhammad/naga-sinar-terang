@extends('layouts.auth')

@section('main')
<div class="card-body login-card-body">
  <p class="login-box-msg">Sign in to start your session</p>
  @if (session()->has('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}    
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if (session()->has('loginError'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('loginError') }}    
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
<form action="/login" method="post">
    @csrf
    @method('post')
    <div class="input-group mb-3">
        <input type="email" class="form-control" name="email" placeholder="Email" required>
        <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
          </div>
      </div>
  </div>
  <div class="input-group mb-3">
      <input type="password" class="form-control" name="password" placeholder="Password"required>
      <div class="input-group-append">
        <div class="input-group-text">
          <span class="fas fa-lock"></span>
      </div>
  </div>
</div>
<div class="row">
  <div class="col-8">
  </div>
  <!-- /.col -->
  <div class="col-4">
    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
</div>
<!-- /.col -->
</div>
</form>

<p class="mb-1">
    <a href="forgot-password.html">Lupa password?</a>
</p>
</div>
@endsection