@extends('layouts.app')

@section('content')
@if (session('success'))
  <div class="alert alert-success mt-4" role="alert">
    {{ session('success') }}
  </div>
@endif
<div class="card">
  <div class="card-body">
    <h5 class="card-title fw-semibold mb-4">Menu Level</h5>
    <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addMenuLevelModal" id="addMenuLevelButton">
      Add Menu Level
    </button>
    <table id="menuLevelTable" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>Level</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="addMenuLevelModal" tabindex="-1" aria-labelledby="addMenuLevelModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addMenuLevelModalLabel">Add Menu Level</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('menu-level.store') }}" id="addMenuLevelForm">
          @csrf
          <div class="mb-3">
            <label class="form-label">Level</label>
            <input type="text" class="form-control" name="level">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="addMenuLevelSubmit">Submit</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editMenuLevelModal" tabindex="-1" aria-labelledby="editMenuLevelModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editMenuLevelModalLabel">Edit Menu Level</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('menu-level.update') }}" id="editMenuLevelForm">
          @csrf
          @method('PUT')
          <input type="hidden" name="id_level">
          <div class="mb-3">
            <label class="form-label">Level</label>
            <input type="text" class="form-control" name="level">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="editMenuLevelSubmit">Submit</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
let menuLevelTable = null;

$(document).ready(function() {
  menuLevelTable = $('#menuLevelTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('menu-level.get') }}",
    columns: [
      {data: 'DT_RowIndex', name: 'DT_RowIndex'},
      {data: 'level', name: 'level'},
      {data: 'action', name: 'action', orderable: false, searchable: false}
    ]
  });

  $('#addMenuLevelButton').click(function() {
    $('#addMenuLevelForm').trigger('reset');
  });

  $('#addMenuLevelSubmit').click(function() {
    $('#addMenuLevelForm').submit();
  });

  $('#addMenuLevelForm').submit(function(e) {
    e.preventDefault();
    var form = $(this);
    var url = form.attr('action');
    var data = form.serialize();
    $.ajax({
      url: url,
      type: 'POST',
      data: data,
      success: function(response) {
        $('#addMenuLevelModal').modal('hide');
        $('#addMenuLevelForm').trigger('reset');
        menuLevelTable.draw();
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

  $('#editMenuLevelSubmit').click(function() {
    $('#editMenuLevelForm').submit();
  });

  $('#editMenuLevelForm').submit(function(e) {
    e.preventDefault();
    var form = $(this);
    var url = form.attr('action');
    var data = form.serialize();
    $.ajax({
      url: url,
      type: 'POST',
      data: data,
      success: function(response) {
        $('#editMenuLevelModal').modal('hide');
        $('#editMenuLevelForm').trigger('reset');
        menuLevelTable.draw();
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
    url: "{{ route('menu-level.edit', ':id') }}".replace(':id', id),
    type: 'GET',
    success: function(response) {
      $('#editMenuLevelForm input[name="id_level"]').val(response.menu_level.id_level);
      $('#editMenuLevelForm input[name="level"]').val(response.menu_level.level);
      $('#editMenuLevelModal').modal('show');
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
        url: "{{ route('menu-level.destroy', ':id') }}".replace(':id', id),
        type: 'DELETE',
        data: {
          "_token": "{{ csrf_token() }}"
        },
        success: function(response) {
          menuLevelTable.draw();
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