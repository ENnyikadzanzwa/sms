@extends('layouts.headmaster')

@section('main-content')
    <div class="container">
        <h1>Grade Classes</h1>

        @if(session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                });
            </script>
        @endif

        @if(session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                });
            </script>
        @endif

        <a href="{{ route('headmaster.grade_classes.create') }}" class="btn btn-primary mb-3">Add New Class</a>

        @if($gradeClasses->isEmpty())
            <p class="mt-3">No classes available for your school.</p>
        @else
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th scope="col">Grade Name</th>
                        <th scope="col">Class Name</th>
                        <th scope="col">Staff Assigned</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($gradeClasses as $gradeClass)
                        <tr>
                            <td>{{ $gradeClass->grade->name }}</td>
                            <td>{{ $gradeClass->name }}</td>
                            <td>
                                @if($gradeClass->staff->isEmpty())
                                    No staff assigned
                                @else
                                    @foreach($gradeClass->staff as $staff)
                                        {{ $staff->name }}<br>
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('headmaster.grade_classes.edit', $gradeClass->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <a href="{{ route('headmaster.grade_classes.assign_staff', $gradeClass->id) }}" class="btn btn-sm btn-info">Assign Staff</a>
                                <form action="{{ route('headmaster.grade_classes.destroy', $gradeClass->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
