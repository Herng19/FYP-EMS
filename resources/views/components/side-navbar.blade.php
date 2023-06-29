<div class="px-2 mx-8 py-4 my-4 justify-center">
    <div class="flex justify-center items-center">
        <i class="fa-solid fa-book text-primary-700 bg-milk"></i>
        <span class="text-primary-700 pl-2 font-bold font-serif break-normal whitespace-nowrap">FYP-EMS</span>
    </div>
    <div class="h-auto mt-12">
        <x-navbar-item href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
            <x-slot name="icon">
                <i class="fa-regular fa-objects-column"></i>
            </x-slot>
            <x-slot name="title">
                {{ __('Dashboard') }}
            </x-slot>
        </x-navbar-item>
        <x-navbar-item>
            <x-slot name="icon">
                <i class="fa-regular fa-objects-column"></i>
            </x-slot>
            <x-slot name="title">
                {{__('Industrial Evaluation')}}
            </x-slot>
        </x-navbar-item>
    </div>
</div>