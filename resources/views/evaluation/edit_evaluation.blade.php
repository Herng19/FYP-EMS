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
        <div class="bg-white px-8 py-6 rounded-md mt-4">
            <div class="flex items-center">
                <i class="fa-solid fa-file-pen text-primary-700"></i>
                <div class="text-primary-700 font-semibold ml-2">Evaluations</div>
            </div>
            <form action="/evaluation/{{$student->student_id}}" method="POST">
                @csrf
                {{-- Header --}}
                <div class="font-bold text-xl mt-4">
                    @for($i = 1; $i <= 3; $i++)
                        @if( $rubric->evaluation_type[-1] == $i )
                            <div>Evaluation {{ $rubric->evaluation_type[-1] }}</div>
                        @endif
                    @endfor
                </div>
                <div class="px-4">
                    <div class="flex justify-between items-center mr-12 mt-2">
                        <div class="text-primary-700 font-bold">Criteria</div>
                    </div>
    
                    {{-- Print out every criteria for rurbic 1--}}
                    <input name="evaluation_type" value="{{ $rubric->evaluation_type }}" hidden/>
                    <input name="scale_num" value="{{ count($rubric->rubric_criterias[0]->sub_criterias[0]->criteria_scales) }}" hidden/>
                    <?php $scale_num = 0; ?>
                    <?php $criteria_num = 0; ?>
                    @foreach($rubric->rubric_criterias as $criteria)
                    <div class="mt-4 grow items-center">
                        <div class="font-bold">{{ $criteria->criteria_name }}</div>
                        @foreach($criteria->sub_criterias as $i => $sub_criteria)
                        <div class="flex px-8 mt-2 items-center">
                            <input name="sub_criteria_id[]" class="text-sm font-semibold text-gray-400" value="{{ $sub_criteria->sub_criteria_id }} " hidden/>
                            <div>
                                <input class="text-sm font-semibold text-gray-400" readonly="readonly" value="{{ $sub_criteria->sub_criteria_name }} "/>
                            </div>
                            <input name="weightage[]" class="bg-white text-gray-400 font-semibold" value="{{ $sub_criteria->weightage }}" hidden/>
                            <div class="flex grow items-center">
                                @foreach($sub_criteria->criteria_scales as $scale)
                                    <div class="flex flex-col w-full mx-2 items-center">
                                    @if( @isset($marks[$sub_criteria->sub_criteria_id]) && $marks[$sub_criteria->sub_criteria_id] == $scale->scale_level )
                                        <input id="scale[{{ $scale_num }}]" type="radio" class="peer opacity-0" name="scale[{{ $criteria_num }}]" value="{{ $scale->scale_level }}" checked>
                                        <label for="scale[{{ $scale_num }}]" class="rounded-sm text-sm flex-col flex border w-full p-1 shadow border-gray-300 cursor-pointer peer-checked:bg-primary-600 peer-checked:text-white items-center justify-center">
                                            <div class="text-inherit">{{ $scale->scale_description }}</div>
                                            <div class="ml-2 text-inherit font-bold">{{ number_format((float) $scale->scale_level*$sub_criteria->weightage/($loop->count - 1) , 2, '.', '')}}</div>
                                        </label>
                                    @else
                                        <input id="scale[{{ $scale_num }}]" type="radio" class="peer opacity-0" name="scale[{{ $criteria_num }}]" value="{{ $scale->scale_level }}">
                                        <label for="scale[{{ $scale_num }}]" class="rounded-sm text-sm flex-col flex border w-full p-1 shadow border-gray-300 cursor-pointer peer-checked:bg-primary-600 peer-checked:text-white items-center justify-center">
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

                    {{-- Comment --}}
                    <div class="mt-4">
                        <label for="comment" class="font-bold text-gray-700 text-sm">Comment (optional)</label>
                        <textarea name="comment" id="comment" class="w-full border border-gray-300 rounded-md p-2 mt-2 focus:border-0 focus:ring-primary-400 focus:ring-1" rows="3">{{ ($evaluation)? $evaluation->comment : ""; }}</textarea>
                    </div>
                </div>

                <hr class="my-4"/>
                {{-- Check if rubric 2 (for evaluation 3) exist, if yes, display --}}
                @if( $rubric_2 )
                    {{-- Header --}}
                    <div class="font-bold text-xl my-4">
                        @if( $rubric_2->evaluation_type[-1] == 3 )
                            <div>Evaluation {{ $rubric_2->evaluation_type[-1] }}</div>
                        @endif
                    </div>
                    <div class="px-4">
                        <div class="flex justify-between items-center mr-12 mt-2">
                            <div class="text-primary-700 font-bold">Criteria</div>
                        </div>
                            
                        {{-- Print out every criteria for evaluation 3--}}
                        <input name="evaluation_type_2" value="{{ $rubric_2->evaluation_type }}" hidden/>
                        <input name="scale_num_2" value="{{ count($rubric_2->rubric_criterias[0]->sub_criterias[0]->criteria_scales) }}" hidden/>
                        <?php $scale_num_2 = 0; ?>
                        <?php $criteria_num_2 = 0; ?>
                        @foreach($rubric_2->rubric_criterias as $criteria)
                        <div class="mt-4 grow">
                            <div class="font-bold">{{ $criteria->criteria_name }}</div>
                            @foreach($criteria->sub_criterias as $i => $sub_criteria)
                            <div class="flex px-8 mt-2 items-center">
                                <input name="sub_criteria_id_2[]" class="text-sm font-semibold text-gray-400" value="{{ $sub_criteria->sub_criteria_id }} " hidden/>
                                <div>
                                    <input class="text-sm font-semibold text-gray-400" readonly="readonly" value="{{ $sub_criteria->sub_criteria_name }} "/>
                                </div>
                                <input name="weightage_2[]" class="bg-white text-gray-400 font-semibold" value="{{ $sub_criteria->weightage }}" hidden/>
                                <div class="flex grow items-center">
                                    @foreach($sub_criteria->criteria_scales as $scale)
                                        <div class="flex flex-col w-full mx-2 items-center">
                                        @if( @isset($marks_2[$sub_criteria->sub_criteria_id]) && $marks_2[$sub_criteria->sub_criteria_id] == $scale->scale_level )
                                            <input id="scale_2[{{ $scale_num_2 }}]" type="radio" class="peer opacity-0" name="scale_2[{{ $criteria_num_2 }}]" value="{{ $scale->scale_level }}" checked>
                                            <label for="scale_2[{{ $scale_num_2 }}]" class="rounded-sm text-sm flex-col flex p-1 shadow border w-full border-gray-300 cursor-pointer peer-checked:bg-primary-600 peer-checked:text-white items-center justify-center">
                                                <div class="text-inherit">{{ $scale->scale_description }}</div>
                                                <div class="ml-2 text-inherit font-bold">{{ number_format((float) $scale->scale_level*$sub_criteria->weightage/($loop->count - 1) , 2, '.', '')}}</div>
                                            </label>
                                        @else
                                            <input id="scale_2[{{ $scale_num_2 }}]" type="radio" class="peer opacity-0" name="scale_2[{{ $criteria_num_2 }}]" value="{{ $scale->scale_level }}">
                                            <label for="scale_2[{{ $scale_num_2 }}]" class="rounded-sm text-sm flex-col flex p-1 shadow border w-full border-gray-300 cursor-pointer peer-checked:bg-primary-600 peer-checked:text-white items-center justify-center">
                                                <div class="text-inherit">{{ $scale->scale_description }}</div>
                                                <div class="ml-2 text-inherit font-bold">{{ number_format((float) $scale->scale_level*$sub_criteria->weightage/($loop->count - 1) , 2, '.', '')}}</div>
                                            </label>
                                            @endif
                                        </div>
                                    <?php $scale_num_2++; ?>
                                    @endforeach
                                </div>
                            </div>
                            <?php $criteria_num_2++;  ?>
                            @endforeach
                        </div>
                        @endforeach
                        
                        {{-- Comment --}}
                        <div class="mt-4">
                            <label for="comment_2" class="font-bold text-gray-700 text-sm">Comment (optional)</label>
                            <textarea name="comment_2" id="comment" class="w-full border border-gray-300 rounded-md p-2 mt-2 focus:border-0 focus:ring-primary-400 focus:ring-1" rows="3">{{ ($evaluation_2)? $evaluation_2->comment : ""; }}</textarea>
                        </div>
                    </div>
                @endif

                {{-- Action Buttons --}}
                <div class="flex justify-end mt-8 mx-8">
                    <a href="/evaluation"><x-secondary-button class="mr-2">Cancel</x-secondary-button></a>
                    <x-button>Save</x-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>