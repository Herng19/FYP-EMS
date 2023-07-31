<div class="px-2 mx-8 py-4 my-4 justify-center flex-col">
    {{-- title --}}
    <div class="flex justify-center items-center">
        <i class="fa-solid fa-book text-primary-700 bg-milk"></i>
        <span class="text-primary-700 pl-2 font-bold font-serif break-normal whitespace-nowrap">FYP-EMS</span>
    </div>

    {{-- available nav items --}}
    <div class="h-5/6 mt-12">
        <x-navbar-item href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
            <x-slot name="icon">
                <i class="fa-regular fa-objects-column"></i>
            </x-slot>
            <x-slot name="title">
                {{ __('Dashboard') }}
            </x-slot>
        </x-navbar-item>
        <x-navbar-item href="{{ route('supervisee') }}" :active="request()->routeIs('supervisee')">
            <x-slot name="icon">
                <i class="fa-regular fa-users"></i>
            </x-slot>
            <x-slot name="title">
                {{__('Supervisee')}}
            </x-slot>
        </x-navbar-item>
        <x-navbar-item href="{{ route('evaluation') }}" :active="request()->routeIs('evaluation')">
            <x-slot name="icon">
                <i class="fa-regular fa-graduation-cap"></i>
            </x-slot>
            <x-slot name="title">
                {{__('Evaluation')}}
            </x-slot>
        </x-navbar-item>
        <x-navbar-item href="{{ route('evaluation schedule') }}" :active="request()->routeIs('evaluation schedule')">
            <x-slot name="icon">
                <i class="fa-regular fa-table"></i>
            </x-slot>
            <x-slot name="title">
                {{__('Evaluation Schedule')}}
            </x-slot>
        </x-navbar-item>
        <x-navbar-item href="{{ route('rubric') }}" :active="request()->routeIs('rubric')">
            <x-slot name="icon">
                <i class="fa-regular fa-chart-pie"></i>
            </x-slot>
            <x-slot name="title">
                {{__('Rubric')}}
            </x-slot>
        </x-navbar-item>
        <x-navbar-item href="{{ route('top students') }}" :active="request()->routeIs('top students')">
            <x-slot name="icon">
                <i class="fa-regular fa-crown"></i>
            </x-slot>
            <x-slot name="title">
                {{__('Top Students')}}
            </x-slot>
        </x-navbar-item>
        <div x-data="{dropdown: false}" class="relative cursor-pointer" @click="dropdown = ! dropdown">
            <div class="flex mt-4 items-center object-fill py-2 px-8 rounded-lg justify-center text-gray">
                <div name="icon" class="text-inherit">
                    <i class="fa-regular fa-briefcase"></i>
                </div>
                <div name="title" class="text-inherit pl-2 font-semibold text-sm break-normal whitespace-nowrap">                    
                    {{__('Industrial Evaluation')}}
                </div>
                <button class="ml-2 mr-1.5" x-show="!dropdown">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
                <button class="ml-2" x-show="dropdown">
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
            </div>
            <div x-show="dropdown">
                <x-navbar-item href="{{ route('industrial evaluator') }}" :active="request()->routeIs('industrial evaluator')" class="pl-12">
                    <x-slot name="icon">
                        <i class="fa-regular fa-user-tie"></i>
                    </x-slot>
                    <x-slot name="title">
                        {{__('Industrial Evaluator')}}
                    </x-slot>
                </x-navbar-item>
                <x-navbar-item href="{{ route('industrial schedule') }}" :active="request()->routeIs('industrial schedule')" class="pl-12">
                    <x-slot name="icon">
                        <i class="fa-regular fa-table-tree"></i>
                    </x-slot>
                    <x-slot name="title">
                        {{__('Evaluation Schedule')}}
                    </x-slot>
                </x-navbar-item>
                <x-navbar-item href="{{ route('industrial evaluation') }}" :active="request()->routeIs('industrial evaluation')" class="pl-12">
                    <x-slot name="icon">
                        <i class="fa-sharp fa-regular fa-graduation-cap"></i>
                    </x-slot>
                    <x-slot name="title">
                        {{__("Student's Evaluation")}}
                    </x-slot>
                </x-navbar-item>
            </div>
        </div>
        <x-navbar-item href="{{ route('report') }}" :active="request()->routeIs('report')">
            <x-slot name="icon">
                <i class="fa-regular fa-chart-mixed"></i>
            </x-slot>
            <x-slot name="title">
                {{__('Report & Progress')}}
            </x-slot>
        </x-navbar-item>
    </div>

    {{-- logout button --}}
    <form method="POST" action="{{ route('logout') }}" x-data>
        @csrf
        <a href="{{ route('logout') }}" @click.prevent="$root.submit();" class="flex my-4 items-center object-fill py-2 px-8 rounded-md justify-center bg-red-500 text-white hover:bg-red-600 hover:text-white active:ring-red-800 active:ring-2 active:ring-offset-2">
            <div name="icon" class="text-inherit">
                <i class="fa-regular fa-arrow-right-from-bracket"></i>
            </div>
            <div name="title" class="text-inherit pl-2 font-semibold text-sm break-normal whitespace-nowrap">                    
                {{ __('Log Out') }}
            </div>
        </a>
    </form>
</div>