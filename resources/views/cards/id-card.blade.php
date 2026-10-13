@php
    $t = isset($template) ? $template->mergedSettings() : \App\Models\IdCardTemplate::defaults();
    $layout = $t['layout'] ?? 'classic';
    $displayName = $student->student_name ?: trim(($student->first_name ?? '') . ' ' . ($student->last_name ?? ''));
    $photo = $student->image ?: 'https://placehold.co/156x156/e9ecef/6c757d?text=Photo';
    $badge = ($type ?? 'student') === 'parent'
        ? ($t['parent_badge'] ?? 'Parent Copy')
        : ($t['student_badge'] ?? 'Student');
    $logo = $t['logo'] ?? null;
@endphp

<article class="id-card id-card--{{ $layout }}">
    <header class="id-card__header">
        <div class="id-card__brand">
            @if (! empty($t['show_logo']) && ! empty($logo))
                <img class="id-card__logo" src="{{ $logo }}" alt="Logo">
            @endif
            <div class="id-card__brand-text">
                <div class="id-card__org">{{ $t['organization'] }}</div>
                @if (! empty($t['tagline']))
                    <div class="id-card__tagline">{{ $t['tagline'] }}</div>
                @endif
            </div>
        </div>
        @if (! empty($t['show_badge']))
            <span class="id-card__badge">{{ $badge }}</span>
        @endif
    </header>

    <div class="id-card__body">
        @if (! empty($t['show_photo']))
            <img class="id-card__photo" src="{{ $photo }}" alt="{{ $displayName }}">
        @endif

        <div class="id-card__info">
            <h2 class="id-card__name">{{ $displayName ?: 'Unnamed Student' }}</h2>

            <div class="id-card__rows">
                @if (! empty($t['show_sid']))
                    <div class="id-card__row">
                        <span class="id-card__label">ID</span>
                        <span class="id-card__value">{{ $student->sid }}</span>
                    </div>
                @endif
                @if (! empty($t['show_class']))
                    <div class="id-card__row">
                        <span class="id-card__label">Class</span>
                        <span class="id-card__value">{{ $student->class ?: '—' }}</span>
                    </div>
                @endif
                @if (! empty($t['show_campus']))
                    <div class="id-card__row">
                        <span class="id-card__label">Campus</span>
                        <span class="id-card__value">{{ $student->campus ?: '—' }}</span>
                    </div>
                @endif
                @if (! empty($t['show_guardian']))
                    <div class="id-card__row">
                        <span class="id-card__label">Guardian</span>
                        <span class="id-card__value">{{ $student->father_name ?: '—' }}</span>
                    </div>
                @endif
                @if (! empty($t['show_phone']))
                    <div class="id-card__row">
                        <span class="id-card__label">Phone</span>
                        <span class="id-card__value">{{ $student->phone ?: '—' }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if (! empty($t['show_address']) || ! empty($t['show_footer_sid']))
        <footer class="id-card__footer">
            <span>
                @if (! empty($t['show_address']))
                    {{ $student->address ?: 'Address not provided' }}
                @endif
            </span>
            @if (! empty($t['show_footer_sid']))
                <strong>#{{ $student->sid }}</strong>
            @endif
        </footer>
    @endif
</article>
