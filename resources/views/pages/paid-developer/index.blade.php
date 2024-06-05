@extends('templates.pages')
@section('title')
@section('header')
<div class="section-header-back">
  <a href="{{ route('price-developer.index', ['id' => $priceDeveloper->project->id]) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
</div>
<h1>Paid Developer {{ $priceDeveloper->project->nama_project }}</h1>
@endsection
@section('content')
<div class="row">
  <div class="col-12">

    @if(Session::get('success'))
      <div class="alert alert-important alert-primary" role="alert">
        {{ Session::get('success') }}
      </div>
    @endif
  
    <div class="card">
      <div class="card-body">
        <div class="float-left">
          
        </div>
        <div class="float-right">
        </div>

        <div class="clearfix mb-3"></div>

        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="align-items-center text-center text-nowrap">No.</th>
                <th class="align-items-center text-center text-nowrap">Keterangan</th>
                <th class="align-items-center text-center text-nowrap">Tanggal Pembayaran</th>
                <th class="align-items-center text-center text-nowrap">Nominal Pembayaran</th>
                <th class="align-items-center text-center text-nowrap">Lampiran *multiple</th>
                <th class="align-items-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <form action="{{ route('paid-developer.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <tr>
                  <input type="hidden" class="form-control" name="price_developer_id" value="{{ $priceDeveloper->id }}">
                  <td class="align-items-center text-center text-nowrap"></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="text" class="form-control border border-danger" name="keterangan" required></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="date" class="form-control border border-danger" name="tanggal_pembayaran" required></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="text" class="form-control border border-danger" name="nominal_pembayaran" required></td>
                  <td class="align-items-center text-center text-nowrap p-1">
                    <div class="input-group" style="min-width: 300px; width: 100%;">
                      <input type="file" class="form-control border border-danger" name="attachment[]" multiple>
                      <div class="input-group-append">
                        <button disabled class="btn btn-secondary" type="button"><i class="fas fa-eye"></i></button>
                      </div>
                    </div>
                  </td>
                  <td class="align-items-center text-nowrap">
                    <button type="submit" class="btn btn-icon btn-primary"><i class="fas fa-plus"></i></button>
                  </td>
                </tr>
              </form>
              @foreach($paidDevelopers as $paidDeveloper)
                <form action="{{ route('paid-developer.update', $paidDeveloper->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <tr>
                    <input type="hidden" class="form-control" name="price_developer_id" value="{{ $priceDeveloper->id }}">
                    <td class="align-items-center text-center text-nowrap">{{ $loop->iteration }}</td>
                    {{-- <td class="align-items-center text-center text-nowrap">{{ ($paidDevelopers->currentPage() - 1) * $paidDevelopers->perPage() + $loop->iteration }}</td> --}}
                    <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="text" class="form-control @error('keterangan') border border-danger @enderror" name="keterangan" value="{{ $paidDeveloper->keterangan }}"></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="date" class="form-control @error('tanggal_pembayaran') border border-danger @enderror" name="tanggal_pembayaran" value="{{ $paidDeveloper->tanggal_pembayaran }}"></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="text" class="form-control @error('nominal_pembayaran') border border-danger @enderror" name="nominal_pembayaran" value="{{ $paidDeveloper->nominal_pembayaran }}"></td>
                    <td class="align-items-center text-center text-nowrap p-1">
                      <div class="input-group" style="min-width: 300px; width: 100%;">
                        <input type="file" class="form-control @error('attachment') border border-danger @enderror" name="attachment[]" multiple>
                        <div class="input-group-append">
                          <button @if($paidDeveloper->file->attachments) @else @disabled(true) @endif class="btn btn-secondary" type="button" data-toggle="modal" data-target="#attachmentModal{{ $paidDeveloper->id }}"><i class="fas fa-eye"></i></button>
                        </div>
                      </div>
                    </td>
                    <td class="align-items-center text-nowrap">
                      @if(auth()->user()->hasPermission('paid-project-edit'))
                        <button type="submit" class="btn btn-icon btn-primary"><i class="fas fa-check"></i></button>
                      @endif
                      @if(auth()->user()->hasPermission('paid-project-delete'))
                        <a href="{{ route('paid-developer.delete', $paidDeveloper->id) }}" class="btn btn-icon btn-danger delete2"><i class="fas fa-trash"></i></a>
                      @endif
                    </td>
                  </tr>
                </form>
              @endforeach
              <tr>
                <td class="align-items-center text-nowrap"></td>
                <td class="align-items-center text-nowrap"></td>
                <td class="align-items-center text-nowrap"></td>
                <td class="align-items-center text-center text-nowrap p-1"><input readonly type="text" class="form-control" name="" id="total"></td>
                <td class="align-items-center text-nowrap"></td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
</div>

@foreach($paidDevelopers as $paidDeveloper)
<div class="modal fade" id="attachmentModal{{ $paidDeveloper->id }}" data-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Attachments</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          {{-- @forelse($paidDeveloper->file->attachments->where('status', 1) as $attachment)
            <a href="{{ $attachment->file_path . '/' . $attachment->file_hash }}" target="_blank">{{ $attachment->file_name }}</a>
            <a href="{{ route('paid-developer.delete-attachment', $attachment->id) }}" class="text-danger delete2"><i class="fas fa-trash"></i></a>
          @empty
            <img src="{{ asset('images/out-of-stock.png') }}" class="img-fluid">
          @endforelse --}}
          
          @forelse($paidDeveloper->file->attachments->where('status', 1) as $attachment)
            @php
              $extension = strtolower(pathinfo($attachment->file_name, PATHINFO_EXTENSION));
              $imageExtensions = ['jpg', 'jpeg', 'png'];
            @endphp
            
            <div class="d-block mb-3">
              @if(in_array($extension, $imageExtensions))
                <img src="{{ $attachment->file_path . '/' . $attachment->file_hash }}" class="img-fluid">
              @else
                <img src="{{ asset('file.jpg') }}" class="img-fluid">
              @endif
              <div>
                <a href="{{ $attachment->file_path . '/' . $attachment->file_hash }}" target="_blank">{{ $attachment->file_name }}</a>
                <a href="{{ route('paid-developer.delete-attachment', $attachment->id) }}" class="text-danger delete2"><i class="fas fa-trash"></i></a>
              </div>
            </div>
          @empty
            <img src="{{ asset('images/out-of-stock.png') }}" class="img-fluid">
          @endforelse
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach
@endsection
@push('scripts')
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const nominalPembayaranInputs = document.querySelectorAll('.form-control[name="nominal_pembayaran"]');
    const totalInput = document.getElementById('total');

    const formatter = new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR'
    });

    function formatCurrencyAndFinalPrice(input) {
      input.value = formatter.format(input.value.replace(/[^\d]/g, '')).replace(',00', '');
      updateFinalPrice(input);
    }

    function updateFinalPrice(input) {
      const parentRow = input.closest('tr');
      const nominalPembayaranInput = parentRow.querySelector('.form-control[name="nominal_pembayaran"]');
      updateTotal();
    }

    function updateTotal() {
      let total = 0;
      nominalPembayaranInputs.forEach((input, index) => {
        if (index > 0) {
          total += parseFloat(input.value.replace(/[^\d]/g, '') || 0);
        }
      });
      totalInput.value = formatter.format(total).replace(',00', '');
    }

    nominalPembayaranInputs.forEach(formatCurrencyAndFinalPrice);

    nominalPembayaranInputs.forEach(input => {
      input.addEventListener('input', function() { formatCurrencyAndFinalPrice(this); });
    });
  });
</script>
@endpush