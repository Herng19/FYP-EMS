@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex mt-3 items-center object-fill py-2 pl-4 pr-4 rounded-sm justify-start bg-gradient-to-r from-primary-400 to-blue-400 text-slate-800 hover:bg-opacity-80 transition duration-150 ease-in-out pr-12 shadow-[2px_2px_16px_rgba(0,180,180,0.3)]'
            : 'flex mt-3 items-center object-fill py-2 pl-4 pr-4 rounded-sm justify-start text-[#a4a4a4] hover:bg-gray-50 hover:bg-opacity-10 focus:outline-none focus:bg-opacity-20 focus:text-gray-300 focus:border-gray-300 transition duration-150 ease-in-out pr-12';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <div class="flex items-center justify-center w-6 h-6 text-inherit">
        <i class="text-inherit">{{ $icon }}</i> 
    </div>
    <span class="text-inherit pl-2 font-semibold text-sm break-normal whitespace-nowrap tracking-wider grow">{{ $title }}</span>
</a>