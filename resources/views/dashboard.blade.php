<x-app-layout>
    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>
    <div class="flex items-stretch mx-12 w-auto">
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
    </div>
    <div class="grid grid-cols-3 gap-12 mx-20 my-12">
        <div class="col-span-2">
            <div class="flex justify-between items-center w-auto">
                <p class="font-bold text-md">Supervisee List</p>
                <a href="{{ route('supervisee') }}" class="font-bold text-sm text-primary-700">View</a>
            </div>
            <x-show-table :headers="['Name', 'PSM', 'Project Title']">
                <tbody class="flex flex-col overflow-y-auto w-full" style="height: 40vh;">
                    @foreach ($supervisees as $i => $supervisee)
                        <tr class="flex px-8 py-2 {{ ($i%2 == 0)? 'bg-primary-50' : '';}}">
                            <td class="mx-4 py-2 text-gray text-sm font-semibold w-4">{{ $i+1 }}.</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $supervisee->name }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">PSM {{ $supervisee->psm_year }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $supervisee->project_title }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </x-show-table>
        </div>
        <div class="p-4">
            <div class="bg-gray-100 rounded-lg p-8 h-full text-left justify-center drop-shadow-[0px_1px_18px_rgba(120,120,120,0.15)]">
                <div class="h-5/6">
                    <p class="font-bold text-xl text-primary-700">Next Evaluation</p>
                    <p class="font-semibold text-md text-gray mt-4">First Evaluation (30%)</p>
                    <p class="font-semibold text-sm text-gray-500">Submit until chapter 3, requirement part. </p>
                    <p class="font-bold text-sm text-primary-900 mt-4">Due on 26/5/2023</p>
                </div>
                <a href="{{ route('evaluation') }}">
                    <x-button class="w-full font-bold text-md justify-center rounded-md px-8 py-2">
                        Evaluate
                    </x-button>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
