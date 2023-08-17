<x-app-layout>
    <x-slot name="header">
        {{__('Edit Slot')}}
    </x-slot>
    <div class="mx-20" id="slot-form">
        <form action="/evaluation schedule/edit-slot/update" method="POST">
            @csrf
            @method('PUT')
            {{-- Student's Information --}}
            <div>
                <div class="font-bold text-md text-gray">
                    Student's Information
                </div>

                {{-- Form Fields --}}
                <div class="ml-4 mt-2">
                    {{-- Student's Name --}}
                    <label for="name" class="text-gray text-xs font-bold">Student Name</label>
                    <select id="name" name="name" class="block text-sm font-semibold mt-1 w-full bg-primary-100 text-primary-700 px-4 py-2 border-0 rounded-md" required>
                        @foreach($students as $student)
                            @if($student->student_id == $selected_student->student_id)
                                <option value="{{$student->student_id}}" class="text-primary-700 text-inherit font-semibold" selected>{{$student->name}}</option>
                            @else
                                <option value="{{$student->student_id}}" class="text-primary-700 text-inherit font-semibold">{{$student->name}}</option>
                            @endif
                        @endforeach
                    </select>

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
                            @if($venue->venue_id == $slot->venue_id)
                                <option value="{{$venue->venue_id}}" class="text-primary-700 text-inherit font-semibold" selected>{{$venue->venue_code}} {{$venue->venue_name}}</option>
                            @else
                                <option value="{{$venue->venue_id}}" class="text-primary-700 text-inherit font-semibold">{{$venue->venue_code}} {{$venue->venue_name}}</option>
                            @endif
                        @endforeach
                    </select>

                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <label for="date" class="block text-gray text-xs font-bold">Date</label>
                            <x-input id="date" class="block text-sm font-semibold mt-1 w-full pl-4" type="date" name="date" value="{{ \Carbon\Carbon::parse($slot->start_time)->format('Y-m-d')}}" required/>
                        </div>
                        <div>
                            <label for="timeslot" class="block text-gray text-xs font-bold">Timeslot</label>
                            <select id="venue" name="venue" class="block text-sm font-semibold mt-1 w-full bg-primary-100 text-primary-700 px-4 py-2 border-0 rounded-md" required>
                                @foreach($timeslots as $timeslot)
                                    @if((date("H:i", strtotime($slot->start_time))) == $timeslot)
                                        <option value="{{$timeslot}}" class="text-primary-700 text-inherit font-semibold" selected>{{$timeslot}}</option>
                                    @else
                                        <option value="{{$timeslot}}" class="text-primary-700 text-inherit font-semibold">{{$timeslot}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Evaluators 1--}}
                    <div class="mt-4">
                        <label for="evaluator1" class="block text-gray text-xs font-bold">Evaluator 1</label>
                        <select id="evaluator1" name="evaluator1" class="block text-sm font-semibold mt-1 w-full bg-primary-100 text-primary-700 px-4 py-2 border-0 rounded-md" required>
                            @foreach($available_evaluators as $available_evaluator)
                                @if(isset($evaluators[0]) && $available_evaluator->lecturer_id == $evaluators[0]['lecturer_id'])
                                    <option value="{{$available_evaluator->lecturer_id}}" class="text-primary-700 text-inherit font-semibold" selected>{{$available_evaluator->name}}</option>
                                @else
                                    <option value="{{$available_evaluator->lecturer_id}}" class="text-primary-700 text-inherit font-semibold">{{$available_evaluator->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    {{-- Evaluators 2--}}
                    <div class="mt-4">
                        <label for="evaluator2" class="block text-gray text-xs font-bold">Evaluator 2</label>
                        <select id="evaluator2" name="evaluator2" class="block text-sm font-semibold mt-1 w-full bg-primary-100 text-primary-700 px-4 py-2 border-0 rounded-md" required>
                            @foreach($available_evaluators as $available_evaluator)
                                @if(isset($evaluators[1]) && $available_evaluator->lecturer_id == $evaluators[1]['lecturer_id'])
                                    <option value="{{$available_evaluator->lecturer_id}}" class="text-primary-700 text-inherit font-semibold" selected>{{$available_evaluator->name}}</option>
                                @else
                                    <option value="{{$available_evaluator->lecturer_id}}" class="text-primary-700 text-inherit font-semibold">{{$available_evaluator->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="flex my-8 justify-end items-center">
                <x-button class="bg-red-600">Delete</x-button>
                <x-secondary-button class="ml-4">Cancel</x-secondary-button>
                <x-button type="submit" class="ml-4">Update</x-button>
            </div>
        </form>
    </div>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $('body').on('change', "#name", function(e) {
            student_id = $("#name").find(":selected").val();  
            slot_id = '{{$slot->slot_id}}';
            console.log(student_id);

            $.ajax({
                  type: "POST",
                  url: "/evaluation schedule/edit-slot/"+slot_id, 
                  data: {
                    student_id: student_id,
                    slot_id: slot_id, 
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