@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex mt-2 items-center object-fill py-2 px-8 rounded-md justify-start bg-primary-700 text-gray-100 hover:bg-primary-900 hover:text-white transition duration-150 ease-in-out pr-12'
            : 'flex mt-2 items-center object-fill py-2 px-8 rounded-md justify-start hover:text-gray-700 hover:bg-primary-100 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out pr-12';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <i class="text-inherit">{{ $icon }}</i> 
    <span class="text-inherit pl-2 font-semibold text-sm break-normal whitespace-nowrap">{{ $title }}</span>
</a>