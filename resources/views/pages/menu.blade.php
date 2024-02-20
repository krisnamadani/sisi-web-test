@extends('layouts.app')

@section('content')
@if (session('success'))
  <div class="alert alert-success mt-4" role="alert">
    {{ session('success') }}
  </div>
@endif
<div class="card">
  <div class="card-body">
    <h5 class="card-title fw-semibold mb-4">Menu</h5>
    <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addMenuModal" id="addMenuButton">
      Add Menu
    </button>
    <table id="menuTable" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>Level</th>
          <th>Menu Name</th>
          <th>Menu Link</th>
          <th>Menu Icon</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="addMenuModal" tabindex="-1" aria-labelledby="addMenuModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addMenuModalLabel">Add Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('menu.store') }}" id="addMenuForm">
          @csrf
          <div class="mb-3">
            <label class="form-label">Level</label>
            <select class="form-select" name="id_level">
              <option value="">-- Select Level --</option>
              @foreach ($menu_levels as $menu_level)
              <option value="{{ $menu_level->id_level }}">{{ $menu_level->level }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Menu Name</label>
            <input type="text" class="form-control" name="menu_name">
          </div>
          <div class="mb-3">
            <label class="form-label">Menu Link</label>
            <input type="text" class="form-control" name="menu_link">
          </div>
          <div class="mb-3">
            <label class="form-label">Menu Icon</label>
            <input type="text" class="form-control" name="menu_icon">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="addMenuSubmit">Submit</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editMenuModal" tabindex="-1" aria-labelledby="editMenuModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editMenuModalLabel">Edit Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('menu.update') }}" id="editMenuForm">
          @csrf
          @method('PUT')
          <input type="hidden" name="menu_id">
          <div class="mb-3">
            <label class="form-label">Level</label>
            <select class="form-select" name="id_level">
              <option value="">-- Select Level --</option>
              @foreach ($menu_levels as $menu_level)
              <option value="{{ $menu_level->id_level }}">{{ $menu_level->level }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Menu Name</label>
            <input type="text" class="form-control" name="menu_name">
          </div>
          <div class="mb-3">
            <label class="form-label">Menu Link</label>
            <input type="text" class="form-control" name="menu_link">
          </div>
          <div class="mb-3">
            <label class="form-label">Menu Icon</label>
            <input type="text" class="form-control" name="menu_icon">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="editMenuSubmit">Submit</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
let menuTable = null;

$(document).ready(function() {
  menuTable = $('#menuTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('menu.get') }}",
    columns: [
      {data: 'DT_RowIndex', name: 'DT_RowIndex'},
      {data: 'level', name: 'level'},
      {data: 'menu_name', name: 'menu_name'},
      {data: 'menu_link', name: 'menu_link'},
      {data: 'menu_icon', name: 'menu_icon'},
      {data: 'action', name: 'action', orderable: false, searchable: false}
    ]
  });

  $('#addMenuButton').click(function() {
    $('#addMenuForm').trigger('reset');
  });

  $('#addMenuSubmit').click(function() {
    $('#addMenuForm').submit();
  });

  $('#addMenuForm').submit(function(e) {
    e.preventDefault();
    var form = $(this);
    var url = form.attr('action');
    var data = form.serialize();
    $.ajax({
      url: url,
      type: 'POST',
      data: data,
      success: function(response) {
        $('#addMenuModal').modal('hide');
        $('#addMenuForm').trigger('reset');
        menuTable.draw();
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

  $('#editMenuSubmit').click(function() {
    $('#editMenuForm').submit();
  });

  $('#editMenuForm').submit(function(e) {
    e.preventDefault();
    var form = $(this);
    var url = form.attr('action');
    var data = form.serialize();
    $.ajax({
      url: url,
      type: 'POST',
      data: data,
      success: function(response) {
        $('#editMenuModal').modal('hide');
        $('#editMenuForm').trigger('reset');
        menuTable.draw();
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
    url: "{{ route('menu.edit', ':id') }}".replace(':id', id),
    type: 'GET',
    success: function(response) {
        $('#editMenuForm input[name="menu_id"]').val(response.menu.menu_id);
        $('#editMenuForm select[name="id_level"]').val(response.menu.id_level).change();
        $('#editMenuForm input[name="menu_name"]').val(response.menu.menu_name);
        $('#editMenuForm input[name="menu_link"]').val(response.menu.menu_link);
        $('#editMenuForm input[name="menu_icon"]').val(response.menu.menu_icon);
      $('#editMenuModal').modal('show');
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
        url: "{{ route('menu.destroy', ':id') }}".replace(':id', id),
        type: 'DELETE',
        data: {
          "_token": "{{ csrf_token() }}"
        },
        success: function(response) {
          menuTable.draw();
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