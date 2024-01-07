@extends('layouts.admin')

@section('title')
Pengguna
@endsection

@section('container')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>User</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">Dasboard</a></li>
            <li class="breadcrumb-item active">User</li>
          </ol>
        </div>
      </div>
    </div>
  </section>
  <section class="content">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">User</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="d-flex justify-content-end my-2">
          <a href="{{route('user.create')}}" class="btn btn-primary btn-xs">Tambah +</a>
        </div>
        {{-- Alert --}}
        @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @endif
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
        {{-- List Data --}}
        <table class="table table-striped table-hover table-sm" id="crudTable">
          <thead>
            <tr>
              <th width="10">No.</th>
              <th>Nama</th>
              <th>Email</th>
              <th>Hak Akses</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>

  </section>
</div>
@endsection

@push('addon-script')
<script>
  var datatable = $('#crudTable').DataTable({
    processing: true,
    serverSide: true,
    ordering: true,
    ajax: {
          url: '{{ url()->current() }}', // Perbaiki tanda seru di sini
        },
        columns: [
        {
          "data": 'DT_RowIndex',
          orderable: false, 
          searchable: false
        },
        { data: 'name', name: 'name' },
        { data: 'email', name: 'email' },
        { data: 'hak_akses', name: 'hak_akses' },
        { 
          data: 'action', 
          name: 'action',
          orderable: false,
            searchable: false, // Perbaiki typo di sini
            width: '15%'
          },
          ]
        });
      </script>
      @endpush
