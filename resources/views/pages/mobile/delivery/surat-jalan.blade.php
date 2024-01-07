@extends('mobilelayout.main')

@section('title')
Surat Jalan
@endsection

@section('container')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Surat Jalan</h1>
        </div>
        <div class="col-sm-6 d-flex justify-content-end">
          <a href="{{url('m')}}" class="btn btn-warning btn-sm">Kembali</a>
        </div>
      </div>
    </div>
  </section>
  <section class="content">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Items</h3>

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
        @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        @endif
        @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          {{ session('error') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        @endif
        @if (session()->has('link'))
        <div class="d-flex justify-content-end">          
          <button class="btn btn-sm btn-primary mt-2 copy mb-2" data-link="{{session('link')}}">
            <i class="far fa-copy"></i> &nbsp; Copy Link
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
        @if($item && $item->delivered_stock)
        <form action="{{ route('m.surat_jalan') }}" method="POST" enctype="multipart/form-data">
          <div class="row">
            <div class="mb-2 col-6">
              <label for="" class="form-label">No. Dok</label>
              <input type="text" name="no_doc" class="form-control">
            </div>
            <div class="mb-2 col-6">
              <label for="" class="form-label">No Surat Jalan</label>
              <input type="text" name="no_sj" class="form-control">
            </div>
            <div class="mb-2 col-6">
              <label for="" class="form-label">Kepada</label>
              <input type="text" name="to" class="form-control">
            </div>
            <div class="mb-2 col-6">
              <label for="" class="form-label">Alamat</label>
              <input type="text" name="address" class="form-control">
            </div>
            <div class="mb-2 col-6">
              <label for="" class="form-label">No. Tel</label>
              <input type="text" name="phone" class="form-control">
            </div>
            <div class="mb-2 col-6">
              <label for="" class="form-label">Tanggal</label>
              <input type="date" name="date" class="form-control">
            </div>
          </div>
          @foreach($item->delivered_stock as $item)
          <table class="w-100">
            <tr>
              <td>Nama</td>
              <td>: {{$item->stock->material->name}}</td>
            </tr>
            <tr>
              <td>Lot No</td>
              <td>:{{$item->stock->material->lot}}</td>
            </tr>
            <tr>
              <td>Part No</td>
              <td>:{{$item->stock->material->part_no}}</td>
            </tr>
            <tr>
              <td>Qty</td>
              <td>:{{$item->stock->qty}}</td>
            </tr>
          </table>
          -------<br>
          @endforeach
          <div class="d-flex justify-content-center">
            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#kirim">Unduh dan Kirim</button>
          </div>
          <div class="modal fade" id="kirim">
            <div class="modal-dialog modal-md modal-dialog-centered">
              <div class="modal-content">

                @csrf
                <div class="modal-header">
                  <h5 class="modal-title">Anda yakin akan mengunduh dan kirim?</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="submit" class="btn btn-primary">Unduh dan Kirim</button>
                </div>

              </div>
            </div>
          </div>
        </form>
        @else
        <div class="alert alert-warning">
          Belum ada surat jalan
        </div>
        @endif
      </div>
    </div>

  </section>
</div>
@endsection
