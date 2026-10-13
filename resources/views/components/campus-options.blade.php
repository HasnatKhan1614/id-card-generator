@props(['selected' => null, 'placeholder' => 'Select Campus'])

@php
    $campuses = \App\Models\Campus::names();
@endphp

<option value="" disabled {{ $selected ? '' : 'selected' }}>{{ $placeholder }}</option>
@foreach ($campuses as $campus)
    <option value="{{ $campus }}" {{ $selected === $campus ? 'selected' : '' }}>{{ $campus }}</option>
@endforeach
