@extends('layouts.admin')

@section('content')
<div class="p-4 rounded">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="text-3xl font-bold text-gray-800 mb-0">Services</h1>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addServiceModal">
            + Add Service
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table w-full border border-gray-300">
        <thead class="bg-gray-100 border-b border-gray-300">
            <tr class="text-black">
                <th class="px-4 py-2 border-r border-gray-300">Name</th>
                <th class="px-4 py-2 border-r border-gray-300">Department</th>
                <th class="px-2 py-2 text-start whitespace-nowrap w-1">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $service)
            <tr class="border-b border-gray-200">
                <td class="px-4 py-2 border-r border-gray-300">{{ $service->name }}</td>
                <td class="px-4 py-2 border-r border-gray-300">{{ $service->department->name }}</td>
                <td class="px-2 py-2 text-end whitespace-nowrap w-1">
                    <!-- Edit button -->
                    <button type="button" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#editServiceModal{{ $service->id }}">
                        Edit
                    </button>

                    <!-- Delete form -->
                    <form action="{{ route('services.destroy', $service->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>

            <!-- Edit Modal -->
            <div class="modal fade" id="editServiceModal{{ $service->id }}" tabindex="-1" aria-labelledby="editServiceModalLabel{{ $service->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="{{ route('services.update', $service->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title" id="editServiceModalLabel{{ $service->id }}">Edit Service</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="name{{ $service->id }}" class="form-label">Name</label>
                                    <input type="text" name="name" id="name{{ $service->id }}" class="form-control" value="{{ old('name', $service->name) }}" required>
                                    @error('name')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="department_id{{ $service->id }}" class="form-label">Department</label>
                                    <select name="department_id" id="department_id{{ $service->id }}" class="form-control" required>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" {{ old('department_id', $service->department_id) == $department->id ? 'selected' : '' }}>
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('department_id')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @endforeach
        </tbody>
    </table>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="addServiceForm" action="{{ route('services.store') }}" method="POST">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="addServiceModalLabel">Add Service</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <div class="mb-3">
                  <label for="name" class="form-label">Name</label>
                  <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                  @error('name')
                      <div class="text-danger small mt-1">{{ $message }}</div>
                  @enderror
              </div>
              <div class="mb-3">
                  <label for="department_id" class="form-label">Department</label>
                  <select name="department_id" id="department_id" class="form-control" required>
                      @foreach($departments as $department)
                          <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                              {{ $department->name }}
                          </option>
                      @endforeach
                  </select>
                  @error('department_id')
                      <div class="text-danger small mt-1">{{ $message }}</div>
                  @enderror
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger">Add Service</button>
          </div>
      </form>
    </div>
  </div>
</div>

<!-- Auto open modal if validation error -->
@if($errors->any())
<script>
                document.addEventListener("DOMContentLoaded", function () {
                const MAX_LENGTH = 50;

                // Cek Add Service
                const addForm = document.getElementById('addServiceForm');
                if(addForm){
                    addForm.addEventListener('submit', function(e){
                        let nameInput = this.querySelector('input[name="name"]');
                        let oldError = nameInput.nextElementSibling;

                        if(oldError && oldError.classList.contains('text-danger')){
                            oldError.remove();
                        }

                        if(nameInput.value.length > MAX_LENGTH){
                            e.preventDefault();
                            let errEl = document.createElement('div');
                            errEl.classList.add('text-danger','small','mt-1');
                            errEl.textContent = `Name must not exceed ${MAX_LENGTH} characters.`;
                            nameInput.after(errEl);
                            return false;
                        }
                    });
                }

                // Cek semua Edit Service
                document.querySelectorAll('[id^="editServiceModal"]').forEach(modal => {
                    let form = modal.querySelector('form');
                    if(form){
                        form.addEventListener('submit', function(e){
                            let nameInput = this.querySelector('input[name="name"]');
                            let oldError = nameInput.nextElementSibling;

                            if(oldError && oldError.classList.contains('text-danger')){
                                oldError.remove();
                            }

                            if(nameInput.value.length > MAX_LENGTH){
                                e.preventDefault();
                                let errEl = document.createElement('div');
                                errEl.classList.add('text-danger','small','mt-1');
                                errEl.textContent = `Name must not exceed ${MAX_LENGTH} characters.`;
                                nameInput.after(errEl);
                                return false;
                            }
                        });
                    }
                });
            });
            document.getElementById('addServiceForm').addEventListener('submit', function(e) {
                 e.preventDefault(); // cegah form submit default
                 let formData = new FormData(this);

                fetch("{{ route('services.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                    .then(res => res.json())
                    .then(data => {
                        if(data.success){
                            // tutup modal & refresh tabel bagian client
                            var addModal = bootstrap.Modal.getInstance(document.getElementById('addServiceModal'));
                            addModal.hide();
                            alert('Service added!');
                            location.reload(); // opsional, atau update table via JS
                        } else if(data.errors){
                            // tampilkan error di input
                            for (const [key, value] of Object.entries(data.errors)) {
                                let el = document.querySelector(`#addServiceForm [name="${key}"]`);
                                if(el){
                                    let errEl = el.nextElementSibling;
                                    if(!errEl || !errEl.classList.contains('text-danger')){
                                        errEl = document.createElement('div');
                                        errEl.classList.add('text-danger','small','mt-1');
                                        el.after(errEl);
                                    }
                                    errEl.textContent = value[0];
                                }
                            }
                        }
                    })
                    .catch(err => console.error(err));
                }); 
                document.addEventListener("DOMContentLoaded", function() {
                    @if(old('name') && old('department_id'))
                        // Error from Add Service
                        var addModal = new bootstrap.Modal(document.getElementById('addServiceModal'));
                        addModal.show();
                    @else
                        // Error from Edit Service
                        @foreach($services as $service)
                            @if(old('department_id') == $service->department_id)
                                var editModal = new bootstrap.Modal(document.getElementById('editServiceModal{{ $service->id }}'));
                                editModal.show();
                            @endif
                        @endforeach
                    @endif
                });
</script>
@endif

@endsection
