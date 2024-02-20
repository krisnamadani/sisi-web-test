@extends('layouts.app')

@section('content')
@if (session('success'))
  <div class="alert alert-success mt-4" role="alert">
    {{ session('success') }}
  </div>
@endif
<div class="card">
  <div class="card-body">
    <h5 class="card-title fw-semibold mb-4">User</h5>
    <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addUserModal" id="addUserButton">
      Add User
    </button>
    <table id="userTable" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>Nama User</th>
          <th>Username</th>
          <th>Email</th>
          <th>No HP</th>
          <th>WA</th>
          <th>PIN</th>
          <th>Jenis User</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('user.store') }}" id="addUserForm">
          @csrf
          <div class="mb-3">
            <label class="form-label">Nama User</label>
            <input type="text" class="form-control" name="nama_user">
          </div>
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" name="username">
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password">
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email">
          </div>
          <div class="mb-3">
            <label class="form-label">No HP</label>
            <input type="text" class="form-control" name="no_hp">
          </div>
          <div class="mb-3">
            <label class="form-label">WA</label>
            <input type="text" class="form-control" name="wa">
          </div>
          <div class="mb-3">
            <label class="form-label">PIN</label>
            <input type="text" class="form-control" name="pin">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="addUserSubmit">Submit</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('user.update') }}" id="editUserForm">
          @csrf
          @method('PUT')
          <input type="hidden" name="id_user">
          <div class="mb-3">
            <label class="form-label">Nama User</label>
            <input type="text" class="form-control" name="nama_user">
          </div>
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" name="username">
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password">
            <div id="passwordHelp" class="form-text">Leave blank if you don't want to change your password.</div>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email">
          </div>
          <div class="mb-3">
            <label class="form-label">No HP</label>
            <input type="text" class="form-control" name="no_hp">
          </div>
          <div class="mb-3">
            <label class="form-label">WA</label>
            <input type="text" class="form-control" name="wa">
          </div>
          <div class="mb-3">
            <label class="form-label">PIN</label>
            <input type="text" class="form-control" name="pin">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="editUserSubmit">Submit</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
let userTable = null;

$(document).ready(function() {
  userTable = $('#userTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('user.get') }}",
    columns: [
      {data: 'DT_RowIndex', name: 'DT_RowIndex'},
      {data: 'nama_user', name: 'nama_user'},
      {data: 'username', name: 'username'},
      {data: 'email', name: 'email'},
      {data: 'no_hp', name: 'no_hp'},
      {data: 'wa', name: 'wa'},
      {data: 'pin', name: 'pin'},
      {data: 'jenis_user', name: 'jenis_user'},
      {data: 'status_user', name: 'status_user'},
      {data: 'action', name: 'action', orderable: false, searchable: false}
    ]
  });

  $('#addUserButton').click(function() {
    $('#addUserForm').trigger('reset');
  });

  $('#addUserSubmit').click(function() {
    $('#addUserForm').submit();
  });

  $('#addUserForm').submit(function(e) {
    e.preventDefault();
    var form = $(this);
    var url = form.attr('action');
    var data = form.serialize();
    $.ajax({
      url: url,
      type: 'POST',
      data: data,
      success: function(response) {
        $('#addUserModal').modal('hide');
        $('#addUserForm').trigger('reset');
        userTable.draw();
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

  $('#editUserSubmit').click(function() {
    $('#editUserForm').submit();
  });

  $('#editUserForm').submit(function(e) {
    e.preventDefault();
    var form = $(this);
    var url = form.attr('action');
    var data = form.serialize();
    $.ajax({
      url: url,
      type: 'POST',
      data: data,
      success: function(response) {
        $('#editUserModal').modal('hide');
        $('#editUserForm').trigger('reset');
        userTable.draw();
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
    url: "{{ route('user.edit', ':id') }}".replace(':id', id),
    type: 'GET',
    success: function(response) {
      $('#editUserForm input[name="id_user"]').val(response.user.id_user);
      $('#editUserForm input[name="nama_user"]').val(response.user.nama_user);
      $('#editUserForm input[name="username"]').val(response.user.username);
			$('#editUserForm input[name="email"]').val(response.user.email);
			$('#editUserForm input[name="no_hp"]').val(response.user.no_hp);
			$('#editUserForm input[name="wa"]').val(response.user.wa);
			$('#editUserForm input[name="pin"]').val(response.user.pin);
      $('#editUserModal').modal('show');
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
        url: "{{ route('user.destroy', ':id') }}".replace(':id', id),
        type: 'DELETE',
        data: {
          "_token": "{{ csrf_token() }}"
        },
        success: function(response) {
          userTable.draw();
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