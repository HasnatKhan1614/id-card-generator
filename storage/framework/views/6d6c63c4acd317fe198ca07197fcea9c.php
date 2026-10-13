<?php
    $t = isset($template) ? $template->mergedSettings() : \App\Models\IdCardTemplate::defaults();
    $photoSizes = ['small' => '0.62in', 'medium' => '0.78in', 'large' => '0.92in'];
    $logoSizes = ['small' => '0.28in', 'medium' => '0.36in', 'large' => '0.44in'];
    $photoSize = $photoSizes[$t['photo_size'] ?? 'medium'] ?? '0.78in';
    $logoSize = $logoSizes[$t['logo_size'] ?? 'medium'] ?? '0.36in';
    $scoped = $scoped ?? false;
?>
<style>
    <?php if(! $scoped): ?>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    <?php else: ?>
    .id-card, .id-card * { box-sizing: border-box; }
    <?php endif; ?>

    .id-card {
        --header-bg: <?php echo e($t['header_bg']); ?>;
        --header-text: <?php echo e($t['header_text']); ?>;
        --body-bg: <?php echo e($t['body_bg']); ?>;
        --footer-bg: <?php echo e($t['footer_bg']); ?>;
        --footer-text: <?php echo e($t['footer_text']); ?>;
        --name-color: <?php echo e($t['name_color']); ?>;
        --label-color: <?php echo e($t['label_color']); ?>;
        --value-color: <?php echo e($t['value_color']); ?>;
        --accent: <?php echo e($t['accent_color']); ?>;
        --border: <?php echo e($t['border_color']); ?>;
        --photo-size: <?php echo e($photoSize); ?>;
        --logo-size: <?php echo e($logoSize); ?>;

        width: 3.370in;
        height: 2.125in;
        background: var(--body-bg);
        border-radius: 0.06in;
        overflow: hidden;
        border: 1px solid var(--border);
        page-break-inside: avoid;
        break-inside: avoid;
        font-family: "Source Sans Pro", "Segoe UI", Tahoma, sans-serif;
        color: var(--value-color);
        display: flex;
        flex-direction: column;
    }

    .id-card__header {
        background: var(--header-bg);
        color: var(--header-text);
        padding: 0.07in 0.10in;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.06in;
        flex-shrink: 0;
    }

    .id-card--banner .id-card__header {
        padding: 0.10in 0.10in;
    }

    .id-card__brand {
        display: flex;
        align-items: center;
        gap: 0.07in;
        min-width: 0;
        flex: 1;
    }

    .id-card__logo {
        width: var(--logo-size);
        height: var(--logo-size);
        object-fit: contain;
        flex-shrink: 0;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 0.03in;
        padding: 0.01in;
    }

    .id-card__brand-text {
        min-width: 0;
    }

    .id-card__org {
        font-size: 11pt;
        font-weight: 700;
        line-height: 1.1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .id-card__tagline {
        font-size: 7.5pt;
        opacity: 0.92;
        margin-top: 1px;
        font-weight: 400;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .id-card__badge {
        font-size: 7pt;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        background: rgba(255, 255, 255, 0.18);
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 999px;
        padding: 0.02in 0.06in;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .id-card__body {
        display: flex;
        align-items: center;
        gap: 0.10in;
        padding: 0.09in 0.10in;
        flex: 1;
        min-height: 0;
        background: var(--body-bg);
    }

    .id-card--stacked .id-card__body {
        flex-direction: column;
        align-items: flex-start;
        justify-content: center;
        gap: 0.05in;
        padding-top: 0.06in;
        padding-bottom: 0.06in;
    }

    .id-card--stacked .id-card__photo {
        align-self: center;
    }

    .id-card--stacked .id-card__info {
        width: 100%;
    }

    .id-card__photo {
        width: var(--photo-size);
        height: var(--photo-size);
        flex-shrink: 0;
        border-radius: 0.04in;
        object-fit: cover;
        object-position: center top;
        background: #e9ecef;
        border: 1px solid var(--border);
    }

    .id-card__info {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 0.03in;
    }

    .id-card__name {
        font-size: 12.5pt;
        font-weight: 700;
        line-height: 1.15;
        color: var(--name-color);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin: 0;
    }

    .id-card__rows {
        display: flex;
        flex-direction: column;
        gap: 0.015in;
    }

    .id-card__row {
        display: flex;
        align-items: baseline;
        gap: 0.06in;
        font-size: 9pt;
        line-height: 1.25;
    }

    .id-card__label {
        color: var(--label-color);
        font-weight: 600;
        min-width: 0.55in;
        flex-shrink: 0;
    }

    .id-card__value {
        color: var(--value-color);
        font-weight: 700;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        min-width: 0;
    }

    .id-card__footer {
        background: var(--footer-bg);
        color: var(--footer-text);
        border-top: 1px solid var(--border);
        padding: 0.045in 0.10in 0.055in;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 8pt;
        gap: 0.06in;
        flex-shrink: 0;
    }

    .id-card__footer span {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-weight: 500;
    }

    .id-card__footer strong {
        color: var(--accent);
        white-space: nowrap;
        font-size: 9pt;
        font-weight: 700;
    }

    .id-card__hidden {
        display: none !important;
    }

    @media print {
        .id-card {
            width: 3.370in !important;
            height: 2.125in !important;
            border: 0.5pt solid var(--border);
            border-radius: 0.03in;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }
</style>
<?php /**PATH C:\Users\Hasnat Khan\Desktop\projects\KS-ID-CARD-GENERATOR-SOFTWARE\resources\views/cards/styles.blade.php ENDPATH**/ ?>