@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1  text-sm font-medium leading-5 text-blue-300 focus:outline-none focus:border-blue-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1  text-sm font-medium leading-5 text-white hover:text-blue-300 hover:border-blue-300 focus:outline-none focus:text-blue-700 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
