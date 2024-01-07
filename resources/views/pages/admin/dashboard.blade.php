@extends('layouts.admin')

@section('title')
Dashboard
@endsection

@section('container')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-4 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{$material_in}}</h3>

              <p>All Material</p>
            </div>

          </div>
        </div>
        <div class="col-lg-4 col-6">
          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{$fg}}</h3>

              <p>Total FG</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-6">
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{$delivered}}</h3>

              <p>Delivered</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
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
              <th>Customer</th>
              <th>No Po</th>
              <th>Lot No</th>
              <th>All Item</th>
              <th>Raw Material</th>
              <th>Produksi</th>
              <th>QC</th>
              <th>NCP</th>
              <th>FG</th>
              <!-- <th>Repair</th> -->
            </tr>
          </thead>
          <tbody>
            @php
            $no=1;
            @endphp
            @foreach($project as $project)
            @foreach($project->material as $material)
            <tr>
              <td>{{$no++}}</td>
              <td>{{$project->customer}}</td>
              <td>{{$project->no_po}}</td>
              <td>{{$material->lot}}</td>
              <td>{{$material->qty}}</td>
              <td>{{$material->productionQtySum}}</td>
              <td>{{$material->qcQtySum}}</td>
              <td>{{$material->fgQtySum}}</td>
              <td>{{$material->ncpQtySum}}</td>
              <td>{{$material->fgQtySum}}</td>
            </tr>
            @endforeach
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
@endsection