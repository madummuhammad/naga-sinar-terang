@extends('layouts.admin')

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
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin-dashboard')}}">Dasboard</a></li>
            <li class="breadcrumb-item"><a href="{{route('production.index')}}">Project Anda</a></li>
            <li class="breadcrumb-item active">WIP Qc</li>
          </ol>
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
        <div class="d-flex justify-content-end my-2">
          <!-- <a data-toggle="modal" data-target="#modalAjukan" class="btn btn-secondary btn-xs ml-2">Ajukan ke QC</a> -->
          <div class="modal fade" id="modalAjukan">
            <div class="modal-dialog modal-sm modal-dialog-centered">
              <div class="modal-content">
                <form action="{{ route('production.ajukan') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="modal-header">
                    <h4 class="modal-title">Ajukan Out Produksi</h4>
                    <input type="text" name="project_id" value="{{$id}}" hidden>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <h5>Anda yakin akan mengajukan produksi ke qc?</h5>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary">Ajukan</button>
                  </div>
                </form>
              </div>
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
              <th>Qty In</th>
              <th>Keterangan</th>
              <th>Link</th>
              <!-- <th>Qty Out</th> -->
              <!-- <th>Aksi</th> -->
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
<div class="modal fade" id="updateModal{{$item->id}}">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <form action="{{ route('production.update',$item->id) }}" method="POST" enctype="multipart/form-data">
        @method('PUT');
        @csrf
        <div class="modal-header">
          <h4 class="modal-title">Update Qty Out</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12 col-lg-12">
              <div class="mb-1">
                <!-- Form Row-->
                <div class="mb-1">
                  <label class="mb-1" for="qty">Qty Out</label>
                  <input type="text" name="project_id" value="{{$item->project_id}}" required hidden>
                  <input class="form-control @error('qty') is-invalid @enderror" name="qty" type="text" value="{{ $item->stock ? $item->stock->qty : 0 }}"/>
                  @error('qty')
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
      <form action="{{ route('production.ajukan') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h4 class="modal-title">Ajukan Produksi</h4>
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
                <label for="" class="form-label">Qty</label>
                <input type="number" name="qty" class="form-control" value="{{$item->qty}}">
                <div class="text-sm text-warning">
                  *Qty tidak boleh lebih dari jumlah yang ada
                </div>
              </div>
              <div class="mb-3">
                <label for="" class="form-label">Ketarangan</label>
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
        { data: 'material.name', name: 'name' },
        { data: 'material.part_no', name: 'part_no' },
        { data: 'material.lot', name: 'lot' },
        { data: 'qty', name: 'qty' },
        {
          data: 'description',
          name: 'description',
          render: function (data, type, row) {
            if (row.material_condition === 'Repair') {
              return data + ' (' + row.material_condition + ')';
            } else {
              return data;
            }
          }
        },
        { 
          data: 'link', 
          name: 'link',
          orderable: false,
          searchable: false,
          width: '15%'
        },
        // { 
        //   data: 'action', 
        //   name: 'action',
        //   orderable: false,
        //   searchable: false,
        //   width: '15%'
        // },
        ]
      });

  var datatable = $('#historyTable').DataTable({
    processing: true,
    serverSide: true,
    ordering: true,
    ajax: {
      url: "{{ route('qc.history', ['id' => $id]) }}",
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
</script>
@endpush
