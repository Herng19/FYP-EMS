<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            <a href="/top students"><i class="fa-regular fa-chevron-left fa-sm"></i></a>
            {{ __('Edit Top Students') }}
        </h2>
    </x-slot>

    <div class="mt-2 mb-8 mx-12">
        {{-- Top Student Table --}}
        <div class="mt-2">
            {{-- Edit Top Student Form --}}
            <form action="/top students/edit" method="POST">
                @csrf
                <div class="flex justify-end mr-4 items-center">
                    <div id="total_selected" class="text-primary-700 font-bold text-sm mr-1"></div>
                    <div class="text-gray-400 text-sm">selected</div>
                </div>
                {{-- Top Students List Table --}}
                <x-show-table :headers="['Name', 'Research Group']">
                    <tbody class="flex flex-col w-full" style="min-height: 60vh;">
                        @php $total_selected = 0; @endphp
                        @foreach ($students as $student)
                        <tr class="flex mx-8 mt-2 items-center">
                            <td class="mx-4 py-2 text-gray text-sm font-semibold w-4">{{ $loop->iteration }}.</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $student->name }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $student->research_group->research_group_name }} ({{ $student->research_group->research_group_short_form }})</td>
                            @if($student->top_student)
                            @php $total_selected++; @endphp
                                <td class="py-2 text-gray text-sm font-semibold text-center w-1/3"><input class="rounded-sm" type="checkbox" id="{{ $student->student_id }}" name="top_students[]" value="{{ $student->student_id }}" checked/></td>
                            @else
                                <td class="py-2 text-gray text-sm font-semibold text-center w-1/3"><input class="rounded-sm" type="checkbox" id="{{ $student->student_id }}" name="top_students[]" value="{{ $student->student_id }}"/></td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </x-show-table>
                <div class="flex justify-end items-center mt-4">
                    <x-button class="mr-4">Save</x-button>
                </div>
            </form>
        </div>
    </div>
    <script>
        // Set total_selected to the count of selected students
        var total_selected = {{ $total_selected }};

        // Get total_selected element
        var display = $('#total_selected');

        // Display initial total_selected
        display.text(total_selected);

        // Get all checkboxes
        var checkboxes = document.querySelectorAll('input[type=checkbox]');

        // Foreach checkbox, add event listener to update total_selected
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    total_selected++;
                } else {
                    total_selected--;
                }
                // Update total_selected display
                display.text(total_selected);
            });
        });
    </script>
</x-app-layout>