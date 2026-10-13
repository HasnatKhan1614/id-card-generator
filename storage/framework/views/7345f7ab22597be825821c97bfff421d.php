<?php $__env->startSection('content'); ?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>ID Card Templates</h1>
                <p class="text-muted mb-0">Create multiple designs and choose one when printing.</p>
            </div>
            <div class="col-sm-6 text-right">
                <a href="<?php echo e(route('templates.create')); ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> New Template
                </a>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        <div class="row">
            <?php $__empty_1 = true; $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php $s = $template->mergedSettings(); ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card card-outline <?php echo e($template->is_default ? 'card-primary' : 'card-secondary'); ?>">
                        <div class="card-header">
                            <h3 class="card-title mb-0">
                                <?php echo e($template->name); ?>

                                <?php if($template->is_default): ?>
                                    <span class="badge badge-primary">Default</span>
                                <?php endif; ?>
                                <?php if (! ($template->is_active)): ?>
                                    <span class="badge badge-secondary">Inactive</span>
                                <?php endif; ?>
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-2" style="height:10px;border-radius:4px;background:<?php echo e($s['header_bg']); ?>;"></div>
                            <p class="mb-1"><strong>Layout:</strong> <?php echo e(ucfirst($s['layout'])); ?></p>
                            <p class="mb-1"><strong>Org:</strong> <?php echo e($s['organization']); ?></p>
                            <p class="mb-0 text-muted small">
                                Fields:
                                <?php if($s['show_sid']): ?> ID <?php endif; ?>
                                <?php if($s['show_class']): ?> · Class <?php endif; ?>
                                <?php if($s['show_campus']): ?> · Campus <?php endif; ?>
                                <?php if($s['show_guardian']): ?> · Guardian <?php endif; ?>
                                <?php if($s['show_phone']): ?> · Phone <?php endif; ?>
                                <?php if($s['show_address']): ?> · Address <?php endif; ?>
                            </p>
                        </div>
                        <div class="card-footer">
                            <a href="<?php echo e(route('templates.preview', $template)); ?>" target="_blank" class="btn btn-sm btn-outline-info">Preview</a>
                            <a href="<?php echo e(route('templates.edit', $template)); ?>" class="btn btn-sm btn-primary">Edit</a>
                            <?php if (! ($template->is_default)): ?>
                                <form action="<?php echo e(route('templates.default', $template)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button class="btn btn-sm btn-outline-secondary" type="submit">Set default</button>
                                </form>
                                <form action="<?php echo e(route('templates.destroy', $template)); ?>" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this template?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-12">
                    <div class="alert alert-info">No templates yet. Create your first design.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Hasnat Khan\Desktop\projects\KS-ID-CARD-GENERATOR-SOFTWARE\resources\views/pages/templates/index.blade.php ENDPATH**/ ?>