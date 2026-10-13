<?php $__env->startSection('content'); ?>
<?php
    $totalStudents = App\Models\Student::count();
    $registered = App\Models\Student::where('is_registered', 1)->count();
    $pending = App\Models\Student::where('is_registered', 0)->count();
    $campuses = App\Models\Campus::count();
    $classes = App\Models\SchoolClass::count();
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3><?php echo e($totalStudents); ?></h3>
                        <p>Students</p>
                    </div>
                    <div class="icon"><i class="fas fa-users"></i></div>
                    <a href="<?php echo e(route('students.index')); ?>" class="small-box-footer">Manage <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?php echo e($registered); ?></h3>
                        <p>Registered</p>
                    </div>
                    <div class="icon"><i class="fas fa-check-circle"></i></div>
                    <a href="<?php echo e(route('registrations.index')); ?>" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?php echo e($pending); ?></h3>
                        <p>Pending registration</p>
                    </div>
                    <div class="icon"><i class="fas fa-clock"></i></div>
                    <a href="<?php echo e(route('registration')); ?>" target="_blank" class="small-box-footer">Open form <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-6 col-6">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3><?php echo e($campuses); ?></h3>
                        <p>Campuses</p>
                    </div>
                    <div class="icon"><i class="fas fa-building"></i></div>
                    <a href="<?php echo e(route('campuses.index')); ?>" class="small-box-footer">Manage <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-6 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?php echo e($classes); ?></h3>
                        <p>Classes</p>
                    </div>
                    <div class="icon"><i class="fas fa-chalkboard"></i></div>
                    <a href="<?php echo e(route('classes.index')); ?>" class="small-box-footer">Manage <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card card-outline card-success">
                    <div class="card-header"><h3 class="card-title">1. Students</h3></div>
                    <div class="card-body">
                        Add or import student records.
                        <div class="mt-3">
                            <a href="<?php echo e(route('students.create')); ?>" class="btn btn-sm btn-primary">Add</a>
                            <a href="<?php echo e(route('students.index')); ?>" class="btn btn-sm btn-outline-secondary">List</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-outline card-info">
                    <div class="card-header"><h3 class="card-title">2. Registration</h3></div>
                    <div class="card-body">
                        Collect photo and guardian details via the public form.
                        <div class="mt-3">
                            <a href="<?php echo e(route('registration')); ?>" target="_blank" class="btn btn-sm btn-info">Open form</a>
                            <a href="<?php echo e(route('registrations.index')); ?>" class="btn btn-sm btn-outline-secondary">Manage</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-outline card-primary">
                    <div class="card-header"><h3 class="card-title">3. Print IDs</h3></div>
                    <div class="card-body">
                        Print student or parent ID cards from one place.
                        <div class="mt-3">
                            <a href="<?php echo e(route('print.index')); ?>" class="btn btn-sm btn-success"><i class="fas fa-print"></i> Print hub</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Hasnat Khan\Desktop\projects\KS-ID-CARD-GENERATOR-SOFTWARE\resources\views/dashboard.blade.php ENDPATH**/ ?>