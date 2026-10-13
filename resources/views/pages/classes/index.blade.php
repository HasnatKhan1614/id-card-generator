@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Classes</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('classes.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Add Class
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped" id="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Sort</th>
                            <th>Status</th>
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
            ajax: "{{ route('classes.index') }}",
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'sort_order' },
                { data: 'status', orderable: false, searchable: false },
                { data: 'action', orderable: false, searchable: false }
            ]
        });

        $('#table').on('click', '.delete', function (e) {
            e.preventDefault();
            if (!confirm('Delete this class?')) return;
            var id = $(this).data('id');
            $.ajax({
                url: '/classes/' + id,
                type: 'GET',
                success: function (res) {
                    toastr.success(res.message || 'Deleted');
                    table.ajax.reload();
                },
                error: function () {
                    toastr.error('Failed to delete class');
                }
            });
        });
    });
</script>
@endsection
