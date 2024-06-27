<!-- resources/views/headmaster/grade_classes/assign_staff.blade.php -->
@extends('layouts.headmaster')
@section('main-content')
    <div class="container">
        <h1>Assign Staff to {{ $gradeClass->name }}</h1>

        <form action="{{ route('headmaster.grade_classes.assign_staff_store', $gradeClass->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="staff_id">Select Staff</label>
                <select name="staff_id" id="staff_id" class="form-control">
                    @foreach($staffs as $staff)
                        <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Assign</button>
        </form>
    </div>
@endsection
