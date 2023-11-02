@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex mt-3 items-center object-fill py-2 pl-4 pr-8 rounded-md justify-start bg-primary-900 text-primary-100 hover:bg-opacity-75 hover:text-white transition duration-150 ease-in-out pr-12 shadow-[inset_2px_2px_12px_rgba(20,20,20,0.4)]'
            : 'flex mt-3 items-center object-fill py-2 pl-4 pr-8 rounded-md justify-start text-primary-200 hover:bg-primary-500 hover:bg-opacity-30 focus:outline-none focus:text-primary-100 focus:border-gray-300 transition duration-150 ease-in-out pr-12';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <div class="flex items-center justify-center w-6 h-6 text-inherit">
        <i class="text-primary-300">{{ $icon }}</i> 
    </div>
    <span class="text-inherit pl-2 font-semibold text-sm break-normal whitespace-nowrap tracking-wider">{{ $title }}</span>
</a>