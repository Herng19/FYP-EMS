@if(session()->has('success-message'))
    <div x-data="{show:true}" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="flex bg-green-100 text-start py-2 font-semibold text-sm text-green-600 rounded-md items-center justify-start my-2 mx-8">
        <i class="fa-regular fa-circle-check fa-lg mx-4"></i>
        {{ session('success-message') }}
    </div>
@endif