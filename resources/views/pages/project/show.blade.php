@extends('templates.pages')
@section('title')
@section('header')
<div class="section-header-back">
  <a href="{{ route('project.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
</div>
<h1>Show {{ $project->nama_project }}</h1>
@endsection
@section('content')
<div class="row justify-content-center">
  <div class="col-7">

    @if(Session::get('success'))
      <div class="alert alert-important alert-primary" role="alert">
        {{ Session::get('success') }}
      </div>
    @endif

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
  
    <div class="card">
      <div class="card-body">
        <table style="width: 100%;" class="mb-3">
          <tbody>
            <tr>
              <td style="width: 40%;">Status</td>
              <td>{{ $project->statusBelongsTo->name }}</td>
            </tr>
            <tr>
              <td style="width: 40%;">Client</td>
              <td>{{ $project->client->name }}</td>
            </tr>
            <tr>
              <td style="width: 40%;">End User</td>
              <td>{{ $project->endUser->name }}</td>
            </tr>
            <tr>
              <td style="width: 40%;">Nama Project</td>
              <td>{{ $project->nama_project }}</td>
            </tr>
            <tr>
              <td style="width: 40%;">No Penawaran</td>
              <td>{{ $project->nomor_penawaran }}</td>
            </tr>
            <tr>
              <td style="width: 40%;">Jenis Pekerjaan</td>
              <td>{{ $project->jenis_pekerjaan }}</td>
            </tr>
            <tr>
              <td style="width: 40%;">Programming Language</td>
              <td>{{ $project->programming_language }}</td>
            </tr>
            <tr>
              <td style="width: 40%;">Project Entry Date</td>
              <td>{{ $project->project_entry_date }}</td>
            </tr>
            <tr>
              <td style="width: 40%;">Project Start Date</td>
              <td>{{ $project->project_start_date }}</td>
            </tr>
            <tr>
              <td style="width: 40%;">Project Completion Date</td>
              <td>{{ $project->project_completion_date }}</td>
            </tr>
            <tr>
              <td style="width: 40%;">Price Developer</td>
              <td>{{ 'Rp ' . number_format($totalPriceDevelopers, 0, ',', '.') }}</td>
            </tr>
            <tr>
              <td style="width: 40%;">Price Submit</td>
              <td>{{ 'Rp ' . number_format($totalPriceSubmits, 0, ',', '.') }}</td>
            </tr>
            <tr>
              <td style="width: 40%;">Profit</td>
              <td>{{ 'Rp ' . number_format($profit, 0, ',', '.') }}</td>
            </tr>
            <tr>
              <td style="width: 40%;">Price Deal</td>
              <td>{{ 'Rp ' . number_format($totalPriceSubmits, 0, ',', '.') }}</td>
            </tr>
            <tr>
              <td style="width: 40%;">Real Profit</td>
              <td>{{ 'Rp ' . number_format($profit, 0, ',', '.') }}</td>
            </tr>
            <tr>
              <td style="width: 40%;">Persentase Profit</td>
              <td>{{ $percentageProfitFormatted }}</td>
            </tr>
            <tr>
              <td style="width: 40%;">Paid Developer</td>
              <td>{{ 'Rp ' . number_format($paidDevelopers, 0, ',', '.') }}</td>
            </tr>
            <tr>
              <td style="width: 40%;">Paid Project</td>
              <td>{{ 'Rp ' . number_format($paidProjects, 0, ',', '.') }}</td>
            </tr>
            <tr>
              <td>Remnant Developer</td>
              <td>{{ 'Rp ' . number_format($remnantDevelopers, 0, ',', '.') }}</td>
            </tr>
            <tr>
              <td style="width: 40%;">Remnant Project</td>
              <td>{{ 'Rp ' . number_format($remnantProjects, 0, ',', '.') }}</td>
            </tr>
            <tr>
              <td style="width: 40%;">Total Estimasi</td>
              <td>{{ 'Rp ' . number_format($total, 0, ',', '.') }}</td>
            </tr>
            <tr>
              <td style="width: 40%;">Total</td>
              <td>{{ 'Rp ' . number_format($total, 0, ',', '.') }}</td>
            </tr>
          </tbody>
        </table>
        
        <h5>Price Submit</h5>
        <table style="width: 100%;" class="mb-3 table-bordered">
          <tbody>
            <tr>
              <th>Fitur</th>
              <th>Final Price</th>
            </tr>
            @php
              $totalPriceSubmit = 0;
            @endphp
            @foreach ($project->priceSubmits->where('status', 1) as $priceSubmit)
              @php
                $totalPriceSubmit += $priceSubmit->final_price;
              @endphp
              <tr>
                <td>{{ $priceSubmit->fitur }}</td>
                <td>{{ 'Rp ' . number_format($priceSubmit->final_price, 0, ',', '.') }}</td>
              </tr>
            @endforeach
            <tr>
              <td></td>
              <td>{{ 'Rp ' . number_format($totalPriceSubmit, 0, ',', '.') }}</td>
            </tr>
          </tbody>
        </table>

        <h5>Price Developer</h5>
        <table style="width: 100%;" class="mb-3 table-bordered">
          <tbody>
            <tr>
              <th>Name</th>
              <th>Jobdesk</th>
              <th>Final Price</th>
            </tr>
            @php
              $totalPriceDeveloper = 0;
            @endphp
            @foreach ($project->priceDevelopers->where('status', 1) as $priceDeveloper)
              @php
                $totalPriceDeveloper += $priceDeveloper->final_price;
                $isNumeric = is_numeric($priceDeveloper->user_id);
              @endphp
              <tr>
                @if($isNumeric)
                  <td>{{ $priceDeveloper->user->name }}</td>
                @else
                  <td>{{ $priceDeveloper->user_id }}</td>
                @endif
                <td>{{ $priceDeveloper->jobdesk }}</td>
                <td>{{ 'Rp ' . number_format($priceDeveloper->final_price, 0, ',', '.') }}</td>
              </tr>
            @endforeach
            <tr>
              <td colspan="2"></td>
              <td>{{ 'Rp ' . number_format($totalPriceDeveloper, 0, ',', '.') }}</td>
            </tr>
          </tbody>
        </table>

        <h5>Paid Project</h5>
        <table style="width: 100%;" class="mb-3 table-bordered">
          <tbody>
            <tr>
              <th>Keterangan</th>
              <th>Tanggal Pembayaran</th>
              <th>Nominal Pembayaran</th>
            </tr>
            @php
              $totalPaidProject = 0;
            @endphp
            @foreach ($project->paidProjects->where('status', 1) as $paidProject)
              @php
                $totalPaidProject += $paidProject->nominal_pembayaran;
              @endphp
              <tr>
                <td>{{ $paidProject->keterangan }}</td>
                <td>{{ $paidProject->tanggal_pembayaran }}</td>
                <td>{{ 'Rp ' . number_format($paidProject->nominal_pembayaran, 0, ',', '.') }}</td>
              </tr>
            @endforeach
            <tr>
              <td colspan="2"></td>
              <td>{{ 'Rp ' . number_format($totalPaidProject, 0, ',', '.') }}</td>
            </tr>
          </tbody>
        </table>
        <a href="{{ route('project.index') }}" class="btn btn-secondary">Close</a>
      </div>
    </div>
  </div>
</div>
@endsection