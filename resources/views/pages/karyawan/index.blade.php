@extends('templates.pages')
@section('title')
@section('header')
<h1>Karyawan</h1>
@endsection
@section('content')
@php
  use Carbon\Carbon;

  $totalSisaGaji = 0;
  $totalSeluruhGaji = 0;
  $totalKasbon = 0;
  $totalReimburse = 0;
  $currentYear = Carbon::now()->year;

  foreach ($users as $user) {
      $totalSisaGaji += $user->karyawan->gajis->where('status', 1)
                    ->filter(function($gaji) use ($currentYear) {
                      return Carbon::parse($gaji->tanggal)->year == $currentYear;
                    })
                    ->sum('sisa');
      $totalSeluruhGaji += $user->karyawan->nominal_gaji * 12;
      $totalKasbon += $user->karyawan->kasbons->where('status', 1)
                    ->filter(function($gaji) use ($currentYear) {
                      return Carbon::parse($gaji->tanggal)->year == $currentYear;
                    })
                    ->sum('sisa');
      $totalReimburse += $user->karyawan->reimburses->where('status', 1)
                    ->filter(function($gaji) use ($currentYear) {
                      return Carbon::parse($gaji->tanggal)->year == $currentYear;
                    })
                    ->sum('sisa');
  }
@endphp
<div class="row text-center">
  <div class="col-md-3">
    <div class="card">
      <div class="card-body">
        <div>Total Gaji {{ now()->year }}</div>
        <h5 class="text-primary mb-0">{{ 'Rp. '.number_format($totalSisaGaji) }}</h5>
        <div>
          <span class="text-danger">{{ 'Rp. '.number_format($totalSeluruhGaji) }}</span>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card">
      <div class="card-body">
        <div>Total Kasbon</div>
        <h5 class="text-primary">{{ 'Rp. '.number_format($totalKasbon) }}</h5>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card">
      <div class="card-body">
        <div>Total Reimburse</div>
        <h5 class="text-primary">{{ 'Rp. '.number_format($totalReimburse) }}</h5>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card">
      <div class="card-body">
        <div>Total Karyawan</div>
        <h5 class="text-primary">{{ $karyawanCount }}</h5>
      </div>
    </div>
  </div>
</div>
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
          @if(auth()->user()->hasPermission('karyawan-create'))
            <button type="button" class="btn btn-icon btn-primary" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i></button>
          @endif
        </div>
        <div class="float-right">
          <form id="filter" action="{{ route('karyawan.index') }}" method="GET">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search" name="search" id="search" value="">
            </div>
          </form>
        </div>

        <div class="clearfix mb-3"></div>

        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="align-items-center text-center text-nowrap">No.</th>
                <th class="align-items-center text-center text-nowrap">NIP</th>
                <th class="align-items-center text-center text-nowrap">NPWP</th>
                <th class="align-items-center text-center text-nowrap sticky-column" style="background: #f4f4f4;">Name</th>
                <th class="align-items-center text-center text-nowrap">Email</th>
                <th class="align-items-center text-center text-nowrap">Keterangan</th>
                <th class="align-items-center">Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse($users as $user)
                <tr>
                  <td class="align-items-center text-center text-nowrap">{{ $loop->iteration }}</td>
                  <td class="align-items-center text-center text-nowrap">{{ $user->karyawan->nip }}</td>
                  <td class="align-items-center text-center text-nowrap">{{ $user->karyawan->npwp }}</td>
                  <td class="align-items-center text-center text-nowrap sticky-column" style="background: white;">{{ $user->name }}</td>
                  <td class="align-items-center text-center text-nowrap">{{ $user->email }}</td>
                  <td class="align-items-center text-nowrap">
                    <div class="small">Total sisa gaji <span class="text-danger">{{ 'Rp. '.number_format($user->karyawan->gajis->where('status', 1)->sum('sisa')) }}</span></div>
                    <div class="small">Total sisa kasbon <span class="text-danger">{{ 'Rp. '.number_format($user->karyawan->kasbons->where('status', 1)->sum('sisa')) }}</span></div>
                    <div class="small">Total sisa reimburse <span class="text-danger">{{ 'Rp. '.number_format($user->karyawan->reimburses->where('status', 1)->sum('sisa')) }}</span></div>
                    <div class="small">Total sisa gaji + Total sisa kasbon <span class="text-danger">{{ 'Rp. '.number_format($user->karyawan->gajis->where('status', 1)->sum('sisa') + $user->karyawan->kasbons->where('status', 1)->sum('sisa')) }}</span></div>
                    <div class="small">Total sisa gaji + Total sisa kasbon - Total sisa reimburse <span class="text-danger">{{ 'Rp. '.number_format($user->karyawan->gajis->where('status', 1)->sum('sisa') + $user->karyawan->kasbons->where('status', 1)->sum('sisa') - $user->karyawan->reimburses->where('status', 1)->sum('sisa')) }}</span></div>
                  </td>
                  <td class="align-items-center text-nowrap">
                    <form action="{{ route('karyawan.destroy', $user->id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      @if(auth()->user()->hasPermission('gaji-index'))
                        <a href="{{ route('gaji.index', ['id' => $user->id]) }}" class="btn btn-icon btn-primary"><i class="fas fa-coins"></i> Gaji {{ 'Rp. '.number_format($user->karyawan->gajis->where('status', 1)->sum('nominal')) }}</a>
                      @endif
                      @if(auth()->user()->hasPermission('thr-index'))
                        <a href="{{ route('thr.index', ['id' => $user->id]) }}" class="btn btn-icon btn-success"><i class="fas fa-coins"></i> THR {{ 'Rp. '.number_format($user->karyawan->tunjanganHariRayas->where('status', 1)->sum('nominal')) }}</a>
                      @endif
                      @if(auth()->user()->hasPermission('kasbon-index'))
                        <a href="{{ route('kasbon.index', ['id' => $user->id]) }}" class="btn btn-icon btn-danger"><i class="fas fa-coins"></i> Kasbon  {{ 'Rp. '.number_format($user->karyawan->kasbons->where('status', 1)->sum('nominal')) }}</a>
                      @endif
                      @if(auth()->user()->hasPermission('reimburse-index'))
                        <a href="{{ route('reimburse.index', ['id' => $user->id]) }}" class="btn btn-icon btn-warning"><i class="fas fa-coins"></i> Reimburse  {{ 'Rp. '.number_format($user->karyawan->reimburses->where('status', 1)->sum('nominal')) }}</a>
                      @endif
                      @if(auth()->user()->hasPermission('karyawan-edit'))
                        <button type="button" class="btn btn-icon btn-primary" data-toggle="modal" data-target="#editModal{{ $user->id }}"><i class="fas fa-pen"></i></button>
                      @endif
                      @if(auth()->user()->hasPermission('karyawan-delete'))
                        <button type="button" class="btn btn-icon btn-danger delete"><i class="fas fa-trash"></i></button>
                      @endif
                    </form>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="align-items-center text-center text-nowrap">Empty</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        {{-- <div class="float-right">
          {{ $users->links('pagination::bootstrap-4') }}
        </div> --}}
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="createModal" data-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('karyawan.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="">NIP <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="nip">
            @error('nip')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="">NPWP <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="npwp">
            @error('npwp')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name">
            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" name="email">
            @error('email')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="">Password <span class="text-danger">*</span></label>
            <input type="password" class="form-control" name="password">
            @error('password')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="">Nominal Gaji <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="nominal_gaji" id="nominalGaji">
            @error('nominal_gaji')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="">Nominal Tunjangan Hari Raya <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="nominal_tunjangan_hari_raya" id="nominalTunjanganHariRaya">
            @error('nominal_tunjangan_hari_raya')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="">No Rekening BCA</label>
            <input type="text" class="form-control" name="no_rekening_bca">
            @error('no_rekening_bca')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="">No Rekening Mandiri</label>
            <input type="text" class="form-control" name="no_rekening_mandiri">
            @error('no_rekening_mandiri')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

@foreach($users as $user)
<div class="modal fade" id="editModal{{ $user->id }}" data-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('karyawan.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="form-group">
            <label for="">NIP <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="nip" value="{{ $user->karyawan->nip }}">
            @error('nip')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="">NPWP <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="npwp" value="{{ $user->karyawan->npwp }}">
            @error('npwp')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name" value="{{ $user->name }}">
            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" name="email" value="{{ $user->email }}">
            @error('email')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="">Password <span class="text-danger">*</span></label>
            <input type="password" class="form-control" name="password">
            @error('password')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="">Nominal Gaji <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="nominal_gaji" value="{{ $user->karyawan->nominal_gaji }}" id="nominalGajiEdit">
            @error('nominal_gaji')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="">Nominal Tunjangan Hari Raya <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="nominal_tunjangan_hari_raya" value="{{ $user->karyawan->nominal_tunjangan_hari_raya }}" id="nominalTunjanganHariRayaEdit">
            @error('nominal_tunjangan_hari_raya')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="">No Rekening BCA</label>
            <input type="text" class="form-control" name="no_rekening_bca" value="{{ $user->karyawan->no_rekening_bca }}">
            @error('no_rekening_bca')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="">No Rekening Mandiri</label>
            <input type="text" class="form-control" name="no_rekening_mandiri" value="{{ $user->karyawan->no_rekening_mandiri }}">
            @error('no_rekening_mandiri')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit</button>
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
      document.getElementById('search').addEventListener('input', function() {
          document.getElementById('filter').submit();
      });
  });
</script>
<script>
  const urlParams = new URLSearchParams(window.location.search);
  const searchQuery = urlParams.get('search');

  document.addEventListener("DOMContentLoaded", function() {
      const searchInput = document.getElementById('search');

      if (searchQuery) {
          searchInput.value = searchQuery;
      }
  });
</script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const nominalInputs = document.querySelectorAll('.form-control[name="nominal_gaji"], .form-control[name="nominal_tunjangan_hari_raya"]');

    const formatter = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR'
    });

    function formatCurrency(input) {
        input.value = formatter.format(input.value.replace(/[^\d]/g, '')).replace(',00', '');
    }

    nominalInputs.forEach(input => {
        input.addEventListener('input', function() {
            formatCurrency(this);
        });
        formatCurrency(input);
    });
});
</script>
@endpush