@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-8">
                <h1>Registrations</h1>
                <p class="text-muted mb-0">Students who completed registration (photo + details).</p>
            </div>
            <div class="col-sm-4 text-right">
                <a href="{{ route('print.index') }}" class="btn btn-success btn-sm"><i class="fas fa-print"></i> Print IDs</a>
                <a href="{{ route('registration') }}" target="_blank" class="btn btn-outline-primary btn-sm">Public form</a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <select id="campus_filter" class="form-control">
                            <option value="">All campuses</option>
                            @foreach ($campuses as $campus)
                                <option value="{{ $campus }}">{{ $campus }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select id="class_filter" class="form-control">
                            <option value="">All classes</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class }}">{{ $class }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <table class="table table-bordered table-striped" id="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>SID</th>
                            <th>Campus</th>
                            <th>Class</th>
                            <th>Name</th>
                            <th>Guardian</th>
                            <th>Phone</th>
                            <th>Registered</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        var table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('registrations.index') }}",
                data: function (d) {
                    d.class_filter = $('#class_filter').val();
                    d.campus_filter = $('#campus_filter').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'sid' },
                { data: 'campus' },
                { data: 'class' },
                { data: 'student_name', defaultContent: '' },
                { data: 'father_name', defaultContent: '' },
                { data: 'phone', defaultContent: '' },
                { data: 'updated_at' },
                { data: 'action', orderable: false, searchable: false }
            ]
        });

        $('#class_filter, #campus_filter').on('change', function () {
            table.ajax.reload();
        });
    });
</script>
@endsection
