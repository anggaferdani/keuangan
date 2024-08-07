@extends('templates.pages')
@section('title')
@section('header')
<div class="section-header-back">
  <a href="{{ route('jobdesk.karyawan') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
</div>
<h1>Jobdesk : {{ $user->name }}</h1>
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
          <button type="button" class="btn btn-icon btn-primary" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i></button>
        </div>
        <div class="float-right">
          <form id="filter" action="{{ route('jobdesk.index') }}" method="GET">
            <div class="input-group">
              <input type="hidden" class="form-control" placeholder="" name="user_id" value="{{ $user->id }}">
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
                <th class="align-items-center text-center text-nowrap">Name</th>
                <th class="align-items-center text-center text-nowrap">Tanggal Pengerjaan</th>
                <th class="align-items-center text-center text-nowrap">Tanggal Selesai Pengerjaan</th>
                <th class="align-items-center text-center text-nowrap">Status</th>
                <th class="align-items-center">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($jobdesks as $jobdesk)
                <tr>
                  <td class="align-items-center text-center text-nowrap">{{ ($jobdesks->currentPage() - 1) * $jobdesks->perPage() + $loop->iteration }}</td>
                  <td class="align-items-center text-center text-nowrap">{{ $jobdesk->project->nama_project }}</td>
                  <td class="align-items-center text-center text-nowrap">{{ $jobdesk->tanggal_mulai_pengerjaan ?? '-' }}</td>
                  <td class="align-items-center text-center text-nowrap">{{ $jobdesk->tanggal_selesai_pengerjaan ?? '-' }}</td>
                  <td class="align-items-center text-center text-nowrap"><div class="badge badge-primary">{{ $jobdesk->statusBelongsTo->name }}</div></td>
                  <td class="align-items-center text-nowrap">
                    <form action="{{ route('jobdesk.destroy', $jobdesk->id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="button" class="btn btn-icon btn-primary" data-toggle="modal" data-target="#editModal{{ $jobdesk->id }}"><i class="fas fa-pen"></i></button>
                      <button type="button" class="btn btn-icon btn-danger delete"><i class="fas fa-trash"></i></button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <div class="float-right">
          {{ $jobdesks->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
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
      <form action="{{ route('jobdesk.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <input type="hidden" class="form-control" name="user_id" value="{{ $user->id }}">
          <div class="form-group">
            <label for="">Project <span class="text-danger">*</span></label>
            <select class="form-control select2" name="project_id" style="width: 100%;">
              <option disabled selected value="">Status</option>
              @foreach($projects as $project)
                <option value="{{ $project->id }}">{{ $project->nama_project }}</option>
              @endforeach
            </select>
            @error('nama_project')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="">Keterangan</label>
            <textarea class="form-control" name="keterangan"></textarea>
            @error('keterangan')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="">Tanggal Mulai Pengerjaan</label>
            <input type="date" class="form-control" name="tanggal_mulai_pengerjaan">
            @error('tanggal_mulai_pengerjaan')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="">Tanggal Selesai Pengerjaan</label>
            <input type="date" class="form-control" name="tanggal_selesai_pengerjaan">
            @error('tanggal_selesai_pengerjaan')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="">Status <span class="text-danger">*</span></label>
            <select class="form-control select2" name="status_id" style="width: 100%;">
              <option disabled selected value="">Status</option>
              @foreach($statuses as $status)
                <option value="{{ $status->id }}">{{ $status->name }}</option>
              @endforeach
            </select>
            @error('status_id')<div class="text-danger">{{ $message }}</div>@enderror
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

@foreach ($jobdesks as $jobdesk)
<div class="modal fade" id="editModal{{ $jobdesk->id }}" data-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('jobdesk.update', $jobdesk->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <input type="hidden" class="form-control" name="user_id" value="{{ $user->id }}">
          <div class="form-group">
            <label for="">Project <span class="text-danger">*</span></label>
            <select class="form-control select2" name="project_id" style="width: 100%;">
              <option disabled selected value="">Status</option>
              @foreach($projects as $project)
                <option value="{{ $project->id }}" @if($project->id == $jobdesk->project_id) @selected(true) @endif>{{ $project->nama_project }}</option>
              @endforeach
            </select>
            @error('project_id')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="">Keterangan</label>
            <textarea class="form-control" name="keterangan">{{ $jobdesk->keterangan }}</textarea>
            @error('keterangan')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="">Tanggal Mulai Pengerjaan</label>
            <input type="date" class="form-control" name="tanggal_mulai_pengerjaan" value="{{ $jobdesk->tanggal_mulai_pengerjaan }}">
            @error('tanggal_mulai_pengerjaan')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="">Tanggal Selesai Pengerjaan</label>
            <input type="date" class="form-control" name="tanggal_selesai_pengerjaan" value="{{ $jobdesk->tanggal_selesai_pengerjaan }}">
            @error('tanggal_selesai_pengerjaan')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="">Status <span class="text-danger">*</span></label>
            <select class="form-control select2" name="status_id" style="width: 100%;">
              <option disabled selected value="">Status</option>
              @foreach($statuses as $status)
                <option value="{{ $status->id }}" @if($status->id == $jobdesk->status_id) @selected(true) @endif>{{ $status->name }}</option>
              @endforeach
            </select>
            @error('status_id')<div class="text-danger">{{ $message }}</div>@enderror
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
@endpush