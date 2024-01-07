@extends('mobilelayout.main')

@section('title')
Delivery
@endsection

@section('container')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Delivery</h1>
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
        <h3 class="card-title">Delivery</h3>

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
