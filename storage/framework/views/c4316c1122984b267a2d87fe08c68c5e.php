<?php $__env->startSection('content'); ?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Students</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="<?php echo e(route('students.create')); ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Add Student
                </a>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Import from Excel / CSV</h3>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('students.import')); ?>" method="POST" enctype="multipart/form-data" class="form-inline">
                    <?php echo csrf_field(); ?>
                    <div class="input-group mr-2 mb-2">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="importFile" name="file" required>
                            <label class="custom-file-label" for="importFile">Choose file</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-secondary mb-2">Upload</button>
                    <?php if(file_exists(public_path('files/sample_students.xlsx'))): ?>
                        <a href="<?php echo e(asset('files/sample_students.xlsx')); ?>" class="btn btn-link mb-2">Sample file</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">All students</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped" id="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>SID</th>
                            <th>Campus</th>
                            <th>Class</th>
                            <th>First name</th>
                            <th>Last name</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script>
    $(document).ready(function () {
        $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "<?php echo e(route('students.index')); ?>",
            columns: [
                { data: 'id' },
                { data: 'sid' },
                { data: 'campus', defaultContent: '' },
                { data: 'class', defaultContent: '' },
                { data: 'first_name' },
                { data: 'last_name' },
                { data: 'status', orderable: false, searchable: false },
                { data: 'action', orderable: false, searchable: false }
            ]
        });

        $('.custom-file-input').on('change', function () {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });

        $(document).on('click', '.delete', function (e) {
            e.preventDefault();
            if (!confirm('Delete this student?')) return;
            var url = $(this).attr('href');
            $.ajax({
                url: url,
                type: 'DELETE',
                data: { _token: '<?php echo e(csrf_token()); ?>' },
                success: function (res) {
                    toastr.success(res.message || 'Deleted');
                    $('#table').DataTable().ajax.reload();
                },
                error: function () {
                    toastr.error('Failed to delete student');
                }
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Hasnat Khan\Desktop\projects\KS-ID-CARD-GENERATOR-SOFTWARE\resources\views/pages/students/index.blade.php ENDPATH**/ ?>