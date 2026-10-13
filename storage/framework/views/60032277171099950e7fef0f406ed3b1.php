<?php $__env->startSection('content'); ?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-8">
                <h1>Print ID Cards</h1>
                <p class="text-muted mb-0">Pick a template, select students, then print student or parent cards.</p>
            </div>
            <div class="col-sm-4 text-right">
                <a href="<?php echo e(route('templates.index')); ?>" class="btn btn-outline-primary btn-sm">Manage templates</a>
                <a href="<?php echo e(route('registrations.index')); ?>" class="btn btn-outline-secondary btn-sm">Registrations</a>
            </div>
        </div>

        <?php if(session('error')): ?>
            <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
        <?php endif; ?>
        <div class="alert alert-danger d-none" id="print-error"></div>

        <div class="card card-outline card-primary">
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('print.index')); ?>" class="row align-items-end">
                    <div class="col-md-3 form-group">
                        <label>Template</label>
                        <select name="template_id" class="form-control" id="filter-template">
                            <?php $__empty_1 = true; $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <option value="<?php echo e($template->id); ?>" <?php if((int) ($selectedTemplateId ?? 0) === $template->id): echo 'selected'; endif; ?>>
                                    <?php echo e($template->name); ?><?php echo e($template->is_default ? ' (default)' : ''); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <option value="">No templates — create one first</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-2 form-group">
                        <label>Campus</label>
                        <select name="campus" class="form-control">
                            <option value="">All campuses</option>
                            <?php $__currentLoopData = $campuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($campus); ?>" <?php if(($filters['campus'] ?? '') === $campus): echo 'selected'; endif; ?>><?php echo e($campus); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-2 form-group">
                        <label>Class</label>
                        <select name="class" class="form-control">
                            <option value="">All classes</option>
                            <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($class); ?>" <?php if(($filters['class'] ?? '') === $class): echo 'selected'; endif; ?>><?php echo e($class); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Search</label>
                        <input type="text" name="q" class="form-control" value="<?php echo e($filters['q'] ?? ''); ?>" placeholder="ID or name">
                    </div>
                    <div class="col-md-2 form-group">
                        <button class="btn btn-primary btn-block" type="submit">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <form id="bulk-print-form" method="POST" action="<?php echo e(route('print.cards')); ?>" target="_blank">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="type" id="print-type" value="student">
            <input type="hidden" name="template_id" id="print-template-id" value="<?php echo e($selectedTemplateId); ?>">

            <div class="card">
                <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                    <div>
                        <h3 class="card-title mb-0">Ready to print (<?php echo e($students->total()); ?>)</h3>
                        <small class="text-muted" id="selected-count">0 selected</small>
                    </div>
                    <div class="btn-group mt-2 mt-md-0">
                        <button type="button" class="btn btn-success" data-print-type="student">
                            <i class="fas fa-id-card"></i> Print Student IDs
                        </button>
                        <button type="button" class="btn btn-info" data-print-type="parent">
                            <i class="fas fa-user-friends"></i> Print Parent IDs
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th style="width:40px"><input type="checkbox" id="select-all"></th>
                                    <th>Photo</th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Class</th>
                                    <th>Campus</th>
                                    <th>Guardian</th>
                                    <th class="text-right">Quick print</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="student-id" name="ids[]" value="<?php echo e($student->id); ?>">
                                        </td>
                                        <td>
                                            <?php if($student->image): ?>
                                                <img src="<?php echo e($student->image); ?>" alt="" style="width:42px;height:50px;object-fit:cover;border-radius:4px;">
                                            <?php else: ?>
                                                <span class="text-muted">—</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($student->sid); ?></td>
                                        <td><?php echo e($student->student_name ?: ($student->first_name . ' ' . $student->last_name)); ?></td>
                                        <td><?php echo e($student->class); ?></td>
                                        <td><?php echo e($student->campus); ?></td>
                                        <td><?php echo e($student->father_name ?: '—'); ?></td>
                                        <td class="text-right text-nowrap">
                                            <a href="<?php echo e(route('print.single', [$student->id, 'student'])); ?>?template_id=<?php echo e($selectedTemplateId); ?>" target="_blank" class="btn btn-sm btn-outline-success quick-print" title="Student ID">
                                                <i class="fas fa-id-card"></i>
                                            </a>
                                            <a href="<?php echo e(route('print.single', [$student->id, 'parent'])); ?>?template_id=<?php echo e($selectedTemplateId); ?>" target="_blank" class="btn btn-sm btn-outline-info quick-print" title="Parent ID">
                                                <i class="fas fa-user-friends"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">
                                            No registered students match these filters.
                                            <a href="<?php echo e(route('registration')); ?>" target="_blank">Open registration form</a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if($students->hasPages()): ?>
                    <div class="card-footer">
                        <?php echo e($students->links()); ?>

                    </div>
                <?php endif; ?>
            </div>
        </form>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script>
    (function () {
        const selectAll = document.getElementById('select-all');
        const boxes = () => document.querySelectorAll('.student-id');
        const countEl = document.getElementById('selected-count');
        const errorEl = document.getElementById('print-error');
        const form = document.getElementById('bulk-print-form');
        const typeInput = document.getElementById('print-type');
        const templateInput = document.getElementById('print-template-id');
        const filterTemplate = document.getElementById('filter-template');

        function syncTemplate() {
            if (filterTemplate && templateInput) {
                templateInput.value = filterTemplate.value;
            }
            document.querySelectorAll('.quick-print').forEach(function (link) {
                const url = new URL(link.href);
                url.searchParams.set('template_id', filterTemplate ? filterTemplate.value : '');
                link.href = url.toString();
            });
        }

        if (filterTemplate) {
            filterTemplate.addEventListener('change', syncTemplate);
        }

        function refreshCount() {
            const n = document.querySelectorAll('.student-id:checked').length;
            countEl.textContent = n + ' selected';
        }

        if (selectAll) {
            selectAll.addEventListener('change', function () {
                boxes().forEach(function (box) { box.checked = selectAll.checked; });
                refreshCount();
            });
        }

        document.addEventListener('change', function (e) {
            if (e.target.classList.contains('student-id')) refreshCount();
        });

        document.querySelectorAll('[data-print-type]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const checked = document.querySelectorAll('.student-id:checked');
                if (!checked.length) {
                    errorEl.textContent = 'Select at least one student to print.';
                    errorEl.classList.remove('d-none');
                    return;
                }
                if (!templateInput.value) {
                    errorEl.textContent = 'Create an ID card template before printing.';
                    errorEl.classList.remove('d-none');
                    return;
                }
                errorEl.classList.add('d-none');
                syncTemplate();
                typeInput.value = btn.getAttribute('data-print-type');
                form.submit();
            });
        });
    })();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Hasnat Khan\Desktop\projects\KS-ID-CARD-GENERATOR-SOFTWARE\resources\views/pages/print/index.blade.php ENDPATH**/ ?>