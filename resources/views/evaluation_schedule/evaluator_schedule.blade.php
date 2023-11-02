<x-app-layout>
    <x-slot name="header">
        <a href="/evaluation schedule"><i class="fa-regular fa-chevron-left fa-xs"></i></a>
        {{__('My Schedule')}}
    </x-slot>
    <div class="px-8">
        <x-show-table :headers="['Evaluatee Name', 'PSM Year', 'Project Title', 'Date', 'Timeslot', 'Venue']">
            <tbody class="flex flex-col w-full" style="height: 70vh;">
                @foreach ($evaluatees as $i => $evaluatee)
                    <tr class="flex px-8 py-2 {{ ($i%2 == 0)? 'bg-primary-50' : '';}}">
                        <td class="mx-4 py-2 text-gray text-sm font-semibold w-4">{{ $i+1 }}.</td>
                        <td class="py-2 text-gray text-sm font-semibold text-left w-1/4">{{ $evaluatee->name }}</td>
                        <td class="py-2 text-gray text-sm font-semibold text-left w-1/4">{{ $evaluatee->psm_year }}</td>
                        <td class="py-2 text-gray-500 text-sm font-semibold text-left w-1/4">{{ $evaluatee->project->project_title }}</td>
                        <td class="py-2 text-gray text-sm font-semibold text-left w-1/4">{{ \Carbon\Carbon::parse($evaluatee->slot->start_time)->format('d-m-Y')}}</td>
                        <td class="py-2 text-gray text-sm font-semibold text-left w-1/4">{{ (date("H:i", strtotime($evaluatee->slot->start_time))) }} - {{ (date("H:i", strtotime($evaluatee->slot->end_time))) }}</td>
                        @if($evaluatee->psm_year == '1')
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/4">{{ $evaluatee->slot->venues->venue_code }} {{ $evaluatee->slot->venues->venue_name }}</td>
                        @elseif($evaluatee->psm_year == '2')
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/4">{{ $evaluatee->slot->booths->booth_code }} {{ $evaluatee->slot->booths->booth_name }}</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </x-show-table>
        <div class="my-4">
            {{ $evaluatees->links() }}
        </div>
    </div>
</x-app-layout>