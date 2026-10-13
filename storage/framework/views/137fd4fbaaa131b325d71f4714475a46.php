<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php echo e(($preview ?? false) ? 'Template Preview — ' : ''); ?>

        <?php echo e(($type ?? 'student') === 'parent' ? 'Parent' : 'Student'); ?> ID Cards
        <?php if(isset($template)): ?> — <?php echo e($template->name); ?> <?php endif; ?>
    </title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <?php echo $__env->make('cards.styles', ['template' => $template ?? null], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <style>
        body {
            font-family: "Source Sans Pro", "Segoe UI", Tahoma, sans-serif;
            color: #343a40;
            background: #f4f6f9;
            padding: 20px 16px;
            min-height: 100vh;
        }

        .toolbar {
            width: 8.27in;
            max-width: 100%;
            margin: 0 auto 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .toolbar h1 {
            font-size: 1.2rem;
            font-weight: 700;
            margin: 0 0 4px;
        }

        .toolbar .hint {
            width: 100%;
            font-size: 0.9rem;
            color: #6c757d;
            margin: 0;
        }

        .toolbar .actions { display: flex; gap: 8px; }

        .toolbar button,
        .toolbar a {
            border: 1px solid #dee2e6;
            background: #fff;
            color: #343a40;
            padding: 8px 14px;
            border-radius: 0.25rem;
            cursor: pointer;
            font: inherit;
            font-size: 0.95rem;
            font-weight: 600;
            text-decoration: none;
        }

        .toolbar button {
            background: #007bff;
            border-color: #007bff;
            color: #fff;
        }

        .sheet {
            width: 8.27in;
            max-width: 100%;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 3.370in 3.370in;
            justify-content: center;
            column-gap: 0.28in;
            row-gap: 0.22in;
            padding: 0.28in;
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 0.35rem;
        }

        @media print {
            html, body {
                background: #fff !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .toolbar { display: none !important; }

            .sheet {
                width: auto;
                max-width: none;
                margin: 0;
                padding: 0;
                border: 0;
                border-radius: 0;
                background: transparent;
                display: grid;
                grid-template-columns: 3.370in 3.370in;
                justify-content: space-between;
                align-content: start;
                column-gap: 0.30in;
                row-gap: 0.18in;
            }

            @page {
                size: A4 portrait;
                margin: 0.45in 0.50in;
            }
        }
    </style>
</head>
<body>
    <div class="toolbar">
        <div>
            <h1>
                <?php if($preview ?? false): ?>
                    Preview: <?php echo e($template->name ?? 'Template'); ?>

                <?php else: ?>
                    <?php echo e(($type ?? 'student') === 'parent' ? 'Parent / Guardian' : 'Student'); ?>

                    ID Cards (<?php echo e($students->count()); ?>)
                <?php endif; ?>
            </h1>
            <p class="hint">
                <?php if(isset($template)): ?>
                    Template: <strong><?php echo e($template->name); ?></strong> ·
                <?php endif; ?>
                3.370 × 2.125 in · 8 cards per A4 page
            </p>
        </div>
        <div class="actions">
            <?php if($preview ?? false): ?>
                <a href="<?php echo e(route('templates.index')); ?>">Back to templates</a>
            <?php else: ?>
                <a href="<?php echo e(route('print.index')); ?>">Back</a>
            <?php endif; ?>
            <button type="button" onclick="window.print()">Print</button>
        </div>
    </div>

    <div class="sheet">
        <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('cards.id-card', [
                'student' => $student,
                'type' => $type ?? 'student',
                'template' => $template ?? null,
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <script>
        <?php if(!($preview ?? false) && $students->count() === 1): ?>
            window.addEventListener('load', function () {
                setTimeout(function () { window.print(); }, 350);
            });
        <?php endif; ?>
    </script>
</body>
</html>
<?php /**PATH C:\Users\Hasnat Khan\Desktop\projects\KS-ID-CARD-GENERATOR-SOFTWARE\resources\views/cards/print.blade.php ENDPATH**/ ?>