<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="flex items-stretch mx-12 w-auto">
        <x-dashboard-item title="PSM 1 Supervisee" data="2"/>
        <x-dashboard-item title="PSM 2 Supervisee" data="2"/>
        <x-dashboard-item title="Evaluatees" data="2"/>
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
                        <tr class="flex mx-8 mt-2">
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
            <div class="bg-primary-700 rounded-lg text-white p-8 h-full text-left justify-center drop-shadow-[0px_1px_18px_rgba(113,144,255,0.85)]">
                <div class="h-5/6">
                    <p class="font-bold text-xl text-white">Next Evaluation</p>
                    <p class="font-semibold text-md text-white mt-4">First Evaluation (30%)</p>
                    <p class="font-thin text-sm text-white">Submit until chapter 3, requirement part. </p>
                    <p class="font-bold text-sm text-white mt-4">Due on 26/5/2023</p>
                </div>
                <a href="{{ route('evaluation') }}">
                    <button class="w-full bg-white text-primary-700 font-bold text-md justify-center rounded-md px-8 py-2">
                        Evaluate
                    </button>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
