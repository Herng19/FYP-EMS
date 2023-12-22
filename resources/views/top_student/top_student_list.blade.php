<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Top Students') }}
        </h2>
    </x-slot>

    {{-- Success Message --}}
    <x-success-message />
    {{-- Error Message --}}
    <x-error-message />

    <div class="mt-2 mx-12">
        @role('coordinator')
        {{-- Sorting form & edit button --}}
        <form action="/top students" method="post">
        @csrf
            <div class="flex justify-between items-center">
                <div>
                    <label for="top_students" class="text-gray-500 text-xs font-bold mr-2">Top Students No: </label>
                    <select name="top_student_num" id="top_student_num" class="mr-2 border-0 rounded-md text-sm font-semibold">
                        <option value="20" class="text-sm text-gray-700 font-semibold">Top 20</option>
                        <option value="30" class="text-sm text-gray-700 font-semibold">Top 30</option>
                        <option value="40" class="text-sm text-gray-700 font-semibold">Top 40</option>
                    </select>
                </div>
                <div>
                    <x-button class="mr-2">Generate</x-button>
                    <a href="{{ route('top students.edit_top_student') }}">
                        <x-secondary-button class="border-primary-700 border-2 font-bold text-primary-700"><i class="fa-regular fa-pen mr-2"></i>Edit</x-secondary-button>
                    </a>
                </div>
            </div>
        </form>
        @endrole

        {{-- Top Student Table --}}
        <div class="mt-2">
            {{-- If user is coordinator, then shows marks --}}
            @if(auth()->user()->hasRole('coordinator'))
            <x-show-table :headers="['Name', 'Research Group', 'Marks']">
                <tbody class="flex flex-col w-full" style="min-height: 60vh;">
                    {{-- Normal Rubrics --}}
                    @foreach ($students as $i => $student)
                        <tr class="flex px-8 py-2 items-center {{ ($i%2 == 0)? 'bg-primary-50' : '';}}">
                            <td class="mx-4 py-2 text-gray text-sm font-semibold w-4">{{ intval($i) +1 }}.</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $student->name }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $student->research_group->research_group_name }} ({{ $student->research_group->research_group_short_form }})</td>
                            <td class="py-2 text-primary-800 text-sm font-semibold text-left w-1/3">{{ $marks[$student->student_id] ? $marks[$student->student_id] : '0'; }} / 40</td>
                        </tr>
                    @endforeach
                </tbody>
            </x-show-table>
            @else
            {{-- Table for normal lecturer & students --}}
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
            @endif

            <div class="my-8">
                {{ $students->links() }}
            </div>
        </div>
    </div>
</x-app-layout>