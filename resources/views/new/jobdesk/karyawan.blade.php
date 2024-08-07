@extends('templates.pages')
@section('title')
@section('header')
<h1>Karyawan</h1>
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
          <form id="filter" action="{{ route('jobdesk.karyawan') }}" method="GET">
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
                <th class="align-items-center text-center text-nowrap">Name</th>
                <th class="align-items-center">Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse($users as $user)
                <tr>
                  <td class="align-items-center text-center text-nowrap">{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                  <td class="align-items-center text-center text-nowrap">{{ $user->name }}</td>
                  <td class="align-items-center text-nowrap">
                    <a href="{{ route('jobdesk.index', ['user_id' => $user->id]) }}" class="btn btn-icon btn-primary">Project</a>
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

        <div class="float-right">
          {{ $users->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
      </div>
    </div>
  </div>
</div>
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