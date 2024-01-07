@extends('mobilelayout.main')

@section('title')
Tugas Anda
@endsection

@section('container')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6 d-flex justify-content-between">
          <h1>Tugas Anda</h1>
          @if(auth()->user()->hak_akses=='delivery')
          <a href="{{route('m.surat_jalan')}}" class="btn btn-primary btn-sm">Lihat Surat Jalan <i class="fas fa-envelope-open-text"></i></a>
          @endif
        </div>

      </div>
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
    </div>
  </section>
  <section class="content">
    @foreach($item as $item)
    <div class="card">
      <div class="card-header">
        <div class="d-flex align-items-center">
          <h3 class="card-title">{{$item->material->name}}</h3>
        </div>
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
        <table class="w-100">
          <tr>
            <td>Nama</td>
            <td>:{{$item->material->name}} </td>
          </tr>
          <tr>
            <td>Lot No</td>
            <td>: {{$item->material->lot}}</td>
          </tr>
          <tr>
            <td>Part No</td>
            <td>: {{$item->material->part_no}}</td>
          </tr>
          @if($item->material_condition=='Repair')
          <tr>
            <td>
              Kondisi Material
            </td>
            <td>

              :<b> {{$item->material_condition}}
              </td>
            </tr>
            @endif
            <tr>
              <td>Qty</td>
              <td>: {{$item->qty}}</td>
            </tr>
            <tr>
              <td>Status</td>
              <td>: 
                @if($item->status==1)
                Accepted
                @else
                Unaccepted
                @endif
              </td>
            </tr>
            @if(auth()->user()->hak_akses!=='receiver')
            <tr>
              <td>Detail</td>
              <td><a href="{{url('m')}}/{{$item->stock_location}}/{{$item->id}}" class="btn btn-primary btn-sm">Detail</a></td>
            </tr>
            @endif
          </table>
          @if(auth()->user()->hak_akses=='delivery')
          @if($item->status==1)
          <div class="d-flex justify-content-end align-items-center mt-2">
            <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modalPengiriman{{$item->id}}">Masukan ke List Pengiriman <i class="fas fa-list"></i></button>
          </div>
          @endif
          @endif
        </div>
      </div>

      <div class="modal fade" id="modalPengiriman{{$item->id}}">
        <div class="modal-dialog modal-md modal-dialog-centered">
          <div class="modal-content">
            <form action="{{ route('m.delivery.masukan',$item->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="modal-header">
                <h4 class="modal-title">Masukan ke Surat Jalan?</h4>
                <input type="text" name="project_id" value="{{$item->project_id}}" hidden>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-12">
                    <input type="text" name="material_id" value="{{$item->material->id}}" hidden>
                    <input type="text" name="stock_id" value="{{$item->id}}" hidden>
                    <div class="mb-3">
                      <label for="" class="form-label">Qty *</label>
                      <input type="number" name="qty" class="form-control @error('qty') is-invalid @enderror" value="{{$item->qty}}">
                      <div class="text-sm text-warning">
                        *Qty tidak boleh lebih dari jumlah yang ada
                      </div>
                      @error('qty')
                      <div class="invalid-feedback">
                        {{ $message; }}
                      </div>
                      @enderror
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="submit" class="btn btn-primary">Ajukan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      @endforeach
    </section>
  </div>
  @endsection
