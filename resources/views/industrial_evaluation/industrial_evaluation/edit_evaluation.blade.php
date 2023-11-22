<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Evaluate Student') }}
        </h2>
    </x-slot>
    <div class="px-8">
        {{-- Student Description --}}
        <div class="text-xl font-bold text-primary-700">{{ $student->name }} - PSM{{ $student->psm_year }}</div>

        {{-- Project Description --}}
        <div class="my-4">
            <div class="text-md font-semibold text-gray-500">{{ $student->project->project_title }}</div>
            <div class="text-sm text-gray-400 mt-2">{{ $student->project->project_description }}</div>
        </div>

        {{-- Seperation Line --}}
        <hr/>

        {{-- Evaluation Criteria --}}
        <div class="py-2">
            <form action="/industrial evaluation/{{$student->student_id}}" method="POST">
                @csrf
                {{-- Header --}}
                <div class="font-bold text-xl mt-4">
                    Industrial Evaluation
                </div>
                <div class="flex justify-between items-center mr-12 mt-2">
                    <div class="text-primary-700 font-bold text-sm">Criteria</div>
                    <div class="text-primary-700 font-bold text-sm">Weightage(%)</div>
                    <div class="text-primary-700 font-bold text-sm">Scale</div>
                </div>

                {{-- Print out every criteria for rurbic 1--}}
                <input name="scale_num" value="{{ count($rubric->industrial_rubric_criterias[0]->industrial_sub_criterias[0]->industrial_criteria_scales) }}" hidden/>
                @foreach($rubric->industrial_rubric_criterias as $criteria)
                <div class="mt-4 grow">
                    <div class="font-bold">{{ $criteria->criteria_name }}</div>
                    @foreach($criteria->industrial_sub_criterias as $i => $sub_criteria)
                    <div class="flex px-8 mt-2 justify-between items-center">
                        <input name="sub_criteria_id[]" class="text-sm font-semibold text-gray-400" value="{{ $sub_criteria->industrial_sub_criteria_id }} " hidden/>
                        <input class="text-sm font-semibold text-gray-400" readonly="readonly" value="{{ $sub_criteria->sub_criteria_name }} "/>
                        <input name="weightage[]" class="bg-white text-gray-400 font-semibold" readonly="readonly" value="{{ $sub_criteria->weightage }}"/>
                        <div>
                            <select id="sub_criteria_scale" name="scale[]" class="block text-sm font-semibold mt-1 w-full px-4 py-2 border-0 rounded-md drop-shadow" required>
                                {{-- Check if recorded marks exist, if yes display, else display 0 --}}
                                @for($i = 0; $i <= count($sub_criteria->industrial_criteria_scales)-1; $i++)
                                {{$is_this_criteria = 0}}
                                    @foreach( $marks as $mark )
                                        @if( $mark->industrial_sub_criteria_id == $sub_criteria->industrial_sub_criteria_id && $mark->scale == $i)
                                            {{ $is_this_criteria = 1 }}
                                        @endif
                                    @endforeach
                                    @if($is_this_criteria == 1)
                                        <option value="{{ $i }}" class="text-gray-400 font-semibold" selected>{{ $i }}</option>
                                    @else
                                        <option value="{{ $i }}" class="text-gray-400 font-semibold">{{ $i }}</option>
                                    @endif
                                @endfor
                            </select>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endforeach

                {{-- Action Buttons --}}
                <div class="flex justify-end mt-8 mx-8">
                    <a href="/industrial evaluation"><x-secondary-button class="mr-2">Cancel</x-secondary-button></a>
                    <x-button>Save</x-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>