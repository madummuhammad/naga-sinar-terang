@extends('layouts.admin')

@section('title')
Edit User
@endsection

@section('container')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h5 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user-plus"></i></div>
                            Edit User
                        </h5>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-success" href="{{ route('user.index') }}">
                            <i class="me-1" data-feather="arrow-left"></i>
                            Kembali ke Semua Pengguna
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <section class="content">
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-header text-success">Informasi Akun</div>
                    <div class="card-body">
                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        <form action="{{ route('user.update',$item->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <!-- Form Row-->
                            <div class="mb-3">
                                <!-- Form Group (first name)-->
                                <div class="col-md-6">
                                    <label class="mb-1" for="name">Nama</label>
                                    <input class="form-control @error('name') is-invalid @enderror" name="name" type="text" value="{{$item->name}}"  required autofocus/>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message; }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <!-- Form Group (first name)-->
                                <div class="col-md-6">
                                    <label class="mb-1" for="hak_akses">Divisi/Jabatan</label>
                                    <select name="hak_akses" id="" class="form-control">
                                        <option value="receiver" @if($item->hak_akses=='receiver') selected @endif>Penerima</option>
                                        <option value="production" @if($item->hak_akses=='production') selected @endif>Produksi</option>
                                        <option value="qc" @if($item->hak_akses=='qc') selected @endif>QC</option>
                                        <option value="delivery" @if($item->hak_akses=='delivery') selected @endif>Delivery</option>
                                        <option value="admin" @if($item->hak_akses=='admin') selected @endif>Admin</option>
                                    </select>
                                    @error('hak_akses')
                                    <div class="invalid-feedback">
                                        {{ $message; }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <!-- Form Group (email address)-->
                            <div class="mb-3">
                                <div class="col-md-6">
                                    <label class="mb-1" for="email">Email</label>
                                    <input class="form-control @error('email') is-invalid @enderror" name="email" type="email" value="{{ $item->email }}" required/>
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message; }}
                                    </div>
                                    @enderror
                                </div>   
                            </div>

                            <!-- Form Group (Password)-->
                            <div class="mb-3">
                                <div class="col-md-6">
                                    <label class="mb-1" for="password">Password</label>
                                    <input class="form-control @error('password') is-invalid @enderror" name="password" type="password"  />
                                    <p>*Kosongkan jika tidak ingin mengubah password</p>
                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message; }}
                                    </div>
                                    @enderror
                                </div>   
                            </div>
                            <!-- Submit button-->
                            <div class="mb-3">
                                <div class="col-md-6">
                                    <button class="btn btn-primary btn-sm" type="submit">
                                        Tambah
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
</section>
</div>
@endsection
@push('addon-style')
<link rel="stylesheet" href="{{url('assets')}}/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="{{url('assets')}}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endpush

@push('addon-script')
<script src="{{url('assets')}}/plugins/select2/js/select2.full.min.js"></script>
<script>
    $(document).ready(function(){        
        $("select2").select2();
    })
</script>
@endpush

