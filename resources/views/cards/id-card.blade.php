@php
    $org = config('idcard.organization');
    $tagline = config('idcard.tagline');
    $displayName = $student->student_name ?: trim(($student->first_name ?? '') . ' ' . ($student->last_name ?? ''));
    $photo = $student->image ?: 'https://placehold.co/156x156/e9ecef/6c757d?text=Photo';
    $badge = ($type ?? 'student') === 'parent' ? 'Parent Copy' : 'Student';
@endphp

<article class="id-card">
    <header class="id-card__header">
        <div>
            <div class="id-card__org">{{ $org }}</div>
            <div class="id-card__tagline">{{ $tagline }}</div>
        </div>
        <span class="id-card__badge">{{ $badge }}</span>
    </header>

    <div class="id-card__body">
        <img class="id-card__photo" src="{{ $photo }}" alt="{{ $displayName }}">

        <div class="id-card__info">
            <h2 class="id-card__name">{{ $displayName ?: 'Unnamed Student' }}</h2>

            <div class="id-card__rows">
                <div class="id-card__row">
                    <span class="id-card__label">ID</span>
                    <span class="id-card__value">{{ $student->sid }}</span>
                </div>
                <div class="id-card__row">
                    <span class="id-card__label">Class</span>
                    <span class="id-card__value">{{ $student->class ?: '—' }}</span>
                </div>
                <div class="id-card__row">
                    <span class="id-card__label">Campus</span>
                    <span class="id-card__value">{{ $student->campus ?: '—' }}</span>
                </div>
                <div class="id-card__row">
                    <span class="id-card__label">Guardian</span>
                    <span class="id-card__value">{{ $student->father_name ?: '—' }}</span>
                </div>
                <div class="id-card__row">
                    <span class="id-card__label">Phone</span>
                    <span class="id-card__value">{{ $student->phone ?: '—' }}</span>
                </div>
            </div>
        </div>
    </div>

    <footer class="id-card__footer">
        <span>{{ $student->address ?: 'Address not provided' }}</span>
        <strong>#{{ $student->sid }}</strong>
    </footer>
</article>
