<x-app-layout>
    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>
    <div class="flex items-stretch mx-12 w-auto">
        @hasanyrole('coordinator|head of research group')
        <x-dashboard-item>
            <x-slot name="icon">
                <div class="flex items-center rounded-md bg-[#efe9f7] px-8">
                    <i class="fas fa-users fa-xl text-[#6f518c]"></i>
                </div>
            </x-slot>
            <x-slot name="title">
                PSM 1 Students
            </x-slot>
            <x-slot name="data">{{ $psm1_students }}</x-slot>
        </x-dashboard-item>
        <x-dashboard-item>
            <x-slot name="icon">
                <div class="flex items-center rounded-md bg-[#f5ece6] px-8">
                    <i class="fas fa-users fa-xl text-[#ab541f]"></i>
                </div>
            </x-slot>
            <x-slot name="title">
                PSM 2 Students
            </x-slot>
            <x-slot name="data">{{ $psm2_students }}</x-slot>
        </x-dashboard-item>
        <x-dashboard-item>
            <x-slot name="icon">
                <div class="flex items-center rounded-md bg-[#faebef] px-8">
                    <i class="fas fa-users fa-xl text-[#a63353]"></i>
                </div>
            </x-slot>
            <x-slot name="title">
                Lecturers
            </x-slot>
            <x-slot name="data">{{ $lecturers }}</x-slot>
        </x-dashboard-item>
        @else
        <x-dashboard-item>
            <x-slot name="icon">
                <div class="flex items-center rounded-md bg-[#efe9f7] px-8">
                    <i class="fas fa-users fa-xl text-[#6f518c]"></i>
                </div>
            </x-slot>
            <x-slot name="title">
                PSM 1 Supervisee
            </x-slot>
            <x-slot name="data">{{ $psm1_students }}</x-slot>
        </x-dashboard-item>
        <x-dashboard-item>
            <x-slot name="icon">
                <div class="flex items-center rounded-md bg-[#f5ece6] px-8">
                    <i class="fas fa-users fa-xl text-[#ab541f]"></i>
                </div>
            </x-slot>
            <x-slot name="title">
                PSM 2 Supervisee
            </x-slot>
            <x-slot name="data">{{ $psm2_students }}</x-slot>
        </x-dashboard-item>
        <x-dashboard-item>
            <x-slot name="icon">
                <div class="flex items-center rounded-md bg-[#faebef] px-8">
                    <i class="fas fa-users fa-xl text-[#a63353]"></i>
                </div>
            </x-slot>
            <x-slot name="title">
                Evaluatees
            </x-slot>
            <x-slot name="data">{{ $evaluatees }}</x-slot>
        </x-dashboard-item>
        @endhasanyrole
    </div>
    <div class="grid grid-cols-3 gap-12 mx-20 my-12">
        <div class="col-span-2">
            <div class="flex justify-between items-center w-auto">
                <p class="font-bold text-md">{{ (auth()->user()->hasRole('coordinator') || auth()->user()->hasRole('head of research group'))? 'Student List' : 'Supervisee List'}}</p>
                <a href="{{ route('supervisee') }}" class="font-bold text-sm text-primary-700">View</a>
            </div>
            <x-show-table :headers="['Name', 'PSM', 'Project Title']">
                <tbody class="flex flex-col overflow-y-auto w-full" style="height: 40vh;">
                    @php $i = 0; @endphp
                    @foreach ($supervisees as $supervisee)
                        <tr class="flex px-8 py-2 {{ ($i%2 == 0)? 'bg-primary-50' : '';}}">
                            <td class="mx-4 py-2 text-gray text-sm font-semibold w-4">{{ $i+1 }}.</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $supervisee->name }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">PSM {{ $supervisee->psm_year }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $supervisee->project->project_title }}</td>
                        </tr>
                        @php $i++; @endphp
                    @endforeach
                </tbody>
            </x-show-table>
        </div>
        <div class="pt-4 pl-4">
            <div class="bg-white rounded-lg p-8 h-full text-left justify-center drop-shadow-[0px_1px_18px_rgba(120,120,120,0.15)]">
                @hasanyrole('coordinator|head of research group')
                    <div class="h-5/6">
                        <p class="font-bold text-xl text-primary-700">Evaluation Report for students</p>
                        <p class="font-semibold text-sm text-justify text-gray-500 mt-2">Marks of evaluated students will be shown in Report & Progress tab.</p>
                    </div>
                    <a href="{{ route('report') }}">
                        <x-button class="w-full font-bold text-md justify-center rounded-md px-8 py-2">
                            View Report
                        </x-button>
                    </a>
                @else
                    <div class="h-5/6">
                        <p class="font-bold text-xl text-primary-700">Evaluation for students</p>
                        <p class="font-semibold text-sm text-justify text-gray-500 mt-2">Students that are ready to be evaluated will be show in the "Evaluation" tab, including your supervisee and students for evaluation 2</p>
                        <p class="font-bold text-sm text-primary-900 mt-4">Due On: Check KALAM</p>
                    </div>
                    <a href="{{ route('evaluation') }}">
                        <x-button class="w-full font-bold text-md justify-center rounded-md px-8 py-2">
                            Evaluate NOW
                        </x-button>
                    </a>
                @endhasanyrole
            </div>
        </div>
    </div>
</x-app-layout>
