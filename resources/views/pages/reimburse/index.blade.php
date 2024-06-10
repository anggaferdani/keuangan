@extends('templates.pages')
@section('title')
@section('header')
<div class="section-header-back">
  <a href="{{ route('karyawan.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
</div>
<h1>Reimburse @if($request->id != null) {{ $user->name }} @endif</h1>
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
          <form id="" action="{{ route('reimburse.index') }}" method="GET">
            <div class="input-group">
              @if($request->id == null)
                <select class="form-control select3" style="width: 200px !important;" name="karyawan_id">
                  <option disabled selected value="">Karyawan</option>
                  @foreach($users as $user)
                    <option value="{{ $user->id }}" @if($user->id == $request->karyawan_id) selected @endif>{{ $user->name }}</option>
                  @endforeach
                </select>
              @endif
              <input type="date" class="form-control" placeholder="Tanggal" name="tanggal" id="" value="{{ $request->tanggal }}">
              <button type="submit" class="btn btn-icon btn-primary"><i class="fas fa-search"></i></button>
            </div>
          </form>
        </div>
        <div class="float-right">
          
        </div>

        <div class="clearfix mb-3"></div>

        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="align-items-center text-center text-nowrap">No.</th>
                @if($request->id == null)
                  <th class="align-items-center text-center text-nowrap">Karyawan</th>
                @endif
                <th class="align-items-center text-center text-nowrap">Keterangan</th>
                <th class="align-items-center text-center text-nowrap">Tanggal</th>
                <th class="align-items-center text-center text-nowrap">Reimburse</th>
                <th class="align-items-center text-center text-nowrap">Tanggal Dibayarkan</th>
                <th class="align-items-center text-center text-nowrap">Nominal Yang Dibayarkan</th>
                <th class="align-items-center text-center text-nowrap">Lampiran *multiple</th>
                <th class="align-items-center text-center text-nowrap">Sisa</th>
                <th class="align-items-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <form action="{{ route('reimburse.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <tr>
                  <td class="align-items-center text-center text-nowrap"></td>
                  @if($request->id == null)
                    <td class="align-items-center text-center text-nowrap p-1">
                      <select class="form-control select3" style="width: 200px !important;" name="karyawan_id">
                        <option disabled selected value="">Select</option>
                        @foreach($users as $user)
                          <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                      </select>
                    </td>
                  @else
                    <input type="hidden" class="form-control" name="karyawan_id" value="{{ $user->karyawan->id }}">
                  @endif
                  <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="text" class="form-control border border-danger" name="keterangan" required></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="date" class="form-control border border-danger" name="tanggal" required></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="text" class="form-control border border-danger" name="nominal" required></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="date" class="form-control border border-danger" name="tanggal_dibayarkan"></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="text" class="form-control border border-danger" name="nominal_yang_dibayarkan"></td>
                  <td class="align-items-center text-center text-nowrap p-1">
                    <div class="input-group" style="min-width: 300px; width: 100%;">
                      <input type="file" class="form-control border border-danger" name="attachment[]" multiple>
                      <div class="input-group-append">
                        <button disabled class="btn btn-secondary" type="button"><i class="fas fa-eye"></i></button>
                      </div>
                    </div>
                  </td>
                  <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" readonly type="text" class="form-control border border-danger" name="sisa" required></td>
                  <td class="align-items-center text-nowrap">
                    <button type="submit" class="btn btn-icon btn-primary"><i class="fas fa-plus"></i></button>
                  </td>
                </tr>
              </form>
              @foreach($reimburses as $reimburse)
                <form action="{{ route('reimburse.update', $reimburse->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <tr>
                    {{-- <td class="align-items-center text-center text-nowrap">{{ $reimburses->firstItem() + $loop->index }}</td> --}}
                    <td class="align-items-center text-center text-nowrap">{{ $loop->iteration }}</td>
                    @if($request->id == null)
                      <td class="align-items-center text-center text-nowrap p-1">
                        <select class="form-control select3" style="width: 200px !important;" name="karyawan_id">
                          <option disabled selected value="">Select</option>
                          @foreach($users as $user)
                            <option value="{{ $user->id }}" @if($reimburse->karyawan_id == $user->id) @selected(true) @endif>{{ $user->name }}</option>
                          @endforeach
                        </select>
                      </td>
                    @else
                      <input type="hidden" class="form-control" name="karyawan_id" value="{{ $user->karyawan->id }}">
                    @endif
                    <td class="align-items-center text-center text-nowrap p-1"><input type="text" class="form-control" name="keterangan" value="{{ $reimburse->keterangan }}"></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input type="date" class="form-control" name="tanggal" value="{{ $reimburse->tanggal }}"></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input type="text" class="form-control @error('nominal') border border-danger @enderror" name="nominal" value="{{ $reimburse->nominal }}"></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input type="date" class="form-control @error('tanggal_dibayarkan') border border-danger @enderror" name="tanggal_dibayarkan" value="{{ $reimburse->tanggal_dibayarkan }}"></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input type="text" class="form-control @error('nominal_yang_dibayarkan') border border-danger @enderror" name="nominal_yang_dibayarkan" value="{{ $reimburse->nominal_yang_dibayarkan }}"></td>
                    <td class="align-items-center text-center text-nowrap p-1">
                      <div class="input-group" style="min-width: 300px; width: 100%;">
                        <input type="file" class="form-control @error('attachment') border border-danger @enderror" name="attachment[]" multiple>
                        <div class="input-group-append">
                          <button @if($reimburse->file->attachments) @else @disabled(true) @endif class="btn btn-secondary" type="button" data-toggle="modal" data-target="#attachmentModal{{ $reimburse->id }}"><i class="fas fa-eye"></i></button>
                        </div>
                      </div>
                    </td>
                    <td class="align-items-center text-center text-nowrap p-1"><input readonly type="text" class="form-control @error('sisa') border border-danger @enderror" name="sisa" value="{{ $reimburse->sisa }}"></td>
                    <td class="align-items-center text-nowrap">
                      @if(auth()->user()->hasPermission('reimburse-edit'))
                        <button type="submit" class="btn btn-icon btn-primary"><i class="fas fa-check"></i></button>
                      @endif
                      @if(auth()->user()->hasPermission('reimburse-delete'))
                        <a href="{{ route('reimburse.delete', $reimburse->id) }}" class="btn btn-icon btn-danger delete2"><i class="fas fa-trash"></i></a>
                      @endif
                    </td>
                  </tr>
                </form>
              @endforeach
              <tr>
                <td class="align-items-center text-nowrap"></td>
                @if($request->id == null)
                  <td class="align-items-center text-nowrap"></td>
                @endif
                <td class="align-items-center text-nowrap"></td>
                <td class="align-items-center text-nowrap"></td>
                <td class="align-items-center text-center text-nowrap p-1"><input readonly type="text" class="form-control" name="" id="totalReimburse"></td>
                <td class="align-items-center text-nowrap"></td>
                <td class="align-items-center text-center text-nowrap p-1"><input readonly type="text" class="form-control" name="" id="totalSisa"></td>
                <td class="align-items-center text-nowrap"></td>
                <td class="align-items-center text-center text-nowrap p-1"><input readonly type="text" class="form-control" name="" id="total"></td>
                <td class="align-items-center text-nowrap"></td>
              </tr>
            </tbody>
          </table>
        </div>

        {{-- <div class="float-right">
          {{ $reimburses->links('pagination::bootstrap-4') }}
        </div> --}}
      </div>
    </div>
  </div>
</div>

@foreach($reimburses as $reimburse)
<div class="modal fade" id="attachmentModal{{ $reimburse->id }}" data-backdrop="static" aria-hidden="true">
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
          {{-- @forelse($reimburse->file->attachments->where('status', 1) as $attachment)
            <a href="{{ $attachment->file_path . '/' . $attachment->file_hash }}" target="_blank">{{ $attachment->file_name }}</a>
            <a href="{{ route('reimburse.delete-attachment', $attachment->id) }}" class="text-danger delete2"><i class="fas fa-trash"></i></a>
          @empty
            <img src="{{ asset('images/out-of-stock.png') }}" class="img-fluid">
          @endforelse --}}
          
          @forelse($reimburse->file->attachments->where('status', 1) as $attachment)
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
                <a href="{{ route('reimburse.delete-attachment', $attachment->id) }}" class="text-danger delete2"><i class="fas fa-trash"></i></a>
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
    const nominalInputs = document.querySelectorAll('.form-control[name="nominal"]');
    const nominalYangDibayarkanInputs = document.querySelectorAll('.form-control[name="nominal_yang_dibayarkan"]');
    const sisaInputs = document.querySelectorAll('.form-control[name="sisa"]');
    const totalReimburseInput = document.getElementById('totalReimburse');
    const totalSisaInput = document.getElementById('totalSisa');
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
      const nominalInput = parentRow.querySelector('.form-control[name="nominal"]');
      const nominalYangDibayarkanInput = parentRow.querySelector('.form-control[name="nominal_yang_dibayarkan"]');
      const sisaInput = parentRow.querySelector('.form-control[name="sisa"]');

      let nominal = parseFloat(nominalInput.value.replace(/[^\d]/g, '')) || 0;
      let nominalYangDibayarkan = parseFloat(nominalYangDibayarkanInput.value.replace(/[^\d]/g, '')) || 0;

      if (nominalYangDibayarkan > nominal) {
        nominalYangDibayarkan = nominal;
        nominalYangDibayarkanInput.value = formatter.format(nominalYangDibayarkan).replace(',00', '');
      }

      const sisa = nominal - nominalYangDibayarkan;

      sisaInput.value = formatter.format(sisa).replace(',00', '');
      updateTotal();
    }

    function updateTotal() {
      let totalReimburse = 0;
      nominalInputs.forEach((input, index) => {
        if (index > 0) {
          totalReimburse += parseFloat(input.value.replace(/[^\d]/g, '') || 0);
        }
      });
      totalReimburseInput.value = formatter.format(totalReimburse).replace(',00', '');

      let totalSisa = 0;
      nominalYangDibayarkanInputs.forEach((input, index) => {
        if (index > 0) {
          totalSisa += parseFloat(input.value.replace(/[^\d]/g, '') || 0);
        }
      });
      totalSisaInput.value = formatter.format(totalSisa).replace(',00', '');

      let total = 0;
      sisaInputs.forEach((input, index) => {
        if (index > 0) {
          total += parseFloat(input.value.replace(/[^\d]/g, '') || 0);
        }
      });
      totalInput.value = formatter.format(total).replace(',00', '');
    }

    nominalInputs.forEach(formatCurrencyAndFinalPrice);
    nominalYangDibayarkanInputs.forEach(formatCurrencyAndFinalPrice);

    nominalInputs.forEach(input => {
      input.addEventListener('input', function() { formatCurrencyAndFinalPrice(this); });
    });
    nominalYangDibayarkanInputs.forEach(input => {
      input.addEventListener('input', function() { formatCurrencyAndFinalPrice(this); });
    });
  });
</script>
@endpush