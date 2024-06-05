@extends('templates.pages')
@section('title')
@section('header')
<div class="section-header-back">
  <a href="{{ route('karyawan.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
</div>
<h1>Gaji {{ $user->name }}</h1>
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
                <th class="align-items-center text-center text-nowrap">Tanggal</th>
                <th class="align-items-center text-center text-nowrap">Gaji</th>
                <th class="align-items-center text-center text-nowrap">Nominal Yang Dibayarkan</th>
                <th class="align-items-center text-center text-nowrap">Sisa</th>
                <th class="align-items-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <form action="{{ route('gaji.store') }}" method="POST">
                @csrf
                <tr>
                  <input type="hidden" class="form-control" name="karyawan_id" value="{{ $user->karyawan->id }}">
                  <td class="align-items-center text-center text-nowrap"></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="month" class="form-control border border-danger" name="tanggal" required></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" readonly type="text" class="form-control border border-danger" name="nominal" value="{{ $user->karyawan->nominal_gaji }}" required></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="text" class="form-control border border-danger" name="nominal_yang_dibayarkan" required></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" readonly type="text" class="form-control border border-danger" name="sisa" required></td>
                  <td class="align-items-center text-nowrap">
                    <button type="submit" class="btn btn-icon btn-primary"><i class="fas fa-plus"></i></button>
                  </td>
                </tr>
              </form>
              @foreach($gajis as $gaji)
                <form action="{{ route('gaji.update', $gaji->id) }}" method="POST">
                  @csrf
                  @method('PUT')
                  <tr>
                    <input type="hidden" class="form-control" name="karyawan_id" value="{{ $user->karyawan->id }}">
                    {{-- <td class="align-items-center text-center text-nowrap">{{ $gajis->firstItem() + $loop->index }}</td> --}}
                    <td class="align-items-center text-center text-nowrap">{{ $loop->iteration }}</td>
                    <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="month" class="form-control" name="tanggal" value="{{ $gaji->tanggal }}"></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" readonly type="text" class="form-control @error('nominal') border border-danger @enderror" name="nominal" value="{{ $gaji->nominal }}"></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="text" class="form-control @error('nominal_yang_dibayarkan') border border-danger @enderror" name="nominal_yang_dibayarkan" value="{{ $gaji->nominal_yang_dibayarkan }}"></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" readonly type="text" class="form-control @error('sisa') border border-danger @enderror" name="sisa" value="{{ $gaji->sisa }}"></td>
                    <td class="align-items-center text-nowrap">
                      @if(auth()->user()->hasPermission('gaji-edit'))
                        <button type="submit" class="btn btn-icon btn-primary"><i class="fas fa-check"></i></button>
                      @endif
                      @if(auth()->user()->hasPermission('gaji-delete'))
                        <a href="{{ route('gaji.delete', $gaji->id) }}" class="btn btn-icon btn-danger delete2"><i class="fas fa-trash"></i></a>
                      @endif
                    </td>
                  </tr>
                </form>
              @endforeach
              <tr>
                <td class="align-items-center text-nowrap"></td>
                <td class="align-items-center text-nowrap"></td>
                <td class="align-items-center text-center text-nowrap p-1"><input readonly type="text" class="form-control" name="" id="totalGaji"></td>
                <td class="align-items-center text-center text-nowrap p-1"><input readonly type="text" class="form-control" name="" id="totalSisa"></td>
                <td class="align-items-center text-center text-nowrap p-1"><input readonly type="text" class="form-control" name="" id="total"></td>
                <td class="align-items-center text-nowrap"></td>
              </tr>
            </tbody>
          </table>
        </div>

        {{-- <div class="float-right">
          {{ $gajis->links('pagination::bootstrap-4') }}
        </div> --}}
      </div>
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const nominalInputs = document.querySelectorAll('.form-control[name="nominal"]');
    const nominalYangDibayarkanInputs = document.querySelectorAll('.form-control[name="nominal_yang_dibayarkan"]');
    const sisaInputs = document.querySelectorAll('.form-control[name="sisa"]');
    const totalGajiInput = document.getElementById('totalGaji');
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
      let totalGaji = 0;
      nominalInputs.forEach((input, index) => {
        if (index > 0) {
          totalGaji += parseFloat(input.value.replace(/[^\d]/g, '') || 0);
        }
      });
      totalGajiInput.value = formatter.format(totalGaji).replace(',00', '');

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
    sisaInputs.forEach(formatCurrencyAndFinalPrice);

    nominalInputs.forEach(input => {
      input.addEventListener('input', function() { formatCurrencyAndFinalPrice(this); });
    });
    nominalYangDibayarkanInputs.forEach(input => {
      input.addEventListener('input', function() { formatCurrencyAndFinalPrice(this); });
    });
  });
</script>
@endpush