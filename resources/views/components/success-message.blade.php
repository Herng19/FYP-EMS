@if(session()->has('success-message'))
    <div x-data="{show:true}" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="fixed top-0 left-1/2 -translate-x-1/2 bg-primary-700 text-center pt-4 pb-6 px-28 font-semibold text-md text-white">
        {{ session('success-message') }}
    </div>
@endif