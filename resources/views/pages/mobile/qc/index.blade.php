@extends('mobilelayout.main')

@section('title')
WIP Qc
@endsection

@section('container')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>WIP Qc</h1>
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
        <h3 class="card-title">WIP Qc</h3>

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
        @if($item)
        <table class="w-100">
          <tr>
            <td>Nama</td>
            <td>: {{$item->material->name}}</td>
          </tr>
          <tr>
            <td>Lot No</td>
            <td>: {{$item->material->lot}}</td>
          </tr>
          <tr>
            <td>Part No</td>
            <td>: {{$item->material->part_no}}</td>
          </tr>
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
          @if($item->foto!==null)
          <tr>
            <td>Bukti Terima</td>
            <td>
              <a target="_blank" href="{{ Storage::url($item->foto) }}">
                <img class="img-fluid" src="{{ Storage::url($item->foto) }}" alt=""></td>
              </a>
            </tr>
            @endif
          </table>
          @if($item->status==0)
          <div class="d-flex justify-content-center mt-2">
            <form action="{{route('m.accept',$item->id)}}" method="POST">
              @csrf
              @method('POST')       
              <button class="btn btn-primary">
                Accept <i class="fas fa-check"></i>
              </button>
            </form>
          </div>
          @else
          <div class="d-flex justify-content-center mt-2">      
            <button class="btn btn-secondary btn-sm btn-danger mr-1" data-toggle="modal" data-target="#modalPengajuanNcp">
              <i class="fas fa-paper-plane"></i> &nbsp;NCP
            </button>
            <button class="btn btn-secondary btn-sm btn-success mr-1" data-toggle="modal" data-target="#modalPengajuanFg">
              <i class="fas fa-paper-plane"></i> &nbsp;FG
            </button>
            <button class="btn btn-secondary btn-sm btn-primary mr-1" data-toggle="modal" data-target="#modalPengajuanRepair">
              <i class="fas fa-paper-plane"></i> &nbsp;REPAIR
            </button>
          </div>
          <div class="modal fade" id="modalPengajuanNcp">
            <div class="modal-dialog modal-md modal-dialog-centered">
              <div class="modal-content">
                <form action="{{ route('m.qc.ajukan_ncp',$item->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="modal-header">
                    <h4 class="modal-title">Ajukan WIP NCP</h4>
                    <input type="text" name="project_id" value="{{$item->project_id}}" hidden>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-12">
                        <input type="text" name="material_id" value="{{$item->material->id}}" hidden>
                        <div class="mb-3">
                          <label for="" class="form-label">Qty</label>
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
                        <div class="mb-3">
                          <label for="" class="form-label">Ketarangan</label>
                          <textarea name="description" id="" cols="30" rows="5" class="form-control  @error('description') is-invalid @enderror">{{old('description')}}</textarea>
                          @error('description')
                          <div class="invalid-feedback">
                            {{ $message; }}
                          </div>
                          @enderror
                        </div>
                        <div class="mb-3">
                          <label for="" class="form-label">Foto Bukti</label>
                          <input type="file" name="foto" accept=".jpg,.jpeg,.png" class="form-control  @error('foto') is-invalid @enderror" value="">
                          @error('foto')
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

          <div class="modal fade" id="modalPengajuanFg">
            <div class="modal-dialog modal-md modal-dialog-centered">
              <div class="modal-content">
                <form action="{{ route('m.qc.ajukan_fg',$item->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="modal-header">
                    <h4 class="modal-title">Ajukan WIP FG</h4>
                    <input type="text" name="project_id" value="{{$item->project_id}}" hidden>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-12">
                        <input type="text" name="material_id" value="{{$item->material->id}}" hidden>
                        <div class="mb-3">
                          <label for="" class="form-label">Qty</label>
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
                        <div class="mb-3">
                          <label for="" class="form-label">Ketarangan</label>
                          <textarea name="description" id="" cols="30" rows="5" class="form-control  @error('description') is-invalid @enderror">{{old('description')}}</textarea>
                          @error('description')
                          <div class="invalid-feedback">
                            {{ $message; }}
                          </div>
                          @enderror
                        </div>
                        <div class="mb-3">
                          <label for="" class="form-label">Foto Bukti</label>
                          <input type="file" name="foto" accept=".jpg,.jpeg,.png" class="form-control  @error('foto') is-invalid @enderror" value="">
                          @error('foto')
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

          <div class="modal fade" id="modalPengajuanRepair">
            <div class="modal-dialog modal-md modal-dialog-centered">
              <div class="modal-content">
                <form action="{{ route('m.qc.ajukan_repair',$item->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="modal-header">
                    <h4 class="modal-title">Ajukan WIP Repair</h4>
                    <input type="text" name="project_id" value="{{$item->project_id}}" hidden>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-12">
                        <input type="text" name="material_id" value="{{$item->material->id}}" hidden>
                        <div class="mb-3">
                          <label for="" class="form-label">Qty</label>
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
                        <div class="mb-3">
                          <label for="" class="form-label">Ketarangan</label>
                          <textarea name="description" id="" cols="30" rows="5" class="form-control  @error('description') is-invalid @enderror">{{old('description')}}</textarea>
                          @error('description')
                          <div class="invalid-feedback">
                            {{ $message; }}
                          </div>
                          @enderror
                        </div>
                        <div class="mb-3">
                          <label for="" class="form-label">Foto Bukti</label>
                          <input type="file" name="foto" accept=".jpg,.jpeg,.png" class="form-control  @error('foto') is-invalid @enderror" value="">
                          @error('foto')
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
          @endif
          @else
          <div class="alert alert-warning">
            Tidak ada data di ajukan
          </div>
          @endif
        </div>
      </div>

    </section>
  </div>
  @endsection
  @push('addon-script')
  <script>
    $(document).on('click', '.copy', function() {
      var linkToCopy = $(this).data('link');
      var textarea = document.createElement('textarea');
      textarea.value = linkToCopy;
      document.body.appendChild(textarea);
      textarea.select();
      document.execCommand('copy');
      document.body.removeChild(textarea);
      alert('Link berhasil di copy');
    });
  </script>
  @endpush
