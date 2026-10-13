<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        {{ ($preview ?? false) ? 'Template Preview — ' : '' }}
        {{ ($type ?? 'student') === 'parent' ? 'Parent' : 'Student' }} ID Cards
        @isset($template) — {{ $template->name }} @endisset
    </title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    @include('cards.styles', ['template' => $template ?? null])
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
                @if ($preview ?? false)
                    Preview: {{ $template->name ?? 'Template' }}
                @else
                    {{ ($type ?? 'student') === 'parent' ? 'Parent / Guardian' : 'Student' }}
                    ID Cards ({{ $students->count() }})
                @endif
            </h1>
            <p class="hint">
                @isset($template)
                    Template: <strong>{{ $template->name }}</strong> ·
                @endisset
                3.370 × 2.125 in · 8 cards per A4 page
            </p>
        </div>
        <div class="actions">
            @if ($preview ?? false)
                <a href="{{ route('templates.index') }}">Back to templates</a>
            @else
                <a href="{{ route('print.index') }}">Back</a>
            @endif
            <button type="button" onclick="window.print()">Print</button>
        </div>
    </div>

    <div class="sheet">
        @foreach ($students as $student)
            @include('cards.id-card', [
                'student' => $student,
                'type' => $type ?? 'student',
                'template' => $template ?? null,
            ])
        @endforeach
    </div>

    <script>
        @if (!($preview ?? false) && $students->count() === 1)
            window.addEventListener('load', function () {
                setTimeout(function () { window.print(); }, 350);
            });
        @endif
    </script>
</body>
</html>
