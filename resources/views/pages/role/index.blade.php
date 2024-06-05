@extends('templates.pages')
@section('title')
@section('header')
<h1>Role</h1>
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
          @if(auth()->user()->hasPermission('role-create'))
            <button type="button" class="btn btn-icon btn-primary" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i></button>
          @endif
        </div>
        <div class="float-right">
          <form id="filter" action="{{ route('role.index') }}" method="GET">
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
              @forelse($roles as $role)
                <tr>
                  <td class="align-items-center text-center text-nowrap">{{ $roles->firstItem() + $loop->index }}</td>
                  <td class="align-items-center text-center text-nowrap">{{ $role->name }}</td>
                  <td class="align-items-center text-nowrap">
                    <form action="{{ route('role.destroy', $role->id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      @if(auth()->user()->hasPermission('role-edit'))
                        <button type="button" class="btn btn-icon btn-primary" data-toggle="modal" data-target="#editModal{{ $role->id }}"><i class="fas fa-pen"></i></button>
                      @endif
                      @if(auth()->user()->hasPermission('role-delete'))
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
          {{ $roles->links('pagination::bootstrap-4') }}
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
      <form action="{{ route('role.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name">
            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="">Permissions <span class="text-danger">*</span></label>
            <select class="form-control select2" style="width: 100%;" name="permissions[]" multiple>
              @foreach($permissions as $permission)
                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
              @endforeach
            </select>
            @error('permissions')<div class="text-danger">{{ $message }}</div>@enderror
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

@foreach($roles as $role)
<div class="modal fade" id="editModal{{ $role->id }}" data-backdrop="static" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('role.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="form-group">
            <label for="">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name" value="{{ $role->name }}">
            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label for="">Permissions <span class="text-danger">*</span></label>
            <select class="form-control select2" style="width: 100%;" name="permissions[]" multiple>
              @foreach($permissions as $permission)
                <option value="{{ $permission->id }}"
                  @foreach($role->permissions as $permission2)
                    @if($permission2->id == $permission->id)@selected(true)@endif
                  @endforeach
                >{{ $permission->name }}</option>
              @endforeach
            </select>
            @error('permissions')<div class="text-danger">{{ $message }}</div>@enderror
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