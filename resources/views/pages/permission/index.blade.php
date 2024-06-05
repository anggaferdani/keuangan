@extends('templates.pages')
@section('title')
@section('header')
<h1>Permission</h1>
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
          @if(auth()->user()->hasPermission('permission-create'))
            <button type="button" class="btn btn-icon btn-primary" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i></button>
          @endif
        </div>
        <div class="float-right">
          <form id="filter" action="{{ route('permission.index') }}" method="GET">
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
                <th class="align-items-center text-center text-nowrap">Created At</th>
                <th class="align-items-center">Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse($permissions as $permission)
                <tr>
                  <td class="align-items-center text-center text-nowrap">{{ $permissions->firstItem() + $loop->index }}</td>
                  <td class="align-items-center text-center text-nowrap">{{ $permission->name }}</td>
                  <td class="align-items-center text-center text-nowrap">{{ $permission->created_at }}</td>
                  <td class="align-items-center text-nowrap">
                    <form action="{{ route('permission.destroy', $permission->id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      @if(auth()->user()->hasPermission('permission-edit'))
                        <button type="button" class="btn btn-icon btn-primary" data-toggle="modal" data-target="#editModal{{ $permission->id }}"><i class="fas fa-pen"></i></button>
                      @endif
                      @if(auth()->user()->hasPermission('permission-delete'))
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

        <div class="float-right">
          {{ $permissions->links('pagination::bootstrap-4') }}
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
      <form action="{{ route('permission.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name">
            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
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

@foreach($permissions as $permission)
<div class="modal fade" id="editModal{{ $permission->id }}" data-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('permission.update', $permission->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="form-group">
            <label for="">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name" value="{{ $permission->name }}">
            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
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