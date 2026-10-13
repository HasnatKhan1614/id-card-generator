<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }

    /*
     | AdminLTE / Bootstrap primary: #007bff
     | Card: 3.370in × 2.125in · 8 / A4
     */
    .id-card {
        --primary: #007bff;
        --primary-dark: #0056b3;
        --ink: #343a40;
        --muted: #6c757d;
        --line: #dee2e6;

        width: 3.370in;
        height: 2.125in;
        background: #fff;
        border-radius: 0.06in;
        overflow: hidden;
        border: 1px solid var(--line);
        page-break-inside: avoid;
        break-inside: avoid;
        font-family: "Source Sans Pro", "Segoe UI", Tahoma, sans-serif;
        color: var(--ink);
        display: flex;
        flex-direction: column;
    }

    .id-card__header {
        background: var(--primary);
        color: #fff;
        padding: 0.07in 0.10in;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.06in;
        flex-shrink: 0;
    }

    .id-card__org {
        font-size: 11pt;
        font-weight: 700;
        line-height: 1.1;
    }

    .id-card__tagline {
        font-size: 7.5pt;
        opacity: 0.92;
        margin-top: 1px;
        font-weight: 400;
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
    }

    .id-card__body {
        display: flex;
        align-items: center;
        gap: 0.10in;
        padding: 0.09in 0.10in;
        flex: 1;
        min-height: 0;
        background: #fff;
    }

    .id-card__photo {
        width: 0.78in;
        height: 0.78in;
        flex-shrink: 0;
        border-radius: 0.04in;
        object-fit: cover;
        object-position: center top;
        background: #e9ecef;
        border: 1px solid var(--line);
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
        color: var(--ink);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
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
        color: var(--muted);
        font-weight: 600;
        min-width: 0.55in;
        flex-shrink: 0;
    }

    .id-card__value {
        color: var(--ink);
        font-weight: 700;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        min-width: 0;
    }

    .id-card__footer {
        background: #f8f9fa;
        color: var(--muted);
        border-top: 1px solid var(--line);
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
        color: var(--primary-dark);
        white-space: nowrap;
        font-size: 9pt;
        font-weight: 700;
    }

    @media print {
        .id-card {
            width: 3.370in !important;
            height: 2.125in !important;
            border: 0.5pt solid #adb5bd;
            border-radius: 0.03in;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }
</style>
