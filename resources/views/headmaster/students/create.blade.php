@extends('layouts.headmaster')

@section('main-content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="mb-4" style="font-size: 1.5rem;">Create Student</h2>
            <form action="{{ route('headmaster.students.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="contact">Contact (Optional)</label>
                            <input type="text" name="contact" class="form-control" value="{{ old('contact') }}">
                            @error('contact')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="street_no">Street No</label>
                            <input type="text" name="street_no" class="form-control" required value="{{ old('street_no') }}">
                            @error('street_no')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="street_name">Street Name</label>
                            <input type="text" name="street_name" class="form-control" required value="{{ old('street_name') }}">
                            @error('street_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="city">City</label>
                            <input type="text" name="city" class="form-control" required value="{{ old('city') }}">
                            @error('city')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="postal_code">Postal Code</label>
                            <input type="text" name="postal_code" class="form-control" required value="{{ old('postal_code') }}">
                            @error('postal_code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="guardian_search">Guardian</label>
                            <input type="text" name="guardian_search" id="guardian_search" class="form-control" placeholder="Type to search for a guardian">
                            <input type="hidden" name="guardian_id" id="guardian_id">
                            <div id="guardian_list" class="list-group"></div>
                            @error('guardian_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>
</div>

@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            timer: 3000,
            timerProgressBar: true,
            onClose: () => {
                window.location.href = "{{ route('headmaster.students.index') }}";
            }
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
        });
    </script>
@endif

<script>
    document.getElementById('guardian_search').addEventListener('input', function() {
        let query = this.value;
        if (query.length >= 1) {
            fetch(`/headmaster/guardians/search?query=${query}`)
                .then(response => response.json())
                .then(data => {
                    let guardianList = document.getElementById('guardian_list');
                    guardianList.innerHTML = '';
                    data.forEach(guardian => {
                        let div = document.createElement('div');
                        div.classList.add('list-group-item', 'list-group-item-action');
                        div.textContent = guardian.name;
                        div.addEventListener('click', function() {
                            document.getElementById('guardian_search').value = guardian.name;
                            document.getElementById('guardian_id').value = guardian.id;
                            guardianList.innerHTML = '';
                        });
                        guardianList.appendChild(div);
                    });
                });
        } else {
            document.getElementById('guardian_list').innerHTML = '';
        }
    });

    document.addEventListener('click', function(event) {
        let guardianList = document.getElementById('guardian_list');
        if (!guardianList.contains(event.target) && event.target.id !== 'guardian_search') {
            guardianList.innerHTML = '';
        }
    });
</script>

<style>
    .list-group {
        position: absolute;
        width: 100%;
        z-index: 1000;
        background-color: white;
        max-height: 200px;
        overflow-y: auto;
        border: 1px solid rgba(0, 0, 0, 0.15);
        border-radius: 0.25rem;
    }
    .list-group-item {
        cursor: pointer;
    }
    .list-group-item:hover {
        background-color: #f0f0f0;
    }
</style>
@endsection
