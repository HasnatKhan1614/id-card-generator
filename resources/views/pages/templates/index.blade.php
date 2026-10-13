@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>ID Card Templates</h1>
                <p class="text-muted mb-0">Create multiple designs and choose one when printing.</p>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('templates.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> New Template
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">
            @forelse ($templates as $template)
                @php $s = $template->mergedSettings(); @endphp
                <div class="col-md-6 col-lg-4">
                    <div class="card card-outline {{ $template->is_default ? 'card-primary' : 'card-secondary' }}">
                        <div class="card-header">
                            <h3 class="card-title mb-0">
                                {{ $template->name }}
                                @if ($template->is_default)
                                    <span class="badge badge-primary">Default</span>
                                @endif
                                @unless ($template->is_active)
                                    <span class="badge badge-secondary">Inactive</span>
                                @endunless
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-2" style="height:10px;border-radius:4px;background:{{ $s['header_bg'] }};"></div>
                            <p class="mb-1"><strong>Layout:</strong> {{ ucfirst($s['layout']) }}</p>
                            <p class="mb-1"><strong>Org:</strong> {{ $s['organization'] }}</p>
                            <p class="mb-0 text-muted small">
                                Fields:
                                @if ($s['show_sid']) ID @endif
                                @if ($s['show_class']) · Class @endif
                                @if ($s['show_campus']) · Campus @endif
                                @if ($s['show_guardian']) · Guardian @endif
                                @if ($s['show_phone']) · Phone @endif
                                @if ($s['show_address']) · Address @endif
                            </p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('templates.preview', $template) }}" target="_blank" class="btn btn-sm btn-outline-info">Preview</a>
                            <a href="{{ route('templates.edit', $template) }}" class="btn btn-sm btn-primary">Edit</a>
                            @unless ($template->is_default)
                                <form action="{{ route('templates.default', $template) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-secondary" type="submit">Set default</button>
                                </form>
                                <form action="{{ route('templates.destroy', $template) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this template?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                </form>
                            @endunless
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">No templates yet. Create your first design.</div>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
