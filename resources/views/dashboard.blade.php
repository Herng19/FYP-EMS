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
                <tr class="flex self-stretch">
                    <th class="px-4 py-2 text-primary-700 text-sm font-bold">No.</th>
                    {{-- @foreach ($headers as $header)
                        <th class="px-4 py-2 mx-2 text-primary-700 text-sm font-bold text-left grow">{{ $header }}</th>
                    @endforeach --}}
                </tr>
                <tr class="flex self-stretch">
                    <th class="px-4 py-2 text-primary-700 text-sm font-bold">No.</th>
                    {{-- @foreach ($headers as $header)
                        <th class="px-4 py-2 mx-2 text-primary-700 text-sm font-bold text-left grow">{{ $header }}</th>
                    @endforeach --}}
                </tr>
                <tr class="flex self-stretch">
                    <th class="px-4 py-2 text-primary-700 text-sm font-bold">No.</th>
                    {{-- @foreach ($headers as $header)
                        <th class="px-4 py-2 mx-2 text-primary-700 text-sm font-bold text-left grow">{{ $header }}</th>
                    @endforeach --}}
                </tr>
                <tr class="flex self-stretch">
                    <th class="px-4 py-2 text-primary-700 text-sm font-bold">No.</th>
                    {{-- @foreach ($headers as $header)
                        <th class="px-4 py-2 mx-2 text-primary-700 text-sm font-bold text-left grow">{{ $header }}</th>
                    @endforeach --}}
                </tr>
                <tr class="flex self-stretch">
                    <th class="px-4 py-2 text-primary-700 text-sm font-bold">No.</th>
                    {{-- @foreach ($headers as $header)
                        <th class="px-4 py-2 mx-2 text-primary-700 text-sm font-bold text-left grow">{{ $header }}</th>
                    @endforeach --}}
                </tr>
                <tr class="flex self-stretch">
                    <th class="px-4 py-2 text-primary-700 text-sm font-bold">No.</th>
                    {{-- @foreach ($headers as $header)
                        <th class="px-4 py-2 mx-2 text-primary-700 text-sm font-bold text-left grow">{{ $header }}</th>
                    @endforeach --}}
                </tr>
            </x-show-table>
        </div>
        <div class="px-4">
            <div class="bg-primary-700 rounded-lg text-white">Evaluation</div>
        </div>
    </div>
</x-app-layout>
