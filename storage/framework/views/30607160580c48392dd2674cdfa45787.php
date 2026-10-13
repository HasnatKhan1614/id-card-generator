<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Registration — <?php echo e($org); ?></title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?php echo e(env('ASSET_URL')); ?>/assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?php echo e(env('ASSET_URL')); ?>/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo e(env('ASSET_URL')); ?>/assets/dist/css/adminlte.min.css?v=3.2.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        body.register-page {
            background: #f4f6f9;
        }

        .register-box {
            width: 100%;
            max-width: 640px;
            margin: 2rem auto;
        }

        .register-logo a {
            color: #343a40;
            font-size: 1.75rem;
        }

        .register-logo span {
            color: #007bff;
            font-weight: 700;
        }

        .step-bar {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            border-bottom: 1px solid #dee2e6;
            background: #f8f9fa;
        }

        .step-bar .step {
            padding: 0.75rem 0.5rem;
            text-align: center;
            font-size: 0.85rem;
            color: #6c757d;
            border-right: 1px solid #dee2e6;
            font-weight: 600;
        }

        .step-bar .step:last-child { border-right: 0; }
        .step-bar .step.active {
            color: #007bff;
            background: #fff;
            box-shadow: inset 0 -2px 0 #007bff;
        }

        .section-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #6c757d;
            font-weight: 700;
            margin-bottom: 0.75rem;
        }

        .student-meta {
            display: none;
            background: #e7f1ff;
            border: 1px solid #b6d4fe;
            color: #084298;
            border-radius: 0.25rem;
            padding: 0.6rem 0.8rem;
            margin-top: 0.75rem;
        }

        .student-meta.is-visible { display: block; }

        .upload-box {
            display: flex;
            gap: 1rem;
            align-items: center;
            border: 1px dashed #ced4da;
            border-radius: 0.35rem;
            padding: 0.75rem;
            background: #f8f9fa;
        }

        .upload-box img {
            width: 84px;
            height: 84px;
            object-fit: cover;
            border-radius: 0.35rem;
            border: 1px solid #dee2e6;
            background: #fff;
        }

        #already-registered-message,
        #details-fields { display: none; }

        #already-registered-message.is-visible,
        #details-fields.is-visible { display: block; }

        #details-fields {
            margin-top: 1.25rem;
            padding-top: 1.25rem;
            border-top: 1px solid #dee2e6;
        }

        @media (max-width: 576px) {
            .register-box { margin: 1rem; }
            .upload-box { flex-direction: column; align-items: flex-start; }
            .step-bar { grid-template-columns: 1fr; }
            .step-bar .step { border-right: 0; border-bottom: 1px solid #dee2e6; }
        }
    </style>
</head>
<body class="hold-transition register-page">
<?php
    $oldCampus = old('campus');
    $oldClass = old('class_id');
    $oldStudentId = old('student_id');
    $hasOld = $errors->any() || session('error');
?>

<div class="register-box">
    <div class="register-logo">
        <a href="#"><span><?php echo e($org); ?></span></a>
        <p class="text-muted mb-0" style="font-size:0.95rem;">Student ID card registration</p>
    </div>

    <div class="card card-outline card-primary">
        <div class="step-bar">
            <div class="step active">1. Find student</div>
            <div class="step" id="step-2">2. Details</div>
            <div class="step" id="step-3">3. Submit</div>
        </div>

        <div class="card-body register-card-body">
            <?php if(session('message')): ?>
                <div class="alert alert-success"><?php echo e(session('message')); ?></div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0 pl-3">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div id="already-registered-message" class="alert alert-warning">
                This student is already registered.
            </div>

            <form method="POST" action="<?php echo e(route('user.registration')); ?>" enctype="multipart/form-data" novalidate>
                <?php echo csrf_field(); ?>

                <p class="section-label">Student lookup</p>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="campus">Campus</label>
                        <select id="campus" name="campus" class="form-control <?php $__errorArgs = ['campus'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="" disabled <?php echo e($oldCampus ? '' : 'selected'); ?>>Select campus</option>
                            <?php $__currentLoopData = $campuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($campus); ?>" <?php if($oldCampus === $campus): echo 'selected'; endif; ?>><?php echo e($campus); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="class_id">Class</label>
                        <select id="class_id" name="class_id" class="form-control <?php $__errorArgs = ['class_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required <?php echo e($oldCampus ? '' : 'disabled'); ?>>
                            <option value="" disabled <?php echo e($oldClass ? '' : 'selected'); ?>>Select class</option>
                            <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($class); ?>" <?php if($oldClass === $class): echo 'selected'; endif; ?>><?php echo e($class); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-12 form-group mb-0">
                        <label for="student_id">Student</label>
                        <select id="student_id" name="student_id" class="form-control <?php $__errorArgs = ['student_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required <?php echo e(($oldCampus && $oldClass) ? '' : 'disabled'); ?>>
                            <option value="" disabled selected>Select student</option>
                        </select>
                    </div>
                </div>

                <div class="student-meta" id="student-meta">
                    Selected: <strong id="student-meta-text">—</strong>
                </div>

                <div id="details-fields">
                    <p class="section-label">Card details</p>
                    <div class="row">
                        <div class="col-12 form-group">
                            <label for="student_name">Name on card</label>
                            <input type="text" id="student_name" name="student_name" class="form-control <?php $__errorArgs = ['student_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('student_name')); ?>" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="father_name">Guardian name</label>
                            <input type="text" id="father_name" name="father_name" class="form-control <?php $__errorArgs = ['father_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('father_name')); ?>" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="phone">Phone</label>
                            <input type="text" id="phone" name="phone" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('phone')); ?>" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="dob">Date of birth</label>
                            <input type="date" id="dob" name="dob" class="form-control <?php $__errorArgs = ['dob'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('dob')); ?>" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="address">Address</label>
                            <input type="text" id="address" name="address" class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('address')); ?>" required>
                        </div>
                        <div class="col-12 form-group">
                            <label for="image">Photo</label>
                            <div class="upload-box">
                                <img id="photo-preview" src="https://placehold.co/168x168/e9ecef/6c757d?text=Photo" alt="Preview">
                                <div class="flex-grow-1">
                                    <input type="file" id="image" name="image" class="form-control-file <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           accept="image/png,image/jpeg,image/jpg" required>
                                    <small class="form-text text-muted">JPG or PNG, max 2MB.</small>
                                    <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger small mt-1"><?php echo e($message); ?> — please choose the photo again.</div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block" id="submit-btn">
                        <i class="fas fa-check mr-1"></i> Submit registration
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?php echo e(env('ASSET_URL')); ?>/assets/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo e(env('ASSET_URL')); ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo e(env('ASSET_URL')); ?>/assets/dist/js/adminlte.min.js?v=3.2.0"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
(function () {
    const oldStudentId = <?php echo json_encode($oldStudentId, 15, 512) ?>;
    const oldStudentName = <?php echo json_encode(old('student_name'), 15, 512) ?>;
    const shouldRestore = <?php echo json_encode((bool) $hasOld && $oldCampus && $oldClass, 15, 512) ?>;

    const campusEl = document.getElementById('campus');
    const classEl = document.getElementById('class_id');
    const studentEl = document.getElementById('student_id');
    const detailsEl = document.getElementById('details-fields');
    const alreadyEl = document.getElementById('already-registered-message');
    const metaEl = document.getElementById('student-meta');
    const metaText = document.getElementById('student-meta-text');
    const step2 = document.getElementById('step-2');
    const step3 = document.getElementById('step-3');
    const submitBtn = document.getElementById('submit-btn');
    const imageInput = document.getElementById('image');
    const preview = document.getElementById('photo-preview');

    function setDetailsVisible(show) {
        detailsEl.classList.toggle('is-visible', show);
        step2.classList.toggle('active', show);
        step3.classList.toggle('active', show);
        if (show && imageInput) imageInput.required = true;
    }

    function resetStudentSelect(placeholder) {
        studentEl.innerHTML = '<option value="" disabled selected>' + placeholder + '</option>';
        studentEl.disabled = true;
        metaEl.classList.remove('is-visible');
        alreadyEl.classList.remove('is-visible');
        setDetailsVisible(false);
    }

    function loadStudents(campus, className, selectedId) {
        if (!campus || !className) {
            resetStudentSelect('Select student');
            return;
        }

        studentEl.disabled = true;
        studentEl.innerHTML = '<option value="" disabled selected>Loading…</option>';

        $.get('/get-students-by-class/' + encodeURIComponent(className) + '/' + encodeURIComponent(campus))
            .done(function (data) {
                studentEl.innerHTML = '<option value="" disabled selected>Select student</option>';
                (data.students || []).forEach(function (student) {
                    const label = 'ID: ' + student.sid + ' — ' + (student.first_name || '') + ' ' + (student.last_name || '');
                    const opt = document.createElement('option');
                    opt.value = student.id;
                    opt.textContent = label.trim();
                    opt.dataset.isRegistered = student.is_registered;
                    opt.dataset.label = label.trim();
                    opt.dataset.firstName = student.first_name || '';
                    opt.dataset.lastName = student.last_name || '';
                    if (String(selectedId) === String(student.id)) opt.selected = true;
                    studentEl.appendChild(opt);
                });
                studentEl.disabled = false;
                if (selectedId) studentEl.dispatchEvent(new Event('change'));
            })
            .fail(function () {
                studentEl.innerHTML = '<option value="" disabled selected>Could not load students</option>';
            });
    }

    campusEl.addEventListener('change', function () {
        classEl.disabled = !campusEl.value;
        classEl.value = '';
        resetStudentSelect('Select student');
    });

    classEl.addEventListener('change', function () {
        loadStudents(campusEl.value, classEl.value, null);
    });

    studentEl.addEventListener('change', function () {
        const opt = studentEl.options[studentEl.selectedIndex];
        if (!opt || !opt.value) {
            setDetailsVisible(false);
            metaEl.classList.remove('is-visible');
            return;
        }

        const registered = String(opt.dataset.isRegistered) === '1';
        metaText.textContent = opt.dataset.label || opt.textContent;
        metaEl.classList.add('is-visible');

        if (registered) {
            alreadyEl.classList.add('is-visible');
            setDetailsVisible(false);
            submitBtn.disabled = true;
            return;
        }

        alreadyEl.classList.remove('is-visible');
        submitBtn.disabled = false;
        setDetailsVisible(true);

        const nameInput = document.getElementById('student_name');
        if (nameInput) {
            if (oldStudentName && String(opt.value) === String(oldStudentId)) {
                nameInput.value = oldStudentName;
            } else if (!nameInput.value) {
                const guessed = ((opt.dataset.firstName || '') + ' ' + (opt.dataset.lastName || '')).trim();
                if (guessed) nameInput.value = guessed;
            }
        }
    });

    imageInput.addEventListener('change', function () {
        const file = this.files && this.files[0];
        if (!file) return;
        preview.src = URL.createObjectURL(file);
    });

    if (shouldRestore) {
        classEl.disabled = false;
        loadStudents(campusEl.value, classEl.value, oldStudentId);
        if (imageInput) imageInput.required = true;
    }

    <?php if(session('message')): ?>
        toastr.success(<?php echo json_encode(session('message'), 15, 512) ?>);
    <?php endif; ?>
    <?php if(session('error')): ?>
        toastr.error(<?php echo json_encode(session('error'), 15, 512) ?>);
    <?php endif; ?>
})();
</script>
</body>
</html>
<?php /**PATH C:\Users\Hasnat Khan\Desktop\projects\KS-ID-CARD-GENERATOR-SOFTWARE\resources\views/registration.blade.php ENDPATH**/ ?>