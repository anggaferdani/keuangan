@extends('templates.pages')
@section('title')
@section('header')
<h1>Project</h1>
@endsection
@section('content')
<div class="row text-center">
  <div class="col-md-3">
    <div class="card">
      <div class="card-body">
        <div>Total Gaji {{ now()->year }}</div>
        <h5 class="text-primary" id="summaryTotalGaji"></h5>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card">
      <div class="card-body">
        <div>Total Esatimasi</div>
        <h5 class="text-primary mb-0" id="summaryPenjumlahanTotalEstimasi"></h5>
        <div>
          <i class="fas fa-check text-success"></i>
          <span class="text-danger" id="summaryTotalEstimasi"></span>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card">
      <div class="card-body">
        <div>Total</div>
        <h5 class="text-primary mb-0" id="summaryPenjumlahanTotal"></h5>
        <div>
          <i class="fas fa-check text-success"></i>
          <span class="text-danger" id="summaryTotal"></span>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card">
      <div class="card-body">
        <div>Project 2024</div>
        <h5 class="text-primary">{{ $projectCount }}</h5>
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
          
        </div>
        <div class="float-right">
        </div>

        <div class="clearfix mb-3"></div>

        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th style="height: 20px !important" class="border align-items-center text-center text-nowrap" rowspan="2">No.</th>
                <th style="height: 20px !important" class="border align-items-center text-center text-nowrap" rowspan="2">Status</th>
                <th style="height: 20px !important" class="border align-items-center text-center text-nowrap" rowspan="2">Client</th>
                <th style="height: 20px !important" class="border align-items-center text-center text-nowrap" rowspan="2">End User</th>
                <th style="height: 20px !important; background: #f4f4f4;" class="border align-items-center text-center text-nowrap sticky-column" rowspan="2">Nama Project</th>
                <th style="height: 20px !important" class="border align-items-center text-center text-nowrap" rowspan="2">No Penawaran</th>
                <th style="height: 20px !important" class="border align-items-center text-center text-nowrap" rowspan="2">Jenis Pekerjaan</th>
                <th style="height: 20px !important" class="border align-items-center text-center text-nowrap" rowspan="2">Programming Language</th>
                <th style="height: 20px !important" class="border align-items-center text-center text-nowrap" rowspan="2">Project Entry Date</th>
                <th style="height: 20px !important" class="border align-items-center text-center text-nowrap" rowspan="2">Project Start Date</th>
                <th style="height: 20px !important" class="border align-items-center text-center text-nowrap" rowspan="2">Project Completion Date</th>
                <th style="height: 20px !important" class="border align-items-center text-center text-nowrap" colspan="6">SUBMIT</th>
                <th style="height: 20px !important" class="border align-items-center text-center text-nowrap" colspan="2">PAID</th>
                <th style="height: 20px !important" class="border align-items-center text-center text-nowrap" colspan="4">REMNANT</th>
                <th style="height: 20px !important" class="border align-items-center" rowspan="2">Action</th>
              </tr>
              <tr>
                <th style="height: 20px !important" class="border align-items-center text-center text-nowrap">Price Developer</th>
                <th style="height: 20px !important" class="border align-items-center text-center text-nowrap">Price Submit</th>
                <th style="height: 20px !important" class="border align-items-center text-center text-nowrap">Profit</th>
                <th style="height: 20px !important" class="border align-items-center text-center text-nowrap">Price Deal</th>
                <th style="height: 20px !important" class="border align-items-center text-center text-nowrap">Real Profit</th>
                <th style="height: 20px !important" class="border align-items-center text-center text-nowrap">Persentase Profit</th>
                <th style="height: 20px !important" class="border align-items-center text-center text-nowrap">Developer</th>
                <th style="height: 20px !important" class="border align-items-center text-center text-nowrap">Project</th>
                <th style="height: 20px !important" class="border align-items-center text-center text-nowrap">Developer</th>
                <th style="height: 20px !important" class="border align-items-center text-center text-nowrap">Project</th>
                <th style="height: 20px !important" class="border align-items-center text-center text-nowrap">Total Estimasi</th>
                <th style="height: 20px !important" class="border align-items-center text-center text-nowrap">Total</th>
              </tr>
            </thead>
            <tbody>
              <form action="{{ route('project.store') }}" method="POST">
                @csrf
                <tr>
                  <td class="align-items-center text-center text-nowrap"></td>
                  <td class="align-items-center text-center text-nowrap p-1">
                    <select required class="form-control select2" style="width: 200px !important;" name="status_id">
                      <option disabled selected value="">Select</option>
                      @foreach($statuses as $statusOption)
                        <option value="{{ $statusOption->id }}">{{ $statusOption->name }}</option>
                      @endforeach
                    </select>
                  </td>
                  <td class="align-items-center text-center text-nowrap p-1">
                    <select required class="form-control select3" style="width: 200px !important;" name="client_id">
                      <option disabled selected value="">Select</option>
                      @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                      @endforeach
                    </select>
                  </td>
                  <td class="align-items-center text-center text-nowrap p-1">
                    <select required class="form-control select3" style="width: 200px !important;" name="end_user_id">
                      <option disabled selected value="">Select</option>
                      @foreach($endUsers as $endUser)
                        <option value="{{ $endUser->id }}">{{ $endUser->name }}</option>
                      @endforeach
                    </select>
                  </td>
                  <td class="align-items-center text-center text-nowrap p-1 sticky-column" style="background: white;"><input style="min-width: 200px; width: 100%;" type="text" class="form-control border border-danger" name="nama_project" required></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="text" class="form-control border border-danger" name="nomor_penawaran" required></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="text" class="form-control border border-danger" name="jenis_pekerjaan" required></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="text" class="form-control border border-danger" name="programming_language" required></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="date" class="form-control border border-danger" name="project_entry_date" required></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="date" class="form-control border border-danger" name="project_start_date" required></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="date" class="form-control border border-danger" name="project_completion_date" required></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input readonly style="min-width: 200px; width: 100%;" type="text" class="form-control border border-danger" name="price_developer" required></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input readonly style="min-width: 200px; width: 100%;" type="text" class="form-control border border-danger" name="price_submit" required></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input readonly style="min-width: 200px; width: 100%;" type="text" class="form-control border border-danger" name="profit" required></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input readonly style="min-width: 200px; width: 100%;" type="text" class="form-control border border-danger" name="price_deal" required></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input readonly style="min-width: 200px; width: 100%;" type="text" class="form-control border border-danger" name="real_profit" required></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input readonly style="min-width: 200px; width: 100%;" type="text" class="form-control border border-danger" name="persentase_profit" required></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input readonly style="min-width: 200px; width: 100%;" type="text" class="form-control border border-danger" name="paid_developer" required></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input readonly style="min-width: 200px; width: 100%;" type="text" class="form-control border border-danger" name="paid_project"></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input readonly style="min-width: 200px; width: 100%;" type="text" class="form-control border border-danger" name="remnant_developer" required></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input readonly style="min-width: 200px; width: 100%;" type="text" class="form-control border border-danger" name="remnant_project" required></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input readonly style="min-width: 200px; width: 100%;" type="text" class="form-control border border-danger" name="total_estimasi" required></td>
                  <td class="align-items-center text-center text-nowrap p-1"><input readonly style="min-width: 200px; width: 100%;" type="text" class="form-control border border-danger" name="total" required></td>
                  <td class="align-items-center text-nowrap">
                    <button type="submit" class="btn btn-icon btn-primary"><i class="fas fa-plus"></i></button>
                  </td>
                </tr>
              </form>
              @foreach($projects as $project)
                <form action="{{ route('project.update', $project->id) }}" method="POST">
                  @csrf
                  @method('PUT')
                  @php
                    $totalPriceDevelopers = $project->priceDevelopers->where('status', 1)->sum('final_price');
                    $totalPriceSubmits = $project->priceSubmits->where('status', 1)->sum('final_price');
                    $profit = $totalPriceSubmits - $totalPriceDevelopers;
                    $percentageProfit = $totalPriceSubmits != 0 ? ($profit / $totalPriceSubmits) * 100 : 0;
    $percentageProfitFormatted = $percentageProfit == floor($percentageProfit) ? number_format($percentageProfit, 0, ',', '.') : number_format($percentageProfit, 2, ',', '.');
                    $paidDevelopers = $project->priceDevelopers->where('status', 1)->sum('paid');
                    $paidProjects = $project->paidProjects->where('status', 1)->sum('nominal_pembayaran');
                    $remnantDevelopers = $project->priceDevelopers->where('status', 1)->sum('remnant');
                    $remnantProjects =  $totalPriceSubmits - $paidProjects;
                    $total = $remnantProjects - $remnantDevelopers;
                  @endphp
                  <tr class="@if($project->status_id == 5) bg-danger @elseif($project->status_id == 4) bg-success @endif">
                    {{-- <td class="align-items-center text-center text-nowrap">{{ $projects->firstItem() + $loop->index }}</td> --}}
                    <td class="align-items-center text-center text-nowrap">{{ $loop->iteration }}</td>
                    <td class="align-items-center text-center text-nowrap p-1">
                      <select required class="form-control select2" style="width: 200px !important;" name="status_id">
                        <option disabled selected value="">Select</option>
                        @foreach($statuses as $statusOption)
                          <option value="{{ $statusOption->id }}" @if($project->status_id == $statusOption->id) @selected(true) @endif>{{ $statusOption->name }}</option>
                        @endforeach
                      </select>
                    </td>
                    <td class="align-items-center text-center text-nowrap p-1">
                      <select required class="form-control select3" style="width: 200px !important;" name="client_id">
                        <option disabled selected value="">Select</option>
                        @foreach($clients as $client)
                          <option value="{{ $client->id }}" @if($project->client_id == $client->id) @selected(true) @endif>{{ $client->name }}</option>
                        @endforeach
                      </select>
                    </td>
                    <td class="align-items-center text-center text-nowrap p-1">
                      <select required class="form-control select3" style="width: 200px !important;" name="end_user_id">
                        <option disabled selected value="">Select</option>
                        @foreach($endUsers as $endUser)
                          <option value="{{ $endUser->id }}" @if($project->end_user_id == $endUser->id) @selected(true) @endif>{{ $endUser->name }}</option>
                        @endforeach
                      </select>
                    </td>
                    <td class="align-items-center text-center text-nowrap p-1 sticky-column @if($project->status_id == 5) bg-danger @elseif($project->status_id == 4) bg-success @else bg-white @endif"><input style="min-width: 200px; width: 100%;" type="text" class="form-control" value="{{ $project->nama_project }}" name="nama_project" required></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="text" class="form-control" value="{{ $project->nomor_penawaran }}" name="nomor_penawaran" required></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="text" class="form-control" value="{{ $project->jenis_pekerjaan }}" name="jenis_pekerjaan" required></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="text" class="form-control" value="{{ $project->programming_language }}" name="programming_language" required></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="date" class="form-control" value="{{ $project->project_entry_date }}" name="project_entry_date" required></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="date" class="form-control" value="{{ $project->project_start_date }}" name="project_start_date" required></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input style="min-width: 200px; width: 100%;" type="date" class="form-control" value="{{ $project->project_completion_date }}" name="project_completion_date" required></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input readonly style="min-width: 200px; width: 100%;" type="text" class="form-control" name="price_developer" value="{{ $totalPriceDevelopers }}" required></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input readonly style="min-width: 200px; width: 100%;" type="text" class="form-control" name="price_submit" value="{{ $totalPriceSubmits }}" required></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input readonly style="min-width: 200px; width: 100%;" type="text" class="form-control" name="profit" value="{{ $profit }}" required></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input readonly style="min-width: 200px; width: 100%;" type="text" class="form-control" name="price_deal" value="{{ $totalPriceSubmits }}" required></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input readonly style="min-width: 200px; width: 100%;" type="text" class="form-control" name="real_profit" value="{{ $profit }}" required></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input readonly style="min-width: 200px; width: 100%;" type="text" class="form-control" name="persentase_profit" value="{{ $percentageProfitFormatted }}" required></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input readonly style="min-width: 200px; width: 100%;" type="text" class="form-control" name="paid_developer" value="{{ $paidDevelopers }}" required></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input readonly style="min-width: 200px; width: 100%;" type="text" class="form-control" name="paid_project" value="{{ $paidProjects }}"></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input readonly style="min-width: 200px; width: 100%;" type="text" class="form-control" name="remnant_developer" value="{{ $remnantDevelopers }}" required></td>
                    <td class="align-items-center text-center text-nowrap p-1"><input readonly style="min-width: 200px; width: 100%;" type="text" class="form-control" name="remnant_project" value="{{ $remnantProjects }}" required></td>
                    @if($project->status_id != 5)
                      <td class="align-items-center text-center text-nowrap p-1"><input readonly style="min-width: 200px; width: 100%;" type="text" class="form-control" name="total_estimasi" value="{{ $total }}" required></td>
                    @else
                      <td class="align-items-center text-center text-nowrap p-1"><input readonly style="min-width: 200px; width: 100%;" type="text" class="form-control" name="total_estimasi_yang_tidak_terhitung" value="{{ $total }}" required></td>
                    @endif
                    @if($project->status_id == 3 || $project->status_id == 4)
                      <td class="align-items-center text-center text-nowrap p-1"><input readonly style="min-width: 200px; width: 100%;" type="text" class="form-control" name="total" value="{{ $total }}" required></td>
                    @else
                      <td class="align-items-center text-center text-nowrap p-1"><input readonly style="min-width: 200px; width: 100%;" type="text" class="form-control" name="total_yang_tidak_terhitung" value="{{ $total }}" required></td>
                    @endif
                    <td class="align-items-center text-nowrap">
                      @if(auth()->user()->hasPermission('price-submit-index'))
                        <a href="{{ route('price-submit.index', ['id' => $project->id]) }}" class="btn btn-icon btn-primary"><i class="fas fa-folder"></i> Price Submit</a>
                      @endif
                      @if(auth()->user()->hasPermission('price-developer-index'))
                        <a href="{{ route('price-developer.index', ['id' => $project->id]) }}" class="btn btn-icon btn-primary"><i class="fas fa-user"></i> Price Developer</a>
                      @endif
                      @if(auth()->user()->hasPermission('paid-project-index'))
                        <a href="{{ route('paid-project.index', ['id' => $project->id]) }}" class="btn btn-icon btn-primary"><i class="fas fa-user"></i> Paid Project</a>
                      @endif
                      @if(auth()->user()->hasPermission('project-show'))
                        <a href="{{ route('project.show', $project->id) }}" target="_blank" class="btn btn-icon btn-primary"><i class="fas fa-eye"></i></a>
                      @endif
                      @if(auth()->user()->hasPermission('project-edit'))
                        <button type="submit" class="btn btn-icon btn-primary"><i class="fas fa-check"></i></button>
                      @endif
                      @if(auth()->user()->hasPermission('project-delete'))
                        <a href="{{ route('project.delete', $project->id) }}" class="btn btn-icon btn-danger delete2"><i class="fas fa-trash"></i></a>
                      @endif
                    </td>
                  </tr>
                </form>
              @endforeach
              <tr>
                <td class="align-items-center text-nowrap" colspan="4"></td>
                <td class="align-items-center text-nowrap p-1 sticky-column" style="background: white;"><div style="min-width: 200px; width: 100%;"></div></td>
                <td class="align-items-center text-nowrap" colspan="6"></td>
                <td class="align-items-center text-center text-nowrap p-1"><input readonly type="text" class="form-control border border-primary" name="" id="totalPriceDeveloper"></td>
                <td class="align-items-center text-center text-nowrap p-1"><input readonly type="text" class="form-control border border-primary" name="" id="totalPriceSubmit"></td>
                <td class="align-items-center text-center text-nowrap p-1"><input readonly type="text" class="form-control border border-primary" name="" id="totalProfit"></td>
                <td class="align-items-center text-center text-nowrap p-1"><input readonly type="text" class="form-control border border-primary" name="" id="totalPriceDeal"></td>
                <td class="align-items-center text-center text-nowrap p-1"><input readonly type="text" class="form-control border border-primary" name="" id="totalRealProfit"></td>
                <td class="align-items-center text-nowrap"></td>
                <td class="align-items-center text-center text-nowrap p-1"><input readonly type="text" class="form-control border border-primary" name="" id="totalPaidDeveloper"></td>
                <td class="align-items-center text-center text-nowrap p-1"><input readonly type="text" class="form-control border border-primary" name="" id="totalPaidProject"></td>
                <td class="align-items-center text-center text-nowrap p-1"><input readonly type="text" class="form-control border border-primary" name="" id="totalRemnantDeveloper"></td>
                <td class="align-items-center text-center text-nowrap p-1"><input readonly type="text" class="form-control border border-primary" name="" id="totalRemnantProject"></td>
                <td class="align-items-center text-center text-nowrap p-1"><input readonly type="text" class="form-control border border-primary" name="" id="totalEstimasi"></td>
                <td class="align-items-center text-center text-nowrap p-1"><input readonly type="text" class="form-control border border-primary" name="" id="total"></td>
                <td class="align-items-center text-nowrap text-primary">total penjumlahan price project</td>
                <td class="align-items-center text-nowrap"></td>
              </tr>
              <tr>
                @php
                  use Carbon\Carbon;

                  $totalGaji = 0;
                  $currentYear = Carbon::now()->year;

                  foreach ($users as $user) {
                      $totalGaji += $user->karyawan->gajis->where('status', 1)
                                    ->filter(function($gaji) use ($currentYear) {
                                      return Carbon::parse($gaji->tanggal)->year == $currentYear;
                                    })
                                    ->sum('sisa');
                  }
                @endphp

                <td class="align-items-center text-nowrap" colspan="4"></td>
                <td class="align-items-center text-nowrap p-1 sticky-column" style="background: white;"><div style="min-width: 200px; width: 100%;"></div></td>
                <td class="align-items-center text-nowrap" colspan="16"></td>
                <td class="align-items-center text-center text-nowrap p-1"><input readonly type="text" class="form-control border border-warning" name="" value="{{ $totalGaji }}" id="totalEstimasiGaji"></td>
                <td class="align-items-center text-center text-nowrap p-1"><input readonly type="text" class="form-control border border-warning" name="" value="{{ $totalGaji }}" id="totalGaji"></td>
                <td class="align-items-center text-nowrap text-warning">jumlah total gaji karyawan tahun <?php echo date("Y"); ?></td>
                <td class="align-items-center text-nowrap"></td>
              </tr>
              <tr>
                <td class="align-items-center text-nowrap" colspan="4"></td>
                <td class="align-items-center text-nowrap p-1 sticky-column" style="background: white;"><div style="min-width: 200px; width: 100%;"></div></td>
                <td class="align-items-center text-nowrap" colspan="16"></td>
                <td class="align-items-center text-center text-nowrap p-1"><input readonly type="text" class="form-control border border-success" name="" id="totalEstimasiKekurangan"></td>
                <td class="align-items-center text-center text-nowrap p-1"><input readonly type="text" class="form-control border border-success" name="" id="totalKekurangan"></td>
                <td class="align-items-center text-nowrap text-success">total</td>
                <td class="align-items-center text-nowrap"></td>
              </tr>
            </tbody>
          </table>
        </div>

        {{-- <div class="float-right">
          {{ $projects->links('pagination::bootstrap-4') }}
        </div> --}}
      </div>
    </div>
  </div>
</div>

{{-- @foreach($projects as $project)
@php
  $totalPriceDevelopers = $project->priceDevelopers->where('status', 1)->sum('final_price');
  $totalPriceSubmits = $project->priceSubmits->where('status', 1)->sum('final_price');
  $profit = $totalPriceSubmits - $totalPriceDevelopers;
  $percentageProfit = $totalPriceSubmits != 0 ? ($profit / $totalPriceSubmits) * 100 : 0;
  $paidDevelopers = $project->priceDevelopers->where('status', 1)->sum('paid');
  $paidProjects = $project->paidProjects->where('status', 1)->sum('nominal_pembayaran');
  $remnantDevelopers = $project->priceDevelopers->where('status', 1)->sum('remnant');
  $remnantProjects =  $totalPriceSubmits - $paidProjects;
  $total = $remnantProjects - $remnantDevelopers;
@endphp

<div class="modal fade" id="detailModal{{ $project->id }}" data-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Project {{ $project->nama_project }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST">
        <div class="modal-body">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach --}}
@endsection
@push('scripts')
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const priceDeveloperInputs = document.querySelectorAll('.form-control[name="price_developer"]');
    const priceSubmitInputs = document.querySelectorAll('.form-control[name="price_submit"]');
    const profitInputs = document.querySelectorAll('.form-control[name="profit"]');
    const priceDealInputs = document.querySelectorAll('.form-control[name="price_deal"]');
    const realProfitInputs = document.querySelectorAll('.form-control[name="real_profit"]');
    const paidDeveloperInputs = document.querySelectorAll('.form-control[name="paid_developer"]');
    const paidProjectInputs = document.querySelectorAll('.form-control[name="paid_project"]');
    const remnantDeveloperInputs = document.querySelectorAll('.form-control[name="remnant_developer"]');
    const remnantProjectInputs = document.querySelectorAll('.form-control[name="remnant_project"]');
    const totalEstimasiInputs = document.querySelectorAll('.form-control[name="total_estimasi"]');
    const totalEstimasiInputsTotalYangTidakTerhitung = document.querySelectorAll('.form-control[name="total_estimasi_yang_tidak_terhitung"]');
    const totalInputs = document.querySelectorAll('.form-control[name="total"]');
    const totalInputsTotalYangTidakTerhitung = document.querySelectorAll('.form-control[name="total_yang_tidak_terhitung"]');
    const totalPriceDeveloperInput = document.getElementById('totalPriceDeveloper');
    const totalPriceSubmitInput = document.getElementById('totalPriceSubmit');
    const totalProfitInput = document.getElementById('totalProfit');
    const totalPriceDealInput = document.getElementById('totalPriceDeal');
    const totalRealProfitInput = document.getElementById('totalRealProfit');
    const totalPaidDeveloperInput = document.getElementById('totalPaidDeveloper');
    const totalPaidProjectInput = document.getElementById('totalPaidProject');
    const totalRemnantDeveloperInput = document.getElementById('totalRemnantDeveloper');
    const totalRemnantProjectInput = document.getElementById('totalRemnantProject');
    const totalEstimasiInput = document.getElementById('totalEstimasi');
    const totalPriceInput = document.getElementById('total');
    const totalEstimasiGajiInput = document.getElementById('totalEstimasiGaji');
    const totalGajiInput = document.getElementById('totalGaji');
    const totalEstimasiKekuranganInput = document.getElementById('totalEstimasiKekurangan');
    const totalKekuranganInput = document.getElementById('totalKekurangan');

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
      const totalPaidProjectInput = parentRow.querySelector('.form-control[name="paid_project"]');

      const estimasiKekurangan = parseFloat(totalEstimasiInput.value.replace(/[^\d]/g, '') || 0) - parseFloat(totalEstimasiGajiInput.value.replace(/[^\d]/g, '') || 0);
      totalEstimasiKekuranganInput.value = formatter.format(estimasiKekurangan).replace(',00', '');

      const kekurangan = parseFloat(totalPriceInput.value.replace(/[^\d]/g, '') || 0) - parseFloat(totalGajiInput.value.replace(/[^\d]/g, '') || 0);
      totalKekuranganInput.value = formatter.format(kekurangan).replace(',00', '');

      updateTotal();
    }

    function updateTotal() {
      let totalPriceDeveloper = 0;
      priceDeveloperInputs.forEach((input, index) => {
        if (index > 0) {
          totalPriceDeveloper += parseFloat(input.value.replace(/[^\d]/g, '') || 0);
        }
      });
      totalPriceDeveloperInput.value = formatter.format(totalPriceDeveloper).replace(',00', '');

      let totalPriceSubmit = 0;
      priceSubmitInputs.forEach((input, index) => {
        if (index > 0) {
          totalPriceSubmit += parseFloat(input.value.replace(/[^\d]/g, '') || 0);
        }
      });
      totalPriceSubmitInput.value = formatter.format(totalPriceSubmit).replace(',00', '');
      
      let totalProfit = 0;
      profitInputs.forEach((input, index) => {
        if (index > 0) {
          totalProfit += parseFloat(input.value.replace(/[^\d]/g, '') || 0);
        }
      });
      totalProfitInput.value = formatter.format(totalProfit).replace(',00', '');

      let totalPriceDeal = 0;
      priceDealInputs.forEach((input, index) => {
        if (index > 0) {
          totalPriceDeal += parseFloat(input.value.replace(/[^\d]/g, '') || 0);
        }
      });
      totalPriceDealInput.value = formatter.format(totalPriceDeal).replace(',00', '');

      let totalRealProfit = 0;
      realProfitInputs.forEach((input, index) => {
        if (index > 0) {
          totalRealProfit += parseFloat(input.value.replace(/[^\d]/g, '') || 0);
        }
      });
      totalRealProfitInput.value = formatter.format(totalRealProfit).replace(',00', '');

      let totalPaidDeveloper = 0;
      paidDeveloperInputs.forEach((input, index) => {
        if (index > 0) {
          totalPaidDeveloper += parseFloat(input.value.replace(/[^\d]/g, '') || 0);
        }
      });
      totalPaidDeveloperInput.value = formatter.format(totalPaidDeveloper).replace(',00', '');

      let totalPaidProject = 0;
      paidProjectInputs.forEach((input, index) => {
        if (index > 0) {
          totalPaidProject += parseFloat(input.value.replace(/[^\d]/g, '') || 0);
        }
      });
      totalPaidProjectInput.value = formatter.format(totalPaidProject).replace(',00', '');

      let totalRemnantDeveloper = 0;
      remnantDeveloperInputs.forEach((input, index) => {
        if (index > 0) {
          totalRemnantDeveloper += parseFloat(input.value.replace(/[^\d]/g, '') || 0);
        }
      });
      totalRemnantDeveloperInput.value = formatter.format(totalRemnantDeveloper).replace(',00', '');

      let totalRemnantProject = 0;
      remnantProjectInputs.forEach((input, index) => {
        if (index > 0) {
          totalRemnantProject += parseFloat(input.value.replace(/[^\d]/g, '') || 0);
        }
      });
      totalRemnantProjectInput.value = formatter.format(totalRemnantProject).replace(',00', '');

      let totalEstimasi = 0;
      totalEstimasiInputs.forEach((input, index) => {
        if (index > 0) {
          totalEstimasi += parseFloat(input.value.replace(/[^\d]/g, '') || 0);
        }
      });
      totalEstimasiInput.value = formatter.format(totalEstimasi).replace(',00', '');

      let totalPrice = 0;
      totalInputs.forEach((input, index) => {
        if (index > 0) {
          totalPrice += parseFloat(input.value.replace(/[^\d]/g, '') || 0);
        }
      });
      totalPriceInput.value = formatter.format(totalPrice).replace(',00', '');

      let totalEstimasiGaji = parseFloat(totalEstimasiGajiInput.value.replace(/[^\d]/g, '') || 0);
      totalEstimasiGajiInput.value = formatter.format(totalEstimasiGaji).replace(',00', '');

      let totalGaji = parseFloat(totalGajiInput.value.replace(/[^\d]/g, '') || 0);
      totalGajiInput.value = formatter.format(totalGaji).replace(',00', '');

      let totalEstimasiKekurangan = parseFloat(totalEstimasiKekuranganInput.value.replace(/[^\d-]/g, '') || 0);
      let formattedEstimasiKekurangan = formatter.format(Math.abs(totalEstimasiKekurangan)).replace(',00', '');
      if (totalEstimasiKekurangan < 0) {
          formattedEstimasiKekurangan = "- " + formattedEstimasiKekurangan;
      }
      totalEstimasiKekuranganInput.value = formattedEstimasiKekurangan;

      let totalKekurangan = parseFloat(totalKekuranganInput.value.replace(/[^\d-]/g, '') || 0);
      let formattedKekurangan = formatter.format(Math.abs(totalKekurangan)).replace(',00', '');
      if (totalKekurangan < 0) {
          formattedKekurangan = "- " + formattedKekurangan;
      }
      totalKekuranganInput.value = formattedKekurangan;
    }

    priceDeveloperInputs.forEach(formatCurrencyAndFinalPrice);
    priceSubmitInputs.forEach(formatCurrencyAndFinalPrice);
    profitInputs.forEach(formatCurrencyAndFinalPrice);
    priceDealInputs.forEach(formatCurrencyAndFinalPrice);
    realProfitInputs.forEach(formatCurrencyAndFinalPrice);
    paidDeveloperInputs.forEach(formatCurrencyAndFinalPrice);
    paidProjectInputs.forEach(formatCurrencyAndFinalPrice);
    remnantDeveloperInputs.forEach(formatCurrencyAndFinalPrice);
    remnantProjectInputs.forEach(formatCurrencyAndFinalPrice);
    totalEstimasiInputs.forEach(formatCurrencyAndFinalPrice);
    totalEstimasiInputsTotalYangTidakTerhitung.forEach(formatCurrencyAndFinalPrice);
    totalInputs.forEach(formatCurrencyAndFinalPrice);
    totalInputsTotalYangTidakTerhitung.forEach(formatCurrencyAndFinalPrice);

    paidProjectInputs.forEach(input => {
      input.addEventListener('input', function() { formatCurrencyAndFinalPrice(this); });
    });

    const summaryTotalGaji = document.getElementById('totalGaji').value;
    document.getElementById('summaryTotalGaji').innerText = summaryTotalGaji;
    const summaryPenjumlahanTotalEstimasi = document.getElementById('totalEstimasi').value;
    document.getElementById('summaryPenjumlahanTotalEstimasi').innerText = summaryPenjumlahanTotalEstimasi;
    const summaryPenjumlahanTotal = document.getElementById('total').value;
    document.getElementById('summaryPenjumlahanTotal').innerText = summaryPenjumlahanTotal;
    const summaryTotalEstimasi = document.getElementById('totalEstimasiKekurangan').value;
    document.getElementById('summaryTotalEstimasi').innerText = summaryTotalEstimasi;
    const summaryTotal = document.getElementById('totalKekurangan').value;
    document.getElementById('summaryTotal').innerText = summaryTotal;
  });
</script>
@endpush