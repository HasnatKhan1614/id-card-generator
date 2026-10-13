@extends('layouts.app')

@php
    $previewTemplate = new \App\Models\IdCardTemplate(['settings' => $settings]);
    $currentLogo = old('logo_url', $settings['logo'] ?? null);
@endphp

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-8">
                <h1>{{ $mode === 'create' ? 'Create' : 'Edit' }} ID Card Template</h1>
                <p class="text-muted mb-0">Changes update the live preview on the right.</p>
            </div>
            <div class="col-sm-4 text-right">
                <a href="{{ route('templates.index') }}" class="btn btn-default btn-sm">Back</a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 pl-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" enctype="multipart/form-data" id="template-form"
              action="{{ $mode === 'create' ? route('templates.store') : route('templates.update', $template->id) }}">
            @csrf
            @if ($mode === 'edit')
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-lg-7">
                    <div class="card card-primary">
                        <div class="card-header"><h3 class="card-title">Basics</h3></div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Template name</label>
                                <input type="text" name="name" class="form-control preview-input"
                                       value="{{ old('name', $template->name) }}" required>
                            </div>
                            <div class="form-group">
                                <label>Organization on card</label>
                                <input type="text" name="organization" class="form-control preview-input" data-preview="org"
                                       value="{{ old('organization', $settings['organization']) }}" required>
                            </div>
                            <div class="form-group">
                                <label>Tagline</label>
                                <input type="text" name="tagline" class="form-control preview-input" data-preview="tagline"
                                       value="{{ old('tagline', $settings['tagline']) }}">
                            </div>
                            <div class="form-group">
                                <label>Layout</label>
                                <select name="layout" class="form-control preview-input" data-preview="layout" required>
                                    @foreach (['classic' => 'Classic (photo left)', 'stacked' => 'Stacked (photo top)', 'banner' => 'Banner (wide header)'] as $value => $label)
                                        <option value="{{ $value }}" @selected(old('layout', $settings['layout']) === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1"
                                               @checked(old('is_active', $template->is_active ?? true))>
                                        <label class="custom-control-label" for="is_active">Active</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="is_default" name="is_default" value="1"
                                               @checked(old('is_default', $template->is_default ?? false))>
                                        <label class="custom-control-label" for="is_default">Set as default</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-outline card-secondary">
                        <div class="card-header"><h3 class="card-title">Header logo</h3></div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Upload logo</label>
                                <input type="file" name="logo" id="logo-input" class="form-control-file" accept="image/*">
                                <small class="form-text text-muted">PNG, JPG, GIF or WebP. Max 2MB.</small>
                            </div>
                            @if ($currentLogo)
                                <div class="mb-3" id="current-logo-block">
                                    <img src="{{ $currentLogo }}" alt="Current logo" style="max-height:56px;background:#f4f6f9;padding:6px;border-radius:4px;">
                                    <div class="custom-control custom-checkbox mt-2">
                                        <input type="checkbox" class="custom-control-input preview-input" id="remove_logo" name="remove_logo" value="1" data-preview="remove_logo">
                                        <label class="custom-control-label" for="remove_logo">Remove current logo</label>
                                    </div>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input preview-input" id="show_logo" name="show_logo" value="1"
                                               data-preview-toggle="logo"
                                               @checked(old('show_logo', $settings['show_logo'] ?? true))>
                                        <label class="custom-control-label" for="show_logo">Show logo on card</label>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Logo size</label>
                                    <select name="logo_size" class="form-control preview-input" data-preview="logo_size">
                                        @foreach (['small', 'medium', 'large'] as $size)
                                            <option value="{{ $size }}" @selected(old('logo_size', $settings['logo_size'] ?? 'medium') === $size)>{{ ucfirst($size) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-outline card-secondary">
                        <div class="card-header"><h3 class="card-title">Colors</h3></div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ([
                                    'header_bg' => ['Header background', '--header-bg'],
                                    'header_text' => ['Header text', '--header-text'],
                                    'body_bg' => ['Body background', '--body-bg'],
                                    'footer_bg' => ['Footer background', '--footer-bg'],
                                    'footer_text' => ['Footer text', '--footer-text'],
                                    'name_color' => ['Name color', '--name-color'],
                                    'label_color' => ['Label color', '--label-color'],
                                    'value_color' => ['Value color', '--value-color'],
                                    'accent_color' => ['Accent / SID', '--accent'],
                                    'border_color' => ['Border', '--border'],
                                ] as $key => [$label, $cssVar])
                                    <div class="col-md-6 form-group">
                                        <label>{{ $label }}</label>
                                        <input type="color" name="{{ $key }}" class="form-control preview-input" data-css-var="{{ $cssVar }}"
                                               value="{{ old($key, $settings[$key]) }}" style="height:42px;padding:4px;">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="card card-outline card-secondary">
                        <div class="card-header"><h3 class="card-title">Fields & badges</h3></div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ([
                                    'show_badge' => 'Show badge',
                                    'show_photo' => 'Show photo',
                                    'show_sid' => 'Show ID',
                                    'show_class' => 'Show class',
                                    'show_campus' => 'Show campus',
                                    'show_guardian' => 'Show guardian',
                                    'show_phone' => 'Show phone',
                                    'show_address' => 'Show address',
                                    'show_footer_sid' => 'Show SID in footer',
                                ] as $key => $label)
                                    <div class="col-md-6 form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input preview-input" id="{{ $key }}" name="{{ $key }}" value="1"
                                                   data-preview-toggle="{{ str_replace('show_', '', $key) }}"
                                                   @checked(old($key, $settings[$key] ?? false))>
                                            <label class="custom-control-label" for="{{ $key }}">{{ $label }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label>Photo size</label>
                                    <select name="photo_size" class="form-control preview-input" data-preview="photo_size">
                                        @foreach (['small', 'medium', 'large'] as $size)
                                            <option value="{{ $size }}" @selected(old('photo_size', $settings['photo_size']) === $size)>{{ ucfirst($size) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Student badge text</label>
                                    <input type="text" name="student_badge" class="form-control preview-input" data-preview="badge"
                                           value="{{ old('student_badge', $settings['student_badge']) }}">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Parent badge text</label>
                                    <input type="text" name="parent_badge" class="form-control"
                                           value="{{ old('parent_badge', $settings['parent_badge']) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card card-outline card-info sticky-top" style="top:1rem;">
                        <div class="card-header">
                            <h3 class="card-title">Live preview</h3>
                            <div class="card-tools">
                                <span class="badge badge-info">CR80 · 3.370 × 2.125 in</span>
                            </div>
                        </div>
                        <div class="card-body">
                            @include('cards.styles', ['template' => $previewTemplate, 'scoped' => true])

                            <div class="live-preview-stage" style="overflow-x:auto;padding-bottom:8px;">
                                <article class="id-card id-card--{{ $settings['layout'] }}" id="live-card">
                                    <header class="id-card__header">
                                        <div class="id-card__brand">
                                            <img class="id-card__logo {{ empty($settings['show_logo']) || empty($currentLogo) ? 'id-card__hidden' : '' }}"
                                                 id="preview-logo"
                                                 src="{{ $currentLogo ?: '' }}"
                                                 alt="Logo">
                                            <div class="id-card__brand-text">
                                                <div class="id-card__org" id="preview-org">{{ $settings['organization'] }}</div>
                                                <div class="id-card__tagline {{ empty($settings['tagline']) ? 'id-card__hidden' : '' }}" id="preview-tagline">{{ $settings['tagline'] }}</div>
                                            </div>
                                        </div>
                                        <span class="id-card__badge {{ empty($settings['show_badge']) ? 'id-card__hidden' : '' }}" id="preview-badge">
                                            {{ $settings['student_badge'] }}
                                        </span>
                                    </header>

                                    <div class="id-card__body">
                                        <img class="id-card__photo {{ empty($settings['show_photo']) ? 'id-card__hidden' : '' }}" id="preview-photo"
                                             src="https://placehold.co/156x156/e9ecef/6c757d?text=Photo" alt="Sample">
                                        <div class="id-card__info">
                                            <h2 class="id-card__name">Alex Morgan</h2>
                                            <div class="id-card__rows">
                                                <div class="id-card__row {{ empty($settings['show_sid']) ? 'id-card__hidden' : '' }}" data-row="sid">
                                                    <span class="id-card__label">ID</span>
                                                    <span class="id-card__value">SID-DEMO</span>
                                                </div>
                                                <div class="id-card__row {{ empty($settings['show_class']) ? 'id-card__hidden' : '' }}" data-row="class">
                                                    <span class="id-card__label">Class</span>
                                                    <span class="id-card__value">Grade 5</span>
                                                </div>
                                                <div class="id-card__row {{ empty($settings['show_campus']) ? 'id-card__hidden' : '' }}" data-row="campus">
                                                    <span class="id-card__label">Campus</span>
                                                    <span class="id-card__value">Main Campus</span>
                                                </div>
                                                <div class="id-card__row {{ empty($settings['show_guardian']) ? 'id-card__hidden' : '' }}" data-row="guardian">
                                                    <span class="id-card__label">Guardian</span>
                                                    <span class="id-card__value">Jordan Morgan</span>
                                                </div>
                                                <div class="id-card__row {{ empty($settings['show_phone']) ? 'id-card__hidden' : '' }}" data-row="phone">
                                                    <span class="id-card__label">Phone</span>
                                                    <span class="id-card__value">03001234567</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <footer class="id-card__footer {{ (empty($settings['show_address']) && empty($settings['show_footer_sid'])) ? 'id-card__hidden' : '' }}" id="preview-footer">
                                        <span class="{{ empty($settings['show_address']) ? 'id-card__hidden' : '' }}" id="preview-address">12 Demo Street</span>
                                        <strong class="{{ empty($settings['show_footer_sid']) ? 'id-card__hidden' : '' }}" id="preview-footer-sid">#SID-DEMO</strong>
                                    </footer>
                                </article>
                            </div>

                            <p class="text-muted small mt-3 mb-0">
                                Sample student data is shown for design only. Real student data is used when printing.
                            </p>

                            @if ($mode === 'edit')
                                <a href="{{ route('templates.preview', $template->id) }}" target="_blank" class="btn btn-info btn-block mt-3">
                                    <i class="fas fa-print"></i> Open print preview
                                </a>
                            @endif
                            <button type="submit" class="btn btn-primary btn-block mt-2">
                                {{ $mode === 'create' ? 'Create template' : 'Save changes' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@section('script')
<script>
(function () {
    const card = document.getElementById('live-card');
    if (!card) return;

    const photoSizes = { small: '0.62in', medium: '0.78in', large: '0.92in' };
    const logoSizes = { small: '0.28in', medium: '0.36in', large: '0.44in' };
    let logoObjectUrl = null;
    let savedLogo = @json($currentLogo);

    function setHidden(el, hidden) {
        if (!el) return;
        el.classList.toggle('id-card__hidden', !!hidden);
    }

    function refreshFooterVisibility() {
        const address = document.getElementById('preview-address');
        const sid = document.getElementById('preview-footer-sid');
        const footer = document.getElementById('preview-footer');
        const showAddress = document.getElementById('show_address')?.checked;
        const showSid = document.getElementById('show_footer_sid')?.checked;
        setHidden(address, !showAddress);
        setHidden(sid, !showSid);
        setHidden(footer, !showAddress && !showSid);
    }

    function updateLogoVisibility() {
        const showLogo = document.getElementById('show_logo')?.checked;
        const removeLogo = document.getElementById('remove_logo')?.checked;
        const logoEl = document.getElementById('preview-logo');
        const hasSrc = logoEl && logoEl.getAttribute('src');
        setHidden(logoEl, !showLogo || removeLogo || !hasSrc);
    }

    function updatePreview() {
        const org = document.querySelector('[name="organization"]')?.value || 'Organization';
        const tagline = document.querySelector('[name="tagline"]')?.value || '';
        const layout = document.querySelector('[name="layout"]')?.value || 'classic';
        const badge = document.querySelector('[name="student_badge"]')?.value || 'Student';
        const photoSize = document.querySelector('[name="photo_size"]')?.value || 'medium';
        const logoSize = document.querySelector('[name="logo_size"]')?.value || 'medium';

        document.getElementById('preview-org').textContent = org;
        const taglineEl = document.getElementById('preview-tagline');
        taglineEl.textContent = tagline;
        setHidden(taglineEl, !tagline);

        card.classList.remove('id-card--classic', 'id-card--stacked', 'id-card--banner');
        card.classList.add('id-card--' + layout);

        document.getElementById('preview-badge').textContent = badge;
        card.style.setProperty('--photo-size', photoSizes[photoSize] || photoSizes.medium);
        card.style.setProperty('--logo-size', logoSizes[logoSize] || logoSizes.medium);

        document.querySelectorAll('[data-css-var]').forEach(function (input) {
            card.style.setProperty(input.getAttribute('data-css-var'), input.value);
        });

        const toggles = {
            badge: document.getElementById('show_badge')?.checked,
            photo: document.getElementById('show_photo')?.checked,
            sid: document.getElementById('show_sid')?.checked,
            class: document.getElementById('show_class')?.checked,
            campus: document.getElementById('show_campus')?.checked,
            guardian: document.getElementById('show_guardian')?.checked,
            phone: document.getElementById('show_phone')?.checked,
        };

        setHidden(document.getElementById('preview-badge'), !toggles.badge);
        setHidden(document.getElementById('preview-photo'), !toggles.photo);
        Object.keys(toggles).forEach(function (key) {
            if (key === 'badge' || key === 'photo') return;
            const row = card.querySelector('[data-row="' + key + '"]');
            setHidden(row, !toggles[key]);
        });

        refreshFooterVisibility();
        updateLogoVisibility();
    }

    document.getElementById('template-form').addEventListener('input', updatePreview);
    document.getElementById('template-form').addEventListener('change', updatePreview);

    document.getElementById('logo-input')?.addEventListener('change', function (e) {
        const file = e.target.files && e.target.files[0];
        const logoEl = document.getElementById('preview-logo');
        if (!file || !logoEl) return;

        if (logoObjectUrl) URL.revokeObjectURL(logoObjectUrl);
        logoObjectUrl = URL.createObjectURL(file);
        logoEl.src = logoObjectUrl;
        logoEl.removeAttribute('data-empty');

        const remove = document.getElementById('remove_logo');
        if (remove) remove.checked = false;

        updateLogoVisibility();
    });

    document.getElementById('remove_logo')?.addEventListener('change', function () {
        const logoEl = document.getElementById('preview-logo');
        if (this.checked) {
            if (logoObjectUrl) {
                URL.revokeObjectURL(logoObjectUrl);
                logoObjectUrl = null;
            }
            logoEl.src = '';
            document.getElementById('logo-input').value = '';
        } else if (savedLogo) {
            logoEl.src = savedLogo;
        }
        updateLogoVisibility();
    });

    updatePreview();
})();
</script>
@endsection
