@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-0 bg-primary-100 text-primary-700 font-semibold focus:border-indigo-500 focus:ring-indigo-500 focus:ring-2 focus:text-primary-700 rounded-md shadow-sm placeholder:font-semibold placeholder:text-sm placeholder:text-primary-300']) !!}>
