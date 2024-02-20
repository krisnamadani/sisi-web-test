@extends('layouts.app')

@section('content')
@if (session('success'))
  <div class="alert alert-success mt-4" role="alert">
    {{ session('success') }}
  </div>
@endif
<div class="card">
  <div class="card-body">
    <h5 class="card-title fw-semibold mb-4">Menu User</h5>
    <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addMenuUserModal" id="addMenuUserButton">
      Add Menu User
    </button>
    <table id="menuUserTable" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>User</th>
          <th>Menu</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="addMenuUserModal" tabindex="-1" aria-labelledby="addMenuUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addMenuUserModalLabel">Add Menu User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('menu-user.store') }}" id="addMenuUserForm">
          @csrf
          <div class="mb-3">
            <label class="form-label">User</label>
            <select class="form-select" name="id_user">
              <option value="">-- Select User --</option>
              @foreach ($users as $user)
              <option value="{{ $user->id_user }}">{{ $user->nama_user }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Menu</label>
            <select class="form-select" name="menu_id">
              <option value="">-- Select Menu --</option>
              @foreach ($menus as $menu)
              <option value="{{ $menu->menu_id }}">{{ $menu->menu_name }}</option>
              @endforeach
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="addMenuUserSubmit">Submit</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editMenuUserModal" tabindex="-1" aria-labelledby="editMenuUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editMenuUserModalLabel">Edit Menu User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('menu-user.update') }}" id="editMenuUserForm">
          @csrf
          @method('PUT')
          <input type="hidden" name="no_seting">
          <div class="mb-3">
            <label class="form-label">User</label>
            <select class="form-select" name="id_user">
              <option value="">-- Select User --</option>
              @foreach ($users as $user)
              <option value="{{ $user->id_user }}">{{ $user->nama_user }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Menu</label>
            <select class="form-select" name="menu_id">
              <option value="">-- Select Menu --</option>
              @foreach ($menus as $menu)
              <option value="{{ $menu->menu_id }}">{{ $menu->menu_name }}</option>
              @endforeach
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="editMenuUserSubmit">Submit</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
let menuUserTable = null;

$(document).ready(function() {
  menuUserTable = $('#menuUserTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('menu-user.get') }}",
    columns: [
      {data: 'DT_RowIndex', name: 'DT_RowIndex'},
      {data: 'user', name: 'user'},
      {data: 'menu', name: 'menu'},
      {data: 'action', name: 'action', orderable: false, searchable: false}
    ]
  });

  $('#addMenuUserButton').click(function() {
    $('#addMenuUserForm').trigger('reset');
  });

  $('#addMenuUserSubmit').click(function() {
    $('#addMenuUserForm').submit();
  });

  $('#addMenuUserForm').submit(function(e) {
    e.preventDefault();
    var form = $(this);
    var url = form.attr('action');
    var data = form.serialize();
    $.ajax({
      url: url,
      type: 'POST',
      data: data,
      success: function(response) {
        $('#addMenuUserModal').modal('hide');
        $('#addMenuUserForm').trigger('reset');
        menuUserTable.draw();
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: response.message
        });
      },
      error: function(error) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: error.responseJSON.message
        });
      }
    });
  });

  $('#editMenuUserSubmit').click(function() {
    $('#editMenuUserForm').submit();
  });

  $('#editMenuUserForm').submit(function(e) {
    e.preventDefault();
    var form = $(this);
    var url = form.attr('action');
    var data = form.serialize();
    $.ajax({
      url: url,
      type: 'POST',
      data: data,
      success: function(response) {
        $('#editMenuUserModal').modal('hide');
        $('#editMenuUserForm').trigger('reset');
        menuUserTable.draw();
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: response.message
        });
      },
      error: function(error) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: error.responseJSON.message
        });
      }
    });
  });
});

function edit(id) {
  $.ajax({
    url: "{{ route('menu-user.edit', ':id') }}".replace(':id', id),
    type: 'GET',
    success: function(response) {
        $('#editMenuUserForm input[name="no_seting"]').val(response.menu_user.no_seting);
        $('#editMenuUserForm select[name="id_user"]').val(response.menu_user.id_user).change();
        $('#editMenuUserForm select[name="menu_id"]').val(response.menu_user.menu_id).change();
      $('#editMenuUserModal').modal('show');
    },
    error: function(error) {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: error.responseJSON.message
      });
    }
  });
}

function destroy(id) {
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "{{ route('menu-user.destroy', ':id') }}".replace(':id', id),
        type: 'DELETE',
        data: {
          "_token": "{{ csrf_token() }}"
        },
        success: function(response) {
          menuUserTable.draw();
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: response.message
          });
        },
        error: function(error) {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.responseJSON.message
          });
        }
      });
    }
  });
}
</script>
@endsection