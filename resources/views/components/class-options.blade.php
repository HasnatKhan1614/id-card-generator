@props(['selected' => null, 'placeholder' => 'Select Class'])

@php
    $classes = \App\Models\SchoolClass::names();
@endphp

<option value="" disabled {{ $selected ? '' : 'selected' }}>{{ $placeholder }}</option>
@foreach ($classes as $class)
    <option value="{{ $class }}" {{ $selected === $class ? 'selected' : '' }}>{{ $class }}</option>
@endforeach
