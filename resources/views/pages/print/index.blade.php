@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-8">
                <h1>Print ID Cards</h1>
                <p class="text-muted mb-0">Pick a template, select students, then print student or parent cards.</p>
            </div>
            <div class="col-sm-4 text-right">
                <a href="{{ route('templates.index') }}" class="btn btn-outline-primary btn-sm">Manage templates</a>
                <a href="{{ route('registrations.index') }}" class="btn btn-outline-secondary btn-sm">Registrations</a>
            </div>
        </div>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="alert alert-danger d-none" id="print-error"></div>

        <div class="card card-outline card-primary">
            <div class="card-body">
                <form method="GET" action="{{ route('print.index') }}" class="row align-items-end">
                    <div class="col-md-3 form-group">
                        <label>Template</label>
                        <select name="template_id" class="form-control" id="filter-template">
                            @forelse ($templates as $template)
                                <option value="{{ $template->id }}" @selected((int) ($selectedTemplateId ?? 0) === $template->id)>
                                    {{ $template->name }}{{ $template->is_default ? ' (default)' : '' }}
                                </option>
                            @empty
                                <option value="">No templates — create one first</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="col-md-2 form-group">
                        <label>Campus</label>
                        <select name="campus" class="form-control">
                            <option value="">All campuses</option>
                            @foreach ($campuses as $campus)
                                <option value="{{ $campus }}" @selected(($filters['campus'] ?? '') === $campus)>{{ $campus }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 form-group">
                        <label>Class</label>
                        <select name="class" class="form-control">
                            <option value="">All classes</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class }}" @selected(($filters['class'] ?? '') === $class)>{{ $class }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Search</label>
                        <input type="text" name="q" class="form-control" value="{{ $filters['q'] ?? '' }}" placeholder="ID or name">
                    </div>
                    <div class="col-md-2 form-group">
                        <button class="btn btn-primary btn-block" type="submit">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <form id="bulk-print-form" method="POST" action="{{ route('print.cards') }}" target="_blank">
            @csrf
            <input type="hidden" name="type" id="print-type" value="student">
            <input type="hidden" name="template_id" id="print-template-id" value="{{ $selectedTemplateId }}">

            <div class="card">
                <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                    <div>
                        <h3 class="card-title mb-0">Ready to print ({{ $students->total() }})</h3>
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
                                @forelse ($students as $student)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="student-id" name="ids[]" value="{{ $student->id }}">
                                        </td>
                                        <td>
                                            @if ($student->image)
                                                <img src="{{ $student->image }}" alt="" style="width:42px;height:50px;object-fit:cover;border-radius:4px;">
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>{{ $student->sid }}</td>
                                        <td>{{ $student->student_name ?: ($student->first_name . ' ' . $student->last_name) }}</td>
                                        <td>{{ $student->class }}</td>
                                        <td>{{ $student->campus }}</td>
                                        <td>{{ $student->father_name ?: '—' }}</td>
                                        <td class="text-right text-nowrap">
                                            <a href="{{ route('print.single', [$student->id, 'student']) }}?template_id={{ $selectedTemplateId }}" target="_blank" class="btn btn-sm btn-outline-success quick-print" title="Student ID">
                                                <i class="fas fa-id-card"></i>
                                            </a>
                                            <a href="{{ route('print.single', [$student->id, 'parent']) }}?template_id={{ $selectedTemplateId }}" target="_blank" class="btn btn-sm btn-outline-info quick-print" title="Parent ID">
                                                <i class="fas fa-user-friends"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">
                                            No registered students match these filters.
                                            <a href="{{ route('registration') }}" target="_blank">Open registration form</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($students->hasPages())
                    <div class="card-footer">
                        {{ $students->links() }}
                    </div>
                @endif
            </div>
        </form>
    </div>
</section>
@endsection

@section('script')
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
@endsection
