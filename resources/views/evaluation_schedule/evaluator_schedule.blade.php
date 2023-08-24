<x-app-layout>
    <x-slot name="header">
        {{__('My Schedule')}}
    </x-slot>
    <div class="px-8">
        <x-show-table :headers="['Evaluatee Name', 'Project Title', 'Date', 'Timeslot', 'Venue']">
            <tbody class="flex flex-col w-full" style="height: 70vh;">
                @foreach ($evaluatees as $i => $evaluatee)
                    <tr class="flex mx-8 mt-2">
                        <td class="mx-4 py-2 text-gray text-sm font-semibold w-4">{{ $i+1 }}.</td>
                        <td class="py-2 text-gray text-sm font-semibold text-left w-1/4">{{ $evaluatee->name }}</td>
                        <td class="py-2 text-gray-500 text-sm font-semibold text-left w-1/4">{{ $evaluatee->project->project_title }}</td>
                        <td class="py-2 text-gray text-sm font-semibold text-left w-1/4">{{ \Carbon\Carbon::parse($evaluatee->slot->start_time)->format('d-m-Y')}}</td>
                        <td class="py-2 text-gray text-sm font-semibold text-left w-1/4">{{ (date("H:i", strtotime($evaluatee->slot->start_time))) }} - {{ (date("H:i", strtotime($evaluatee->slot->end_time))) }}</td>
                        <td class="py-2 text-gray text-sm font-semibold text-left w-1/4">{{ $evaluatee->slot->venues->venue_code }} {{ $evaluatee->slot->venues->venue_name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </x-show-table>
        <div class="my-4">
            {{ $evaluatees->links() }}
        </div>
    </div>
</x-app-layout>