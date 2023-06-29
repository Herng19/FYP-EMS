@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex mt-4 items-center object-fill py-2 px-8 rounded-lg justify-start bg-primary-700 text-gray-100 hover:bg-primary-200 hover:text-primary-700 transition duration-150 ease-in-out'
            : 'flex mt-4 items-center object-fill py-2 px-8 rounded-lg justify-start hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <i class="text-inherit">{{ $icon }}</i> 
    <span class="text-inherit pl-2 font-semibold text-sm break-normal whitespace-nowrap">{{ $title }}</span>
</a>