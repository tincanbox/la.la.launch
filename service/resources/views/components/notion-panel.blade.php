@props(['level' => 'notice'])

@php
$classes = 'text-xs border-2 rounded-md p-2 mt-2 ';
switch ($level) {
    default:
        $classes .= 'text-gray-600 border-gray-300 ';
    break;
}
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
