@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Services</h1>

    <button class="btn btn-danger mb-3" data-bs-toggle="modal" data-bs-target="#addServiceModal">+ Add Service</button>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Department</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $service)
            <tr>
                <td>{{ $service->name }}</td>
                <td>{{ $service->department->name }}</td>
                <td>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editServiceModal{{ $service->id }}">Edit</button>
                    <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        </tbody>
    </table>
</div>
<!-- Modal Add Service-->
<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form action="{{ route('admin.services.store') }}" method="POST">
          @csrf
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="addServiceModalLabel">Add New Service</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <!-- Nama -->
                  <div class="mb-3">
                      <label for="name" class="form-label">Service Name</label>
                      <input type="text" class="form-control" name="name" id="name" required>
                  </div>
  
                  <!-- Department -->
                  <div class="mb-3">
                      <label for="department_id" class="form-label">Department</label>
                      <select name="department_id" id="department_id" class="form-control" required>
                          <option value="" disabled selected>-- Select Department --</option>
                          @foreach($departments as $dept)
                              <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                          @endforeach
                      </select>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-danger">Save</button>
              </div>
          </div>
      </form>
    </div>
  </div>
  <!-- Modal Edit -->
  <div class="modal fade" id="editServiceModal{{ $service->id }}" tabindex="-1" aria-labelledby="editServiceModalLabel{{ $service->id }}" aria-hidden="true">
    <div class="modal-dialog">
      <form action="{{ route('admin.services.update', $service->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="editServiceModalLabel{{ $service->id }}">Edit Service</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <!-- Nama -->
                  <div class="mb-3">
                      <label for="name{{ $service->id }}" class="form-label">Service Name</label>
                      <input type="text" class="form-control" name="name" id="name{{ $service->id }}" value="{{ $service->name }}" required>
                  </div>
  
                  <!-- Department -->
                  <div class="mb-3">
                      <label for="department_id{{ $service->id }}" class="form-label">Department</label>
                      <select name="department_id" id="department_id{{ $service->id }}" class="form-control" required>
                          @foreach($departments as $dept)
                              <option value="{{ $dept->id }}" {{ $service->department_id == $dept->id ? 'selected' : '' }}>
                                  {{ $dept->name }}
                              </option>
                          @endforeach
                      </select>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Update</button>
              </div>
          </div>
      </form>
    </div>
  </div>
  
@endsection
