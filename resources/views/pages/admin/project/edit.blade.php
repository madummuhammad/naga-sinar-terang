@extends('layouts.admin')

@section('title')
Edit Project
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
                            Edit Project
                        </h5>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-success" href="{{ route('project.index') }}">
                            <i class="me-1" data-feather="arrow-left"></i>
                            Kembali ke Semua Project
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
                    <div class="card-header text-success">Edit Project</div>
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
                        <form action="{{ route('project.update',$item->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <!-- Form Row-->
                            <div class="mb-3">
                                <!-- Form Group (first name)-->
                                <div class="col-md-6">
                                    <label class="mb-1" for="no_po">No Po</label>
                                    <input class="form-control @error('no_po') is-invalid @enderror" name="no_po" type="text" value="{{$item->no_po}}"  required autofocus/>
                                    @error('no_po')
                                    <div class="invalid-feedback">
                                        {{ $message; }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <!-- Form Group (first name)-->
                                <div class="col-md-6">
                                    <label class="mb-1" for="no_po">Customer</label>
                                    <input class="form-control @error('customer') is-invalid @enderror" name="customer" type="text" value="{{$item->customer}}"  required autofocus/>
                                    @error('customer')
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
                                        Ubah
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

