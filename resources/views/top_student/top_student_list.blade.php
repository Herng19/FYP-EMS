<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Top Students') }}
        </h2>
    </x-slot>

    {{-- Success Message --}}
    <x-success-message />
    {{-- Error Message --}}

    <div class="mt-2 mx-12">
        @role('coordinator')
        {{-- Edit Button --}}
        <div class="flex justify-end items-center">
            <a href="{{ route('top students.edit_top_student') }}">
                <x-button><i class="fa-regular fa-pen mr-2"></i>Edit</x-button>
            </a>
        </div>
        @endrole

        {{-- Top Student Table --}}
        <div class="mt-2">
            <x-show-table :headers="['Name', 'Research Group']">
                <tbody class="flex flex-col w-full" style="min-height: 60vh;">
                    {{-- Normal Rubrics --}}
                    @foreach ($students as $i => $student)
                        <tr class="flex px-8 py-2 items-center {{ ($i%2 == 0)? 'bg-primary-50' : '';}}">
                            <td class="mx-4 py-2 text-gray text-sm font-semibold w-4">{{ intval($i) +1 }}.</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $student->name }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $student->research_group->research_group_name }} ({{ $student->research_group->research_group_short_form }})</td>
                        </tr>
                    @endforeach
                </tbody>
            </x-show-table>
            <div class="my-8">
                {{ $students->links() }}
            </div>
        </div>
    </div>
</x-app-layout>