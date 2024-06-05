@extends('templates.pages')
@section('title')
@section('header')
<div class="section-header-back">
  <a href="{{ route('project.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
</div>
<h1>Paid Project {{ $project->nama_project }}</h1>
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
                <th class="align-items-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <form action="{{ route('paid-project.store') }}" method="POST">
                @csrf
                <tr>
                  <input type="hidden" class="form-control" name="project_id" value="{{ $project->id }}">
                  <td class="align-items-center text-center text-nowrap"></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="text" class="form-control border border-danger" name="keterangan" required></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="date" class="form-control border border-danger" name="tanggal_pembayaran" required></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="text" class="form-control border border-danger" name="nominal_pembayaran" required></td>
                  <td class="align-items-center text-nowrap">
                    <button type="submit" class="btn btn-icon btn-primary"><i class="fas fa-plus"></i></button>
                  </td>
                </tr>
              </form>
              @foreach($paidProjects as $paidProject)
                <form action="{{ route('paid-project.update', $paidProject->id) }}" method="POST">
                  @csrf
                  @method('PUT')
                  <tr>
                    <input type="hidden" class="form-control" name="project_id" value="{{ $project->id }}">
                    <td class="align-items-center text-center text-nowrap">{{ $loop->iteration }}</td>
                    {{-- <td class="align-items-center text-center text-nowrap">{{ ($paidProjects->currentPage() - 1) * $paidProjects->perPage() + $loop->iteration }}</td> --}}
                    <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="text" class="form-control @error('keterangan') border border-danger @enderror" name="keterangan" value="{{ $paidProject->keterangan }}"></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="date" class="form-control @error('tanggal_pembayaran') border border-danger @enderror" name="tanggal_pembayaran" value="{{ $paidProject->tanggal_pembayaran }}"></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="text" class="form-control @error('nominal_pembayaran') border border-danger @enderror" name="nominal_pembayaran" value="{{ $paidProject->nominal_pembayaran }}"></td>
                    <td class="align-items-center text-nowrap">
                      @if(auth()->user()->hasPermission('paid-project-edit'))
                        <button type="submit" class="btn btn-icon btn-primary"><i class="fas fa-check"></i></button>
                      @endif
                      @if(auth()->user()->hasPermission('paid-project-delete'))
                        <a href="{{ route('paid-project.delete', $paidProject->id) }}" class="btn btn-icon btn-danger delete2"><i class="fas fa-trash"></i></a>
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