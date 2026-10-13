<?php $__env->startSection('content'); ?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Campuses</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="<?php echo e(route('campuses.create')); ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Add Campus
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
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Address</th>
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
        var table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "<?php echo e(route('campuses.index')); ?>",
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'contact_number' },
                { data: 'email' },
                { data: 'address' },
                { data: 'action', orderable: false, searchable: false }
            ]
        });

        $('#table').on('click', '.delete', function (e) {
            e.preventDefault();
            if (!confirm('Delete this campus?')) return;
            var id = $(this).data('id');
            $.ajax({
                url: '/campuses/' + id,
                type: 'GET',
                success: function (res) {
                    toastr.success(res.message || 'Deleted');
                    table.ajax.reload();
                },
                error: function () {
                    toastr.error('Failed to delete campus');
                }
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Hasnat Khan\Desktop\projects\KS-ID-CARD-GENERATOR-SOFTWARE\resources\views/pages/campuses/index.blade.php ENDPATH**/ ?>