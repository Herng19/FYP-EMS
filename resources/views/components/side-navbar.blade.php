<div class="pl-6 pr-6 py-8 justify-center flex-col flex bg-primary-800 drop-shadow-[2px_0px_24px_rgba(120,120,255,0.6)] rounded-br-md rounded-tr-md">
    {{-- title --}}
    <div class="flex justify-center items-center">
        <a href="/dashboard">
            <i class="fa-solid fa-book text-primary-200"></i>
            <span class="text-primary-200 pl-2 font-bold font-serif break-normal whitespace-nowrap">FYP-EMS</span>
        </a>
    </div>

    {{-- available nav items --}}
    <div class="mt-12 grow">
        {{-- Dashboard --}}
        <x-navbar-item href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
            <x-slot name="icon">
                <i class="fa-light fa-objects-column"></i>
            </x-slot>
            <x-slot name="title">
                {{ __('Dashboard') }}
            </x-slot>
        </x-navbar-item>

        {{-- Supervisee List --}}
        @role('supervisor')
        <x-navbar-item href="{{ route('supervisee') }}" :active="request()->routeIs('supervisee')">
            <x-slot name="icon">
                <i class="fa-light fa-users"></i>
            </x-slot>
            <x-slot name="title">
                {{__('Supervisee')}}
            </x-slot>
        </x-navbar-item>
        @endrole

        @hasanyrole('supervisor|evaluator')
        {{-- Evaluation --}}
        <x-navbar-item href="{{ route('evaluation') }}" :active="request()->routeIs('evaluation.*') || request()->routeIs('evaluation')">
            <x-slot name="icon">
                <i class="fa-light fa-graduation-cap"></i>
            </x-slot>
            <x-slot name="title">
                {{__('Evaluation')}}
            </x-slot>
        </x-navbar-item>
        @endhasanyrole

        {{-- Evaluation Schedule --}}
        <x-navbar-item href="{{ (auth('web')->check()) ? route('evaluation schedule') :  route('evaluation schedule.student_schedule')}}" :active="request()->routeIs('evaluation schedule.*') || request()->routeIs('evaluation schedule')">
            <x-slot name="icon">
                <i class="fa-light fa-table"></i>
            </x-slot>
            <x-slot name="title">
                {{__('Evaluation Schedule')}}
            </x-slot>
        </x-navbar-item>

        {{-- Rubric --}}
        <x-navbar-item href="{{ (auth('web')->check()) ? route('rubric') :  route('rubric.student_rubric_list')}}" :active="request()->routeIs('rubric.*') || request()->routeIs('rubric')">
            <x-slot name="icon">
                <i class="fa-light fa-chart-pie"></i>
            </x-slot>
            <x-slot name="title">
                {{__('Rubric')}}
            </x-slot>
        </x-navbar-item>

        {{-- Top Students --}}
        <x-navbar-item href="{{ route('top students') }}" :active="request()->routeIs('top students.*') || request()->routeIs('top students')">
            <x-slot name="icon">
                <i class="fa-light fa-crown"></i>
            </x-slot>
            <x-slot name="title">
                {{__('Top Students')}}
            </x-slot>
        </x-navbar-item>

        @role('coordinator')
        {{-- Industrial Evaluation --}}
        <div x-data="{dropdown: false}" class="relative cursor-pointer" @click="dropdown = ! dropdown">
            <div class="flex mt-4 items-center object-fill py-2 pl-9 pr-11 rounded-lg justify-center text-primary-200">
                <div name="icon" class="text-inherit text-primary-300">
                    <i class="fa-light fa-briefcase"></i>
                </div>
                <div name="title" class="text-inherit pl-3 font-semibold text-sm break-normal whitespace-nowrap tracking-wider">                    
                    {{__('Industrial Evaluation')}}
                </div>
                <button class="ml-2 mr-1.5" x-show="!dropdown">
                    <i class="fa-light fa-chevron-right fa-sm"></i>
                </button>
                <button class="ml-2" x-show="dropdown">
                    <i class="fa-light fa-chevron-down fa-sm"></i>
                </button>
            </div>
            <div x-show="dropdown">
                {{-- Industrial Evaluator --}}
                <x-navbar-item href="{{ route('industrial evaluator') }}" :active="request()->routeIs('industrial evaluator.*') || request()->routeIs('industrial evaluator')" class="pl-12">
                    <x-slot name="icon">
                        <i class="fa-light fa-user-tie"></i>
                    </x-slot>
                    <x-slot name="title">
                        {{__('Industrial Evaluator')}}
                    </x-slot>
                </x-navbar-item>

                {{-- Industrial Schedule --}}
                <x-navbar-item href="{{ route('industrial schedule') }}" :active="request()->routeIs('industrial schedule.*') || request()->routeIs('industrial schedule')" class="pl-12">
                    <x-slot name="icon">
                        <i class="fa-light fa-table-tree"></i>
                    </x-slot>
                    <x-slot name="title">
                        {{__('Evaluation Schedule')}}
                    </x-slot>
                </x-navbar-item>

                {{-- Industrial Evaluation --}}
                <x-navbar-item href="{{ route('industrial evaluation') }}" :active="request()->routeIs('industrial evaluation.*') || request()->routeIs('industrial evaluation')" class="pl-12">
                    <x-slot name="icon">
                        <i class="fa-sharp fa-light fa-graduation-cap"></i>
                    </x-slot>
                    <x-slot name="title">
                        {{__("Student's Evaluation")}}
                    </x-slot>
                </x-navbar-item>

                {{-- Industrial Rubric --}}
                <x-navbar-item href="{{ route('industrial rubric') }}" :active="request()->routeIs('industrial rubric.*') || request()->routeIs('industrial rubric')" class="pl-12">
                    <x-slot name="icon">
                        <i class="fa-sharp fa-light fa-pie-chart"></i>
                    </x-slot>
                    <x-slot name="title">
                        {{__("Industrial Rubric")}}
                    </x-slot>
                </x-navbar-item>
            </div>
        </div>
        @endrole

        {{-- Report --}}
        <x-navbar-item href="{{ route('report') }}" :active="request()->routeIs('report.*') || request()->routeIs('report')">
            <x-slot name="icon">
                <i class="fa-light fa-chart-mixed"></i>
            </x-slot>
            <x-slot name="title">
                {{__('Report & Progress')}}
            </x-slot>
        </x-navbar-item>
    </div>

    {{-- logout button --}}
    <div>
        <form method="POST" action="{{ route('logout') }}" x-data>
            @csrf
            <a href="{{ route('logout') }}" @click.prevent="$root.submit();" class="flex items-center object-fill mt-8 py-2 px-8 rounded-md justify-center bg-red-500 text-gray-100 hover:bg-red-600 hover:text-white active:ring-red-700 active:ring-2 active:ring-offset-2">
                <div name="icon" class="text-inherit">
                    <i class="fa-light fa-arrow-right-from-bracket"></i>
                </div>
                <div name="title" class="text-inherit pl-2 font-semibold text-sm break-normal whitespace-nowrap">                    
                    {{ __('Log Out') }}
                </div>
            </a>
        </form>
    </div>
</div>