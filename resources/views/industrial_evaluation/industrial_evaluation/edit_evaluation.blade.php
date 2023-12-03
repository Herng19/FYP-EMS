<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Evaluate Student') }}
        </h2>
    </x-slot>
    <div class="px-8">
        <div class="px-8 py-6 bg-white rounded-md grid grid-cols-2 gap-4">
            {{-- Student Info --}}
            <div>
                <div class="flex items-center mb-2">
                    <i class="fa-solid fa-user-graduate text-primary-700"></i>
                    <div class="ml-2 font-semibold text-primary-700">Student's Info</div>
                </div>
    
                {{-- Student Description --}}
                <div>
                    <div class="text-xl font-bold text-gray">{{ $student->name }} - PSM{{ $student->psm_year }}</div>
                    <div class="text-gray-400 text-sm font-semibold">{{ $student->research_group->research_group_name }} ({{ $student->research_group->research_group_short_form }})</div>
                </div>
            </div>

            <div>
                <div class="flex items-center">
                    <i class="fa-solid fa-file text-primary-700"></i>
                    <div class="text-primary-700 font-semibold ml-2">Project's Info</div>
                </div>
    
                {{-- Project Description --}}
                <div class="mt-2">
                    <div class="text-md font-semibold text-gray">{{ $student->project->project_title }}</div>
                    <div class="text-sm text-gray-400 mt break-all">{{ $student->project->project_description }}</div>
                </div>
            </div>
        </div>

        {{-- Evaluation Criteria --}}
        <div class="bg-white px-8 py-6 rounded-md my-4">
            <div class="flex items-center">
                <i class="fa-solid fa-file-pen text-primary-700"></i>
                <div class="text-primary-700 font-semibold ml-2">Evaluations</div>
            </div>
            <form action="/industrial evaluation/{{$student->student_id}}" method="POST">
                @csrf
                {{-- Header --}}
                <div class="font-bold text-xl mt-4">
                    Industrial Evaluation
                </div>
                <div class="px-4">
                    <div class="flex justify-between items-center mr-12 mt-2">
                        <div class="text-primary-700 font-bold">Criteria</div>
                        {{-- <div class="text-primary-700 font-bold text-sm">Weightage(%)</div>
                        <div class="text-primary-700 font-bold text-sm">Scale</div> --}}
                    </div>

                    {{-- Print out every criteria for industrial rubric--}}
                    <input name="scale_num" value="{{ count($rubric->industrial_rubric_criterias[0]->industrial_sub_criterias[0]->industrial_criteria_scales) }}" hidden/>
                    <?php $scale_num = 0; ?>
                    <?php $criteria_num = 0; ?>
                    @foreach($rubric->industrial_rubric_criterias as $criteria)
                    <div class="mt-4 grow items-center">
                        <div class="font-bold">{{ $criteria->criteria_name }}</div>
                        @foreach($criteria->industrial_sub_criterias as $i => $sub_criteria)
                        <div class="flex px-8 mt-2 items-center">
                            <input name="sub_criteria_id[]" class="text-sm font-semibold text-gray-400" value="{{ $sub_criteria->industrial_sub_criteria_id }} " hidden/>
                            <div>
                                <input class="text-sm font-semibold text-gray-400" readonly="readonly" value="{{ $sub_criteria->sub_criteria_name }} "/>
                            </div>
                            <input name="weightage[]" class="bg-white text-gray-400 font-semibold" value="{{ $sub_criteria->weightage }}" hidden/>
                            <div class="flex grow items-center">
                                @foreach($sub_criteria->industrial_criteria_scales as $scale)
                                    <div class="flex flex-col w-full mx-2 items-center">
                                    @if( @isset($marks[$sub_criteria->industrial_sub_criteria_id]) && $marks[$sub_criteria->industrial_sub_criteria_id] == $scale->scale_level )
                                        <input id="scale[{{ $scale_num }}]" type="radio" class="peer opacity-0" name="scale[{{ $criteria_num }}]" value="{{ $scale->scale_level }}" checked>
                                        <label for="scale[{{ $scale_num }}]" class="rounded-sm flex-col flex border text-sm w-full p-1 border-gray-300 cursor-pointer peer-checked:bg-primary-600 peer-checked:text-white items-center justify-center">
                                            <div class="text-inherit">{{ $scale->scale_description }}</div>
                                            <div class="ml-2 text-inherit font-bold">{{ number_format((float) $scale->scale_level*$sub_criteria->weightage/($loop->count - 1) , 2, '.', '')}}</div>
                                        </label>
                                    @else
                                        <input id="scale[{{ $scale_num }}]" type="radio" class="peer opacity-0" name="scale[{{ $criteria_num }}]" value="{{ $scale->scale_level }}">
                                        <label for="scale[{{ $scale_num }}]" class="rounded-sm flex-col flex border text-sm w-full p-1 border-gray-300 cursor-pointer peer-checked:bg-primary-600 peer-checked:text-white items-center justify-center">
                                            <div class="text-inherit">{{ $scale->scale_description }}</div>
                                            <div class="ml-2 text-inherit font-bold">{{ number_format((float) $scale->scale_level*$sub_criteria->weightage/($loop->count - 1) , 2, '.', '')}}</div>
                                        </label>
                                        @endif
                                    </div>
                                <?php $scale_num++; ?>
                                @endforeach
                            </div>
                        </div>
                        <?php $criteria_num++;  ?>
                        @endforeach
                    </div>
                    @endforeach
                </div>

                {{-- Action Buttons --}}
                <div class="flex justify-end mt-8 mx-8">
                    <a href="/industrial evaluation"><x-secondary-button class="mr-2">Cancel</x-secondary-button></a>
                    <x-button>Save</x-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>