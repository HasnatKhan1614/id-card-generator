<?php
    $t = isset($template) ? $template->mergedSettings() : \App\Models\IdCardTemplate::defaults();
    $layout = $t['layout'] ?? 'classic';
    $displayName = $student->student_name ?: trim(($student->first_name ?? '') . ' ' . ($student->last_name ?? ''));
    $photo = $student->image ?: 'https://placehold.co/156x156/e9ecef/6c757d?text=Photo';
    $badge = ($type ?? 'student') === 'parent'
        ? ($t['parent_badge'] ?? 'Parent Copy')
        : ($t['student_badge'] ?? 'Student');
?>

<article class="id-card id-card--<?php echo e($layout); ?>">
    <header class="id-card__header">
        <div>
            <div class="id-card__org"><?php echo e($t['organization']); ?></div>
            <?php if(! empty($t['tagline'])): ?>
                <div class="id-card__tagline"><?php echo e($t['tagline']); ?></div>
            <?php endif; ?>
        </div>
        <?php if(! empty($t['show_badge'])): ?>
            <span class="id-card__badge"><?php echo e($badge); ?></span>
        <?php endif; ?>
    </header>

    <div class="id-card__body">
        <?php if(! empty($t['show_photo'])): ?>
            <img class="id-card__photo" src="<?php echo e($photo); ?>" alt="<?php echo e($displayName); ?>">
        <?php endif; ?>

        <div class="id-card__info">
            <h2 class="id-card__name"><?php echo e($displayName ?: 'Unnamed Student'); ?></h2>

            <div class="id-card__rows">
                <?php if(! empty($t['show_sid'])): ?>
                    <div class="id-card__row">
                        <span class="id-card__label">ID</span>
                        <span class="id-card__value"><?php echo e($student->sid); ?></span>
                    </div>
                <?php endif; ?>
                <?php if(! empty($t['show_class'])): ?>
                    <div class="id-card__row">
                        <span class="id-card__label">Class</span>
                        <span class="id-card__value"><?php echo e($student->class ?: '—'); ?></span>
                    </div>
                <?php endif; ?>
                <?php if(! empty($t['show_campus'])): ?>
                    <div class="id-card__row">
                        <span class="id-card__label">Campus</span>
                        <span class="id-card__value"><?php echo e($student->campus ?: '—'); ?></span>
                    </div>
                <?php endif; ?>
                <?php if(! empty($t['show_guardian'])): ?>
                    <div class="id-card__row">
                        <span class="id-card__label">Guardian</span>
                        <span class="id-card__value"><?php echo e($student->father_name ?: '—'); ?></span>
                    </div>
                <?php endif; ?>
                <?php if(! empty($t['show_phone'])): ?>
                    <div class="id-card__row">
                        <span class="id-card__label">Phone</span>
                        <span class="id-card__value"><?php echo e($student->phone ?: '—'); ?></span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if(! empty($t['show_address']) || ! empty($t['show_footer_sid'])): ?>
        <footer class="id-card__footer">
            <span>
                <?php if(! empty($t['show_address'])): ?>
                    <?php echo e($student->address ?: 'Address not provided'); ?>

                <?php endif; ?>
            </span>
            <?php if(! empty($t['show_footer_sid'])): ?>
                <strong>#<?php echo e($student->sid); ?></strong>
            <?php endif; ?>
        </footer>
    <?php endif; ?>
</article>
<?php /**PATH C:\Users\Hasnat Khan\Desktop\projects\KS-ID-CARD-GENERATOR-SOFTWARE\resources\views/cards/id-card.blade.php ENDPATH**/ ?>