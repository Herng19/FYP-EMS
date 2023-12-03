@if(session()->has('error-message'))
    <div x-data="{show:true}" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="flex bg-red-100 text-start py-2 font-semibold text-sm text-red-600 rounded-md items-center justify-start my-2 mx-8">
        <i class="fa-regular fa-circle-xmark fa-lg mx-4"></i>
        {{ session('error-message') }}
    </div>
@endif