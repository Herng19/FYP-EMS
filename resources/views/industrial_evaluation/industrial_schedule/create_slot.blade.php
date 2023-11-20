<x-app-layout>
    <x-slot name="header">
        {{__('Create Industrial Slot')}}
    </x-slot>

    {{-- Edit Slot Form --}}
    <div class="mx-20" id="slot-form">
        {{-- Update Success Message --}}
         <x-success-message />
         
        <form action="/industrial schedule/create-slot" method="POST" id="edit-slot-form">
            @csrf
            {{-- Student's Information --}}
            <div>
                <div class="font-bold text-md text-gray">
                    Student's Information
                </div>

                {{-- Form Fields --}}
                <div class="ml-4 mt-2">
                    {{-- Student's Name --}}
                    <label for="name" class="text-gray text-xs font-bold">Student Name</label>
                    <select id="name" name="name" class="block text-primary-700 text-sm font-semibold mt-1 w-full bg-primary-100 px-4 py-2 border-0 rounded-md" required>
                        @foreach($students as $student)
                            @if($student->student_id == $selected_student->student_id)
                                <option value="{{$student->student_id}}" class="text-inherit font-semibold @if($student->industrial_evaluation_slot !== null) text-primary-300 @else text-primary-700 @endif" selected>{{$student->name}}</option>
                            @else
                                <option value="{{$student->student_id}}" class="text-inherit font-semibold @if($student->industrial_evaluation_slot !== null) text-primary-300 @else text-primary-700 @endif">{{$student->name}}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('name')
                        <div class="text-red-500 text-xs mt-1">{{$message}}</div>
                    @enderror

                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <label for="PSM" class="block text-gray text-xs font-bold">PSM</label>
                            <x-input id="PSM" class="block text-sm font-semibold mt-1 w-full pl-4" type="text" name="PSM" value="PSM {{$selected_student->psm_year}}" disabled/>
                        </div>
                        <div>
                            <label for="research_group" class="block text-gray text-xs font-bold">Research Group</label>
                            <x-input id="research_group" class="block text-sm font-semibold mt-1 w-full pl-4" type="text" name="research_group" value="{{$selected_student->research_group->research_group_short_form}}" disabled/>
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="project_title" class="block text-gray text-xs font-bold">Project Title</label>
                        <x-input id="project_title" class="block text-sm font-semibold mt-1 w-full pl-4" type="text" name="project_title" value="{{$selected_student->project->project_title}}" disabled/>
                    </div>
                </div>
            </div>

            {{-- seperation line --}}
            <br/>
            <hr/>
            <br/>

            {{-- Schedule Information --}}
            <div>
                <div class="font-bold text-md text-gray">
                    Schedule Information
                </div>

                {{-- Form Fields --}}
                <div class="ml-4 mt-2">
                    {{-- Student's Name --}}
                    <label for="venue" class="text-gray text-xs font-bold">Venue</label>
                    <select id="venue" name="venue" class="block text-sm font-semibold mt-1 w-full bg-primary-100 text-primary-700 px-4 py-2 border-0 rounded-md" required>
                        @foreach($venues as $venue)
                            @if($venue->venue_id == old('venue'))
                                <option value="{{$venue->venue_id}}" class="text-primary-700 text-inherit font-semibold" selected>{{$venue->venue_code}} {{$venue->venue_name}}</option>
                            @else
                                <option value="{{$venue->venue_id}}" class="text-primary-700 text-inherit font-semibold">{{$venue->venue_code}} {{$venue->venue_name}}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('venue')
                        <div class="text-red-500 text-xs mt-1">{{$message}}</div>
                    @enderror

                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <label for="date" class="block text-gray text-xs font-bold">Date</label>
                            <x-input id="date" class="block text-sm font-semibold mt-1 w-full pl-4" type="date" name="date" value="{{ old('date')}}" required/>
                            @error('date')
                                <div class="text-red-500 text-xs mt-1">{{$message}}</div>
                            @enderror
                        </div>
                        <div>
                            <label for="timeslot" class="block text-gray text-xs font-bold">Timeslot</label>
                            <select id="timeslot" name="timeslot" class="block text-sm font-semibold mt-1 w-full bg-primary-100 text-primary-700 px-4 py-2 border-0 rounded-md" required>
                                @foreach($timeslots as $timeslot)
                                    @if($timeslot == old('timeslot'))
                                        <option value="{{$timeslot}}" class="text-primary-700 text-inherit font-semibold" selected>{{$timeslot}}</option>
                                    @else
                                        <option value="{{$timeslot}}" class="text-primary-700 text-inherit font-semibold">{{$timeslot}}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('timeslot')
                                <div class="text-red-500 text-xs mt-1">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Evaluators 1--}}
                    <div class="mt-4">
                        <label for="evaluator1" class="block text-gray text-xs font-bold">Evaluator 1</label>
                        <select id="evaluator1" name="evaluator1" class="block text-sm font-semibold mt-1 w-full bg-primary-100 text-primary-700 px-4 py-2 border-0 rounded-md" required>
                            @foreach($available_evaluators as $available_evaluator)
                                @if($available_evaluator->industrial_evaluator_id == old('evaluator1'))
                                    <option value="{{$available_evaluator->industrial_evaluator_id}}" class="text-primary-700 text-inherit font-semibold" selected>{{$available_evaluator->evaluator_name}}</option>
                                @else
                                    <option value="{{$available_evaluator->industrial_evaluator_id}}" class="text-primary-700 text-inherit font-semibold">{{$available_evaluator->evaluator_name}}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('evaluator1')
                            <div class="text-red-500 text-xs mt-1">{{$message}}</div>
                        @enderror
                    </div>

                    {{-- Evaluators 2--}}
                    <div class="mt-4">
                        <label for="evaluator2" class="block text-gray text-xs font-bold">Evaluator 2</label>
                        <select id="evaluator2" name="evaluator2" class="block text-sm font-semibold mt-1 w-full bg-primary-100 text-primary-700 px-4 py-2 border-0 rounded-md" required>
                            @foreach($available_evaluators as $available_evaluator)
                                @if($available_evaluator->industrial_evaluator_id == old('evaluator2'))
                                    <option value="{{$available_evaluator->industrial_evaluator_id}}" class="text-primary-700 text-inherit font-semibold" selected>{{$available_evaluator->evaluator_name}}</option>
                                @else
                                    <option value="{{$available_evaluator->industrial_evaluator_id}}" class="text-primary-700 text-inherit font-semibold">{{$available_evaluator->evaluator_name}}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('evaluator2')
                            <div class="text-red-500 text-xs mt-1">{{$message}}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </form>

        {{-- Buttons --}}
        <div class="flex my-8 justify-end items-center">
            <a href="/industrial schedule"><x-secondary-button class="ml-4" id="cancel-button">Cancel</x-secondary-button></a>
            <x-button type="submit" class="ml-4" form="edit-slot-form">Create</x-button>
        </div>
    </div>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // When student is selected, update student info and available evaluators
        $('body').on('change', "#name", function(e) {
            student_id = $("#name").find(":selected").val();  

            $.ajax({
                  type: "PUT",
                  url: "/industrial schedule/create-slot", 
                  data: {
                    student_id: student_id, 
                  },
                  success: function(result) {
                      $('#slot-form').html(jQuery(result).find('#slot-form').html());
                      console.log(result);
                  },
                  error: function (error) {
                    console.log(error);
                  }
            });
        });
    </script>
</x-app-layout>