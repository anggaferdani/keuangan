@extends('templates.pages')
@section('title')
@section('header')
<div class="section-header-back">
  <a href="{{ route('karyawan.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
</div>
<h1>Kasbon @if($request->id != null) {{ $user->name }} @endif</h1>
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
          <form id="" action="{{ route('kasbon.index') }}" method="GET">
            <div class="input-group">
              <select class="form-control select3" style="width: 200px !important;" name="karyawan_id">
                <option disabled selected value="">Karyawan</option>
                @foreach($users as $user)
                  <option value="{{ $user->id }}" @if($user->id == $request->karyawan_id) selected @endif>{{ $user->name }}</option>
                @endforeach
              </select>
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
                <th class="align-items-center text-center text-nowrap">Kasbon</th>
                <th class="align-items-center text-center text-nowrap">Cicilan</th>
                <th class="align-items-center text-center text-nowrap">Bulan</th>
                <th class="align-items-center text-center text-nowrap">Nominal Yang Dibayarkan</th>
                <th class="align-items-center text-center text-nowrap">Sisa</th>
                <th class="align-items-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <form action="{{ route('kasbon.store') }}" method="POST">
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
                  <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="text" class="form-control border border-danger" name="nominal_cicilan" required></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" readonly type="number" class="form-control border border-danger" name="bulan" required></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="text" class="form-control border border-danger" name="nominal_yang_dibayarkan"></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" readonly type="text" class="form-control border border-danger" name="sisa" required></td>
                  <td class="align-items-center text-nowrap">
                    <button type="submit" class="btn btn-icon btn-primary"><i class="fas fa-plus"></i></button>
                  </td>
                </tr>
              </form>
              @foreach($kasbons as $kasbon)
                <form action="{{ route('kasbon.update', $kasbon->id) }}" method="POST">
                  @csrf
                  @method('PUT')
                  <tr>
                    {{-- <td class="align-items-center text-center text-nowrap">{{ $kasbons->firstItem() + $loop->index }}</td> --}}
                    <td class="align-items-center text-center text-nowrap">{{ $loop->iteration }}</td>
                    @if($request->id == null)
                      <td class="align-items-center text-center text-nowrap p-1">
                        <select class="form-control select3" style="width: 200px !important;" name="karyawan_id">
                          <option disabled selected value="">Select</option>
                          @foreach($users as $user)
                            <option value="{{ $user->id }}" @if($kasbon->karyawan_id == $user->id) @selected(true) @endif>{{ $user->name }}</option>
                          @endforeach
                        </select>
                      </td>
                    @else
                      <input type="hidden" class="form-control" name="karyawan_id" value="{{ $user->karyawan->id }}">
                    @endif
                    <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="text" class="form-control" name="keterangan" value="{{ $kasbon->keterangan }}"></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="date" class="form-control" name="tanggal" value="{{ $kasbon->tanggal }}"></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="text" class="form-control @error('nominal') border border-danger @enderror" name="nominal" value="{{ $kasbon->nominal }}"></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="text" class="form-control @error('nominal_cicilan') border border-danger @enderror" name="nominal_cicilan" value="{{ $kasbon->nominal_cicilan }}"></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" readonly type="text" class="form-control @error('bulan') border border-danger @enderror" name="bulan" value="{{ $kasbon->bulan }}"></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="text" class="form-control @error('nominal_yang_dibayarkan') border border-danger @enderror" name="nominal_yang_dibayarkan" value="{{ $kasbon->nominal_yang_dibayarkan }}"></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" readonly type="text" class="form-control @error('sisa') border border-danger @enderror" name="sisa" value="{{ $kasbon->sisa }}"></td>
                    <td class="align-items-center text-nowrap">
                      @if(auth()->user()->hasPermission('kasbon-edit'))
                        <button type="submit" class="btn btn-icon btn-primary"><i class="fas fa-check"></i></button>
                      @endif
                      @if(auth()->user()->hasPermission('kasbon-delete'))
                        <a href="{{ route('kasbon.delete', $kasbon->id) }}" class="btn btn-icon btn-danger delete2"><i class="fas fa-trash"></i></a>
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
                <td class="align-items-center text-center text-nowrap p-1"><input readonly type="text" class="form-control" name="" id="totalKasbon"></td>
                <td class="align-items-center text-center text-nowrap p-1"><input readonly type="text" class="form-control" name="" id="totalCicilan"></td>
                <td class="align-items-center text-nowrap"></td>
                <td class="align-items-center text-center text-nowrap p-1"><input readonly type="text" class="form-control" name="" id="totalSisa"></td>
                <td class="align-items-center text-center text-nowrap p-1"><input readonly type="text" class="form-control" name="" id="total"></td>
                <td class="align-items-center text-nowrap"></td>
              </tr>
            </tbody>
          </table>
        </div>

        {{-- <div class="float-right">
          {{ $kasbons->links('pagination::bootstrap-4') }}
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
    const bulanInputs = document.querySelectorAll('.form-control[name="bulan"]');
    const nominalCicilanInputs = document.querySelectorAll('.form-control[name="nominal_cicilan"]');
    const nominalYangDibayarkanInputs = document.querySelectorAll('.form-control[name="nominal_yang_dibayarkan"]');
    const sisaInputs = document.querySelectorAll('.form-control[name="sisa"]');
    const totalKasbonInput = document.getElementById('totalKasbon');
    const totalCicilanInput = document.getElementById('totalCicilan');
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
      const bulanInput = parentRow.querySelector('.form-control[name="bulan"]');
      const nominalCicilanInput = parentRow.querySelector('.form-control[name="nominal_cicilan"]');
      const nominalYangDibayarkanInput = parentRow.querySelector('.form-control[name="nominal_yang_dibayarkan"]');
      const sisaInput = parentRow.querySelector('.form-control[name="sisa"]');

      let nominal = parseFloat(nominalInput.value.replace(/[^\d]/g, '')) || 0;
      let nominalYangDibayarkan = parseFloat(nominalYangDibayarkanInput.value.replace(/[^\d]/g, '')) || 0;
      let nominalCicilan = parseFloat(nominalCicilanInput.value.replace(/[^\d]/g, '')) || 0;

      if (nominalCicilan !== 0) {
        let bulan = Math.ceil(nominal / nominalCicilan);
        bulanInput.value = bulan;
      }

      if (nominalCicilan > nominal) {
        nominalCicilan = nominal;
        nominalCicilanInput.value = formatter.format(nominalCicilan).replace(',00', '');
      }
      
      if (nominalYangDibayarkan > nominal) {
        nominalYangDibayarkan = nominal;
        nominalYangDibayarkanInput.value = formatter.format(nominalYangDibayarkan).replace(',00', '');
      }

      const sisa = nominal - nominalYangDibayarkan;

      sisaInput.value = formatter.format(sisa).replace(',00', '');
      nominalCicilanInput.value = formatter.format(nominalCicilan).replace(',00', '');
      updateTotal();
    }

    function updateTotal() {
      let totalKasbon = 0;
      nominalInputs.forEach((input, index) => {
        if (index > 0) {
          totalKasbon += parseFloat(input.value.replace(/[^\d]/g, '') || 0);
        }
      });
      totalKasbonInput.value = formatter.format(totalKasbon).replace(',00', '');

      let totalCicilan = 0;
      nominalCicilanInputs.forEach((input, index) => {
        if (index > 0) {
          totalCicilan += parseFloat(input.value.replace(/[^\d]/g, '') || 0);
        }
      });
      totalCicilanInput.value = formatter.format(totalCicilan).replace(',00', '');

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
    nominalCicilanInputs.forEach(formatCurrencyAndFinalPrice);
    nominalYangDibayarkanInputs.forEach(formatCurrencyAndFinalPrice);
    sisaInputs.forEach(formatCurrencyAndFinalPrice);

    nominalInputs.forEach(input => {
      input.addEventListener('input', function() { formatCurrencyAndFinalPrice(this); });
    });
    nominalYangDibayarkanInputs.forEach(input => {
      input.addEventListener('input', function() { formatCurrencyAndFinalPrice(this); });
    });
    nominalCicilanInputs.forEach(input => {
      input.addEventListener('input', function() { updateFinalPrice(this); });
    });
  });
</script>
{{-- <script>
  document.addEventListener("DOMContentLoaded", function() {
    const nominalInputs = document.querySelectorAll('.form-control[name="nominal"]');
    const bulanInputs = document.querySelectorAll('.form-control[name="bulan"]');
    const nominalCicilanInputs = document.querySelectorAll('.form-control[name="nominal_cicilan"]');
    const nominalYangDibayarkanInputs = document.querySelectorAll('.form-control[name="nominal_yang_dibayarkan"]');
    const sisaInputs = document.querySelectorAll('.form-control[name="sisa"]');
    const totalKasbonInput = document.getElementById('totalKasbon');
    const totalCicilanInput = document.getElementById('totalCicilan');
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
      const bulanInput = parentRow.querySelector('.form-control[name="bulan"]');
      const nominalCicilanInput = parentRow.querySelector('.form-control[name="nominal_cicilan"]');
      const nominalYangDibayarkanInput = parentRow.querySelector('.form-control[name="nominal_yang_dibayarkan"]');
      const sisaInput = parentRow.querySelector('.form-control[name="sisa"]');

      let nominal = parseFloat(nominalInput.value.replace(/[^\d]/g, '')) || 0;
      let bulan = parseFloat(bulanInput.value) || 1;
      let nominalCicilan = nominal / bulan;
      let nominalYangDibayarkan = parseFloat(nominalYangDibayarkanInput.value.replace(/[^\d]/g, '')) || 0;

      if (nominalYangDibayarkan > nominal) {
        nominalYangDibayarkan = nominal;
        nominalYangDibayarkanInput.value = formatter.format(nominalYangDibayarkan).replace(',00', '');
      }

      const sisa = nominal - nominalYangDibayarkan;

      sisaInput.value = formatter.format(sisa).replace(',00', '');
      nominalCicilanInput.value = formatter.format(nominalCicilan).replace(',00', '');
      updateTotal();
    }

    function updateTotal() {
      let totalKasbon = 0;
      nominalInputs.forEach((input, index) => {
        if (index > 0) {
          totalKasbon += parseFloat(input.value.replace(/[^\d]/g, '') || 0);
        }
      });
      totalKasbonInput.value = formatter.format(totalKasbon).replace(',00', '');

      let totalCicilan = 0;
      nominalCicilanInputs.forEach((input, index) => {
        if (index > 0) {
          totalCicilan += parseFloat(input.value.replace(/[^\d]/g, '') || 0);
        }
      });
      totalCicilanInput.value = formatter.format(totalCicilan).replace(',00', '');

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
    bulanInputs.forEach(input => {
      input.addEventListener('input', function() { updateFinalPrice(this); });
    });
  });
</script> --}}
@endpush