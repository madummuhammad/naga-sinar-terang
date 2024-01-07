@extends('layouts.admin')

@section('title')
Material In
@endsection

@section('container')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Material In</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">Dasboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('receiver.index')}}">Project Anda</a></li>
            <li class="breadcrumb-item active">Material In</li>
          </ol>
        </div>
      </div>
    </div>
  </section>
  <section class="content">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Material In</h3>

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
          <a data-toggle="modal" data-target="#modal-xl" class="btn btn-primary btn-xs">Tambah +</a>
          <!-- <a data-toggle="modal" data-target="#modalAjukan" class="btn btn-secondary btn-xs ml-2">Ajukan semua ke Production</a> -->
          <div class="modal fade" id="modalAjukan">
            <div class="modal-dialog modal-sm modal-dialog-centered">
              <div class="modal-content">
                <form action="{{ route('receiver.ajukan') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="modal-header">
                    <h4 class="modal-title">Ajukan Material</h4>
                    <input type="text" name="project_id" value="{{$id}}" hidden>
                    <input type="text" name="type" value="all" hidden>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <h5>Anda yakin akan mengajukan material ke production?</h5>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary">Ajukan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="modal-xl">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <form action="{{ route('receiver.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                  <h4 class="modal-title">Tambah Material</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-12 col-lg-6">
                      <div class="mb-1">
                        <div class="mb-1">
                          <label class="mb-1" for="date_come">Tanggal Kedatangan *</label>
                          <input type="text" name="project_id" value="{{$id}}" hidden>
                          <input class="form-control @error('date_come') is-invalid @enderror" name="date_come" type="date" value="{{ old('date_come') }}"/>
                          @error('date_come')
                          <div class="invalid-feedback">
                            {{ $message; }}
                          </div>
                          @enderror
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-lg-6">
                      <div class="mb-1">
                        <div class="mb-1">
                          <label class="mb-1" for="name">Nama Material *</label>
                          <input class="form-control @error('name') is-invalid @enderror" name="name" type="text" value="{{ old('name') }}"/>
                          @error('name')
                          <div class="invalid-feedback">
                            {{ $message; }}
                          </div>
                          @enderror
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-lg-6">
                      <div class="mb-1">
                        <div class="mb-1">
                          <label class="mb-1" for="part_no">Part No *</label>
                          <input class="form-control @error('part_no') is-invalid @enderror" name="part_no" type="text" value="{{ old('part_no') }}"/>
                          @error('part_no')
                          <div class="invalid-feedback">
                            {{ $message; }}
                          </div>
                          @enderror
                        </div>
                      </div>
                    </div>
          <!--           <div class="col-12 col-lg-6">
                      <div class="mb-1">
                        <div class="mb-1">
                          <label class="mb-1" for="dimensi">Dimensi *</label>
                          <input class="form-control @error('dimensi') is-invalid @enderror" name="dimensi" type="text" value="{{ old('dimensi') }}"/>
                          @error('dimensi')
                          <div class="invalid-feedback">
                            {{ $message; }}
                          </div>
                          @enderror
                        </div>
                      </div>
                    </div> -->
                    <div class="col-12 col-lg-6">
                      <div class="mb-1">
                        <div class="mb-1">
                          <label class="mb-1" for="lot">Lot *</label>
                          <input class="form-control @error('lot') is-invalid @enderror" name="lot" type="text" value="{{ old('lot') }}"/>
                          @error('lot')
                          <div class="invalid-feedback">
                            {{ $message; }}
                          </div>
                          @enderror
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-lg-6">
                      <div class="mb-1">
                        <div class="mb-1">
                          <label class="mb-1" for="qty">Qty *</label>
                          <input class="form-control @error('qty') is-invalid @enderror" name="qty" type="number" value="{{ old('qty') }}"/>
                          @error('qty')
                          <div class="invalid-feedback">
                            {{ $message; }}
                          </div>
                          @enderror
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-lg-6">
                      <div class="mb-1">
                        <div class="mb-1">
                          <label class="mb-1" for="satuan">Satuan *</label>
                          <input class="form-control @error('satuan') is-invalid @enderror" name="satuan" type="text" value="{{ old('satuan') }}"/>
                          @error('satuan')
                          <div class="invalid-feedback">
                            {{ $message; }}
                          </div>
                          @enderror
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-lg-6">
                      <div class="mb-1">
                        <div class="mb-1">
                          <label class="mb-1" for="plant">Plant *</label>
                          <input class="form-control @error('plant') is-invalid @enderror" name="plant" type="text" value="{{ old('plant') }}"/>
                          @error('plant')
                          <div class="invalid-feedback">
                            {{ $message; }}
                          </div>
                          @enderror
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-lg-6">
                      <div class="mb-1">
                        <div class="mb-1">
                          <label class="mb-1" for="lokasi_simpan">Lokasi Simpan *</label>
                          <input class="form-control @error('lokasi_simpan') is-invalid @enderror" name="lokasi_simpan" type="text" value="{{ old('lokasi_simpan') }}"/>
                          @error('lokasi_simpan')
                          <div class="invalid-feedback">
                            {{ $message; }}
                          </div>
                          @enderror
                        </div>
                      </div>
                    </div>
<!--                     <div class="col-12 col-lg-6">
                      <div class="mb-1">
                        <div class="mb-1">
                          <label class="mb-1" for="dari">Dari *</label>
                          <input class="form-control @error('dari') is-invalid @enderror" name="dari" type="text" value="{{ old('dari') }}"/>
                          @error('dari')
                          <div class="invalid-feedback">
                            {{ $message; }}
                          </div>
                          @enderror
                        </div>
                      </div>
                    </div> -->
                    <div class="col-12 col-lg-6">
                      <div class="mb-1">
                        <div class="mb-1">
                          <label class="mb-1" for="no_sj">No SJ *</label>
                          <input class="form-control @error('no_sj') is-invalid @enderror" name="no_sj" type="text" value="{{ old('no_sj') }}"/>
                          @error('no_sj')
                          <div class="invalid-feedback">
                            {{ $message; }}
                          </div>
                          @enderror
                        </div>
                      </div>
                    </div>
              <!--       <div class="col-12 col-lg-6">
                      <div class="mb-1">
                        <div class="mb-1">
                          <label class="mb-1" for="total_box">Total Box *</label>
                          <input class="form-control @error('total_box') is-invalid @enderror" name="total_box" type="number" value="{{ old('total_box') }}"/>
                          @error('total_box')
                          <div class="invalid-feedback">
                            {{ $message; }}
                          </div>
                          @enderror
                        </div>
                      </div>
                    </div> -->
                    <div class="col-12 col-lg-6">
                      <div class="mb-1">
                        <div class="mb-1">
                          <label class="mb-1" for="no_mobil">No Mobil *</label>
                          <input class="form-control @error('no_mobil') is-invalid @enderror" name="no_mobil" type="text" value="{{ old('no_mobil') }}"/>
                          @error('no_mobil')
                          <div class="invalid-feedback">
                            {{ $message; }}
                          </div>
                          @enderror
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-lg-6">
                      <div class="mb-1">
                        <div class="mb-1">
                          <label class="mb-1" for="driver">Driver *</label>
                          <input class="form-control @error('driver') is-invalid @enderror" name="driver" type="text" value="{{ old('driver') }}"/>
                          @error('driver')
                          <div class="invalid-feedback">
                            {{ $message; }}
                          </div>
                          @enderror
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-lg-6">
                      <div class="mb-1">
                        <div class="mb-1">
                          <label class="mb-1" for="keterangan">Keterangan *</label>
                          <input class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" type="text" value="{{ old('keterangan') }}"/>
                          @error('keterangan')
                          <div class="invalid-feedback">
                            {{ $message; }}
                          </div>
                          @enderror
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-lg-6">
                      <div class="mb-1">
                        <div class="mb-1">
                          <label class="mb-1" for="category">Category *</label>
                          <input class="form-control @error('category') is-invalid @enderror" name="category" type="text" value="{{ old('category') }}"/>
                          @error('category')
                          <div class="invalid-feedback">
                            {{ $message; }}
                          </div>
                          @enderror
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
              </form>
            </div>
          </div>
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
              <th>Part Name</th>
              <th>Part No</th>
              <th>Lot No</th>
              <th>Qty</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>


    <div class="card">
      <div class="card-header">
        <h3 class="card-title">History</h3>

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
        <table class="table table-striped table-hover table-sm" id="historyTable">
          <thead>
            <tr>
              <th width="10">No.</th>
              <th>Part Name</th>
              <th>Part No</th>
              <th>Lot No</th>
              <th>Qty</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>

  </section>
</div>
@foreach($item as $item)
<div class="modal fade" id="updateModal{{$item->material->id}}">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form action="{{ route('receiver.update',$item->material->id) }}" method="POST" enctype="multipart/form-data">
        @method('PUT');
        @csrf
        <div class="modal-header">
          <h4 class="modal-title">Update Material</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12 col-lg-6">
              <div class="mb-1">
                <!-- Form Row-->
                <div class="mb-1">
                  <label class="mb-1" for="date_come">Tanggal Kedatangan *</label>
                  <input type="text" name="project_id" value="{{$id}}" hidden>
                  <input class="form-control @error('date_come') is-invalid @enderror" name="date_come" type="text" value="{{ $item->material->date_come }}"/>
                  @error('date_come')
                  <div class="invalid-feedback">
                    {{ $message; }}
                  </div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-6">
              <div class="mb-1">
                <!-- Form Row-->
                <div class="mb-1">
                  <label class="mb-1" for="name">Nama Material *</label>
                  <input class="form-control @error('name') is-invalid @enderror" name="name" type="text" value="{{ $item->material->name }}"/>
                  @error('name')
                  <div class="invalid-feedback">
                    {{ $message; }}
                  </div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-6">
              <div class="mb-1">
                <!-- Form Row-->
                <div class="mb-1">
                  <label class="mb-1" for="part_no">Part No *</label>
                  <input type="text" name="project_id" value="{{$item->material->project_id}}" required hidden>
                  <input class="form-control @error('part_no') is-invalid @enderror" name="part_no" type="text" value="{{ $item->material->part_no }}"/>
                  @error('part_no')
                  <div class="invalid-feedback">
                    {{ $message; }}
                  </div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-6">
              <div class="mb-1">
                <!-- Form Row-->
                <div class="mb-1">
                  <label class="mb-1" for="lot">Lot *</label>
                  <input class="form-control @error('lot') is-invalid @enderror" name="lot" type="text" value="{{ $item->material->lot }}"/>
                  @error('lot')
                  <div class="invalid-feedback">
                    {{ $message; }}
                  </div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-6">
              <div class="mb-1">
                <!-- Form Row-->
                <div class="mb-1">
                  <label class="mb-1" for="qty">Qty *</label>
                  <input class="form-control @error('qty') is-invalid @enderror" name="qty" type="number" value="{{ $item->qty }}"/>
                  @error('qty')
                  <div class="invalid-feedback">
                    {{ $message; }}
                  </div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-6">
              <div class="mb-1">
                <!-- Form Row-->
                <div class="mb-1">
                  <label class="mb-1" for="satuan">Satuan *</label>
                  <input class="form-control @error('satuan') is-invalid @enderror" name="satuan" type="text" value="{{ $item->material->satuan }}"/>
                  @error('satuan')
                  <div class="invalid-feedback">
                    {{ $message; }}
                  </div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-6">
              <div class="mb-1">
                <!-- Form Row-->
                <div class="mb-1">
                  <label class="mb-1" for="plant">Plant *</label>
                  <input class="form-control @error('plant') is-invalid @enderror" name="plant" type="text" value="{{ $item->material->plant }}"/>
                  @error('plant')
                  <div class="invalid-feedback">
                    {{ $message; }}
                  </div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-6">
              <div class="mb-1">
                <!-- Form Row-->
                <div class="mb-1">
                  <label class="mb-1" for="lokasi_simpan">Lokasi Simpan *</label>
                  <input class="form-control @error('lokasi_simpan') is-invalid @enderror" name="lokasi_simpan" type="text" value="{{ $item->material->lokasi_simpan }}"/>
                  @error('lokasi_simpan')
                  <div class="invalid-feedback">
                    {{ $message; }}
                  </div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-6">
              <div class="mb-1">
                <!-- Form Row-->
                <div class="mb-1">
                  <label class="mb-1" for="no_sj">No SJ *</label>
                  <input class="form-control @error('no_sj') is-invalid @enderror" name="no_sj" type="text" value="{{ $item->material->no_sj }}"/>
                  @error('no_sj')
                  <div class="invalid-feedback">
                    {{ $message; }}
                  </div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-6">
              <div class="mb-1">
                <!-- Form Row-->
                <div class="mb-1">
                  <label class="mb-1" for="no_mobil">No Mobil *</label>
                  <input class="form-control @error('no_mobil') is-invalid @enderror" name="no_mobil" type="text" value="{{ $item->material->no_mobil }}"/>
                  @error('no_mobil')
                  <div class="invalid-feedback">
                    {{ $message; }}
                  </div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-6">
              <div class="mb-1">
                <!-- Form Row-->
                <div class="mb-1">
                  <label class="mb-1" for="driver">Driver *</label>
                  <input class="form-control @error('driver') is-invalid @enderror" name="driver" type="text" value="{{ $item->material->driver }}"/>
                  @error('driver')
                  <div class="invalid-feedback">
                    {{ $message; }}
                  </div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-6">
              <div class="mb-1">
                <!-- Form Row-->
                <div class="mb-1">
                  <label class="mb-1" for="keterangan">Keterangan *</label>
                  <input class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" type="text" value="{{ $item->material->keterangan }}"/>
                  @error('keterangan')
                  <div class="invalid-feedback">
                    {{ $message; }}
                  </div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-6">
              <div class="mb-1">
                <!-- Form Row-->
                <div class="mb-1">
                  <label class="mb-1" for="category">Category *</label>
                  <input class="form-control @error('category') is-invalid @enderror" name="category" type="text" value="{{ $item->material->category }}"/>
                  @error('category')
                  <div class="invalid-feedback">
                    {{ $message; }}
                  </div>
                  @enderror
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="modalPengajuan{{$item->material->id}}">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content">
      <form action="{{ route('receiver.ajukan') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h4 class="modal-title">Ajukan Material</h4>
          <input type="text" name="project_id" value="{{$id}}" hidden>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <input type="text" name="material_id" value="{{$item->material->id}}" hidden>
              <div class="mb-3">
                <label for="" class="form-label">Qty *</label>
                <input type="number" name="qty" class="form-control" value="{{$item->qty}}">
                <div class="text-sm text-warning">
                  *Qty tidak boleh lebih dari jumlah yang ada
                </div>
              </div>
              <div class="mb-3">
                <label for="" class="form-label">Ketarangan *</label>
                <textarea name="description" id="" cols="30" rows="5" class="form-control"></textarea>
              </div>
              <div class="mb-3">
                <label for="" class="form-label">Foto Bukti</label>
                <input type="file" name="foto" accept=".jpg,.jpeg,.png" class="form-control" value="">
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
@endsection

@push('addon-script')
<script>



  $(document).ready(function(){
    var datatable = $('#crudTable').DataTable({
      processing: true,
      serverSide: true,
      ordering: true,
      ajax: {
      url: '{{ url()->current() }}', // Memperbaiki tanda kutip satu di sini
    },
    columns: [
    {
        data: 'DT_RowIndex', // Menghapus tanda kutip satu pada "data"
        orderable: false,
        searchable: false,
      },
      { data: 'material.name', name: 'name' },
      { data: 'material.part_no', name: 'part_no' },
      { data: 'material.lot', name: 'lot' },
      { data: 'qty', name: 'qty' },
      // { 
      //   data: 'link',
      //   name: 'link',
      //   orderable: false,
      //   searchable: false,
      //   width: '15%',
      // },
      { 
        data: 'action',
        name: 'action',
        orderable: false,
        searchable: false,
        width: '15%',
      },
      ]
    });

    var datatable = $('#historyTable').DataTable({
      processing: true,
      serverSide: true,
      ordering: true,
      ajax: {
        url: "{{ route('receiver.history', ['id' => $id]) }}",
      },
      columns: [
      {
        data: 'DT_RowIndex', // Menghapus tanda kutip satu pada "data"
        orderable: false,
        searchable: false,
      },
      { data: 'material.name', name: 'name' },
      { data: 'material.part_no', name: 'part_no' },
      { data: 'material.lot', name: 'lot' },
      { data: 'qty', name: 'qty' },
      ]
    });

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

  })



</script>

@endpush
