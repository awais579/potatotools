@php
    $id = $id ?? null;
    $label = $label ?? 'Loading...';
    $class = $class ?? '';
    $hidden = $hidden ?? true;
@endphp

<div
    @if ($id) id="{{ $id }}" @endif
    class="pt-loading {{ $class }}"
    role="status"
    aria-live="polite"
    aria-hidden="{{ $hidden ? 'true' : 'false' }}"
    @if ($hidden) hidden @endif>
    <span class="pt-loading-spinner" aria-hidden="true"></span>
    <span>{{ $label }}</span>
</div>
