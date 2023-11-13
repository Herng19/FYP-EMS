<x-app-layout>
    <x-slot name="header">
        Edit Rubric
    </x-slot>

    {{-- Success message --}}
    <x-success-message/>

    <div class="my-4 px-8">
        <form action="/rubric/edit/{{ $rubric->rubric_id }}" method="POST">
            @method('PUT')
            @csrf
            <div>
                {{-- Rubric Basic Info --}}
                <div class="font-bold text-gray">Rubric Info</div>
                <div class="px-4 mt-2">
                    <x-input id="rubric-name" class="block text-sm mt-1 w-full pl-4" type="text" name="rubric_name" placeholder="Rubric Name" value="{{ $rubric->rubric_name }}" required/>
                    <div class="flex grid grid-cols-3 gap-4 mt-2">
                        <div>
                            <select id="research-group" name="research_group" class="block text-sm font-semibold mt-1 w-full bg-primary-100 text-primary-300 px-4 py-2 border-0 rounded-md" required>
                                <option value="" class="text-primary-700 font-semibold" default>Reseach Group</option>
                                @foreach ($research_groups as $research_group)
                                    @if($research_group->research_group_id == $rubric->research_group_id )
                                        <option value="{{ $research_group->research_group_id }}" class="text-primary-700 font-semibold" selected>{{ $research_group->research_group_name }} ({{ $research_group->research_group_short_form }} )</option>
                                    @else
                                        <option value="{{ $research_group->research_group_id }}" class="text-primary-700 font-semibold">{{ $research_group->research_group_name }} ({{ $research_group->research_group_short_form }} )</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <select id="evaluation-number" name="evaluation_number" class="block text-sm font-semibold mt-1 w-full bg-primary-100 text-primary-300 px-4 py-2 border-0 rounded-md" required>
                                <option value="evaluation1" class="text-primary-700 font-semibold" {{ ($rubric->evaluation_type == "evaluation1")? "selected" : "" }}>Evaluation 1 (by supervisor)</option>
                                <option value="evaluation2" class="text-primary-700 font-semibold" {{ ($rubric->evaluation_type == "evaluation2")? "selected" : "" }}>Evaluation 2 (by evaluators)</option>
                                <option value="evaluation3" class="text-primary-700 font-semibold" {{ ($rubric->evaluation_type == "evaluation3")? "selected" : "" }}>Evaluation 3 (by supervisor)</option>
                            </select>
                        </div>
                        <div>
                            <select id="PSM" name="PSM" class="block text-sm font-semibold mt-1 w-full bg-primary-100 text-primary-300 px-4 py-2 border-0 rounded-md" required>
                                <option value="1" class="text-primary-700 font-semibold" {{ ($rubric->psm_year == "1")? "selected" : "" }}>PSM 1</option>
                                <option value="2" class="text-primary-700 font-semibold" {{ ($rubric->psm_year == "2")? "selected": "" }}>PSM 2</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mt-6 mx-4" id="criteria-form">
                    {{-- Rubric Elements --}}
                    <div class="font-bold text-gray text-sm">Elements</div>
                    @foreach( $rubric->rubric_criterias as $i => $rubric_criteria )
                    {{-- Main Criteria --}}
                    <div class="mt-4 px-4" id="criteria-0">
                        <div class="flex items-center">
                            <label id="main-numbering" class="mr-2 text-gray-500 text-sm font-semibold">{{ $i+1 }}</label>
                            <input name="criteria[{{ $i }}][criteria_id]" value="{{ ($rubric_criteria->criteria_id)? $rubric_criteria->criteria_id : null }}" hidden />
                            <x-input id="criteria-name" class="block text-sm mt-1 w-full pl-4" type="text" name="criteria[{{ $i }}][criteria_name]" value="{{ $rubric_criteria->criteria_name }}" placeholder="Criteria Name" required/>
                            <button type="button" class="delete-criteria ml-2 py-2 px-3 bg-red-50 rounded-full hover:bg-red-100"><i class="fa-regular fa-trash-can text-red-500"></i></button>
                        </div>
                        @foreach( $rubric_criteria->sub_criterias as $j => $sub_criteria)
                        {{-- Sub Criteria --}}
                        <div class="px-8 mt-2" id="criteria-0-0">
                            <div class="flex">
                                <div class="grid grid-cols-5 gap-2 w-full">
                                    <div class="col-span-3 flex items-center">
                                        <input name="criteria[{{ $i }}][{{ $j }}][sub_criteria_id]" value="{{ ($sub_criteria->sub_criteria_id)? $sub_criteria->sub_criteria_id : null }}" hidden />
                                        <label id="sub-numbering" class="mr-2 text-gray-500 text-sm font-semibold">{{ $i+1 }}.{{ $j+1 }}</label>
                                        <x-input id="sub-criteria-name" class="block text-sm mt-1 w-full pl-4" type="text" name="criteria[{{ $i }}][{{ $j }}][sub_criteria_name]" value="{{ $sub_criteria->sub_criteria_name}}" placeholder="Sub Criteria Name" required/>    
                                    </div>
                                    <div>
                                        <x-input id="sub-criteria-weightage" class="block text-sm mt-1 w-full pl-4" type="number" name="criteria[{{ $i }}][{{ $j }}][sub_criteria_weightage]" value="{{ $sub_criteria->weightage }}" placeholder="Weightage(%)" min='1' max='100' required/>
                                    </div>
                                    <div>
                                        <select id="sub-criteria-co-level" name="criteria[{{ $i }}][{{ $j }}][sub_criteria_co_level]" class="block text-sm font-semibold mt-1 w-full bg-primary-100 text-primary-300 px-4 py-2 border-0 rounded-md" required>
                                            <option value="co-1" class="text-primary-700 font-semibold" {{ ($sub_criteria->co_level == "co-1")? "selected" : "" }}>CO 1</option>
                                            <option value="co-2" class="text-primary-700 font-semibold" {{ ($sub_criteria->co_level == "co-2")? "selected" : "" }}>CO 2</option>
                                            <option value="co-3" class="text-primary-700 font-semibold" {{ ($sub_criteria->co_level == "co-3")? "selected" : "" }}>CO 3</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="button" class="delete-sub-criteria ml-2 my-1 py-2 px-3 bg-red-50 rounded-full hover:bg-red-100"><i class="fa-regular fa-trash-can text-red-500"></i></button>
                            </div>
                            <div class="mt-2 pl-6 pr-12">
                                <x-input id="sub-criteria-description" class="block text-sm mt-1 w-full pl-4" type="text" name="criteria[{{ $i }}][{{ $j }}][sub_criteria_description]" value="{{ $sub_criteria->sub_criteria_description }}" placeholder="Sub Criteria Description" required/>
                            </div>

                            {{-- Description for each level --}}
                            <div class="px-12">
                                @foreach($sub_criteria->criteria_scales as $k => $criteria_scale)
                                    <div class="flex items-center mt-2">
                                        <input name="criteria[{{ $i }}][{{ $j }}][{{ $k }}][scale_id]" value="{{ ($criteria_scale->scale_id)? $criteria_scale->scale_id : null }}" hidden />
                                        <label for="scale-{{ $k }}" class="mx-2 text-gray-400" id="scale-numbering">{{ $k }}</label>
                                        <x-input id="scale-{{ $k }}" class="block text-sm mt-1 w-full pl-4" type="text" name="criteria[{{ $i }}][{{ $j }}][{{ $k }}][scale_description]" value="{{ $criteria_scale->scale_description }}" placeholder="Mark Description" required/>
                                        <button type="button" class="delete-scale mx-2"><i class="fa-regular fa-trash-can text-red-500"></i></button>
                                    </div>
                                @endforeach
                                {{-- Add New Scale Button --}}
                                <div class="mt-4 ml-8">
                                    <button type="button" class="add-scale-button text-primary-700 font-bold text-[11px] border-gray-200 border-2 rounded-md px-3 py-2 hover:bg-gray-100"><i class="fa-regular fa-circle-plus fa-lg mr-2"></i>ADD SCALE</button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        {{-- Add New Sub Criteria Button --}}
                        <div class="mt-2 pl-8">
                            <button type="button" class="add-sub-criteria-button text-primary-700 font-bold text-[11px] border-gray-200 border-2 rounded-md px-3 py-2 hover:bg-gray-100"><i class="fa-regular fa-circle-plus fa-lg mr-2"></i>ADD SUB CRITERIA</button>
                        </div>
                    </div>
                    @endforeach
                    {{-- Add New Criteria Button --}}
                    <div class="mt-2">
                        <button type="button" class="add-criteria-button text-primary-700 font-bold text-[11px] border-gray-200 border-2 rounded-md px-3 py-2 hover:bg-gray-100"><i class="fa-regular fa-circle-plus fa-lg mr-2"></i>ADD CRITERIA</button>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex justify-end mt-8 mx-8">
                <a href="/rubric"><x-secondary-button class="mr-2">Cancel</x-secondary-button></a>
                <x-button>Update</x-button>
            </div>
        </form>
    </div>

    {{-- JQuery --}}
    <script type="text/javascript">
        $(document).ready(function() {
            // CSRF Token for submit form request
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Add new sub criteria
            $('#criteria-form').on('click', '.add-sub-criteria-button', function(e) {
                e.preventDefault();

                // Clone the last sub criteria
                var new_element = $(this).parent().prev().clone();

                // Clear all the input except for "<in between>"
                new_element.find("input").each(function() {
                    if($(this).val() != "<in between>") {
                        $(this).val("");
                    }
                });
                new_element.find("select").val("co-1");

                // Update the numbering of the sub criteria
                var main_number = $(this).parent().parent().find("#main-numbering").text();
                new_element.find("#sub-numbering").text(main_number + "." + (parseInt(new_element.find("#sub-numbering").text().substring(2)) + 1));

                // Update the name of the sub criteria
                new_element.find("input, select").each(function() {
                    var name = $(this).prop("name");
                    var index = name.indexOf("][")+1;
                    var end_index = name.indexOf("][", index);
                    var new_name = name.substring(0, index+1) + (parseInt(name.substring(index+1, end_index)) + 1) + name.substring(end_index);
                    $(this).prop("name", new_name);
                });

                // Append the new sub criteria
                $(this).parent().before(new_element);
            });

            // Add new criteria
            $('#criteria-form').on('click', '.add-criteria-button', function(e) {
                e.preventDefault();

                // Clone the last criteria
                var new_element = $(this).parent().prev().clone();

                // Remove all the sub criteria except the first one
                for(var i = 0; 3 < (new_element.children().length); i++) {
                    new_element.children().eq(2).remove();
                }

                // Clear all the input except for "<in between>"
                new_element.find("input").each(function() {
                    if($(this).val() != "<in between>") {
                        $(this).val("");
                    }
                });
                new_element.find("select").val("co-1");

                // Update the numbering of the criteria
                var main_number = new_element.find("#main-numbering").text((parseInt(new_element.find("#main-numbering").text()) + 1));
                new_element.find("#sub-numbering").text(main_number.text() + ".1");

                // Update the id of the criteria
                new_element.find("input, select").each(function() {
                    var name = $(this).prop("name");
                    var index = name.indexOf("]");
                    var start_index = name.indexOf("[");
                    var new_name = name.substring(0, start_index+1) + (parseInt(name.substring(start_index+1, index)) + 1) + name.substring(index);
                    $(this).prop("name", new_name);
                });

                // Append the new criteria
                $(this).parent().before(new_element);
            });

            // Add new scale
            $('#criteria-form').on('click', '.add-scale-button', function(e) {
                e.preventDefault();

                // Clone the last scale
                var new_element = $(this).parent().prev().clone();
                numbering = new_element.find("#scale-numbering").text()

                // Clear all input
                new_element.find("input").val("");

                // Update the numbering of the scale
                var main_number = new_element.find("#scale-numbering").text(parseInt(new_element.find("#scale-numbering").text()) + 1);

                // Update the id and name of the criteria
                var name = new_element.find("input#scale-"+numbering).prop("name");
                var index = name.indexOf("][", 11);
                var end_index = name.indexOf("]", index+1);
                var new_name = name.substring(0, index+2) + (parseInt(name.substring(index+2, end_index)) + 1) + name.substring(end_index);
                new_element.find("input#scale-"+numbering).prop("name", new_name).prop("id", "scale-"+(parseInt(numbering)+1));
                new_element.find("input[name*='[scale_id]']").prop("name", new_name.replace('scale_description', 'scale_id'));

                // Append the new criteria
                $(this).parent().before(new_element);
            });

            // Delete the criteria
            $('#criteria-form').on('click', '.delete-criteria', function(e) {
                e.preventDefault();
                criteria_id = $(this).parent().find("input[name*='[criteria_id]']").val();

                // Check if there is only one criteria left, if yes, do not allow deletion
                if($(this).parent().parent().parent().children().length <= 3) {
                    alert("A rubric must have at least one criteria.");
                    return;
                }

                // Make request to delete the criteria
                $.ajax({
                    type: "DELETE",
                    url: '/rubric/delete-criteria/' + criteria_id,
                    data: {
                        criteria_id: criteria_id,
                    },
                    success: function(result) {
                        console.log(result);
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });

                // Update the numbering of the criteria
                $(this).parent().parent().nextAll("div").each(function() {
                    var main_number = $(this).find("#main-numbering").text();
                    $(this).find("#main-numbering").text(parseInt(main_number) - 1);

                    $(this).children().each(function() {
                        var sub_number = $(this).find("#sub-numbering").text();
                        $(this).find("#sub-numbering").text(main_number-1 + "." + sub_number.substring(sub_number.indexOf(".") + 1));
                    });
                });

                // Remove the criteria
                $(this).parent().parent().remove();
            });

            // Delete the sub criteria
            $('#criteria-form').on('click', '.delete-sub-criteria', function(e) {
                e.preventDefault();
                sub_criteria_id = $(this).parent().find("input[name*='[sub_criteria_id]']").val();
                console.log(sub_criteria_id);

                // Check if there is only one sub criteria left, if yes, do not allow deletion
                if($(this).parent().parent().parent().children().length <= 3) {
                    alert("A criteria must have at least one sub criteria.");
                    return;
                }

                // Make request to delete the criteria
                $.ajax({
                    type: "DELETE",
                    url: '/rubric/delete-sub-criteria/' + sub_criteria_id,
                    data: {
                        sub_criteria_id: sub_criteria_id,
                    },
                    success: function(result) {
                        console.log(result);
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });

                // Update the numbering of the sub criteria
                $(this).parent().parent().nextAll("div").each(function() {
                    var sub_number = $(this).find("#sub-numbering").text();
                    $(this).find("#sub-numbering").text(sub_number.substring(0, sub_number.indexOf(".") + 1) + (parseInt(sub_number.substring(sub_number.indexOf(".") + 1)) - 1));
                });


                // Remove the sub criteria
                $(this).parent().parent().remove();
            });

            // Delete the scale
            $('#criteria-form').on('click', '.delete-scale', function(e) {
                e.preventDefault();
                // Check if there is only one scale left, if yes, do not allow deletion
                if($(this).parent().parent().children().length <= 3) {
                    alert("A sub criteria must have at least 2 scales");
                    return;
                }

                scale_id = $(this).parent().find("input[name*='[scale_id]']").val();

                // If scale id not null, then delete the scale from database
                if(scale_id != null) {
                    // Make request to delete the scale
                    $.ajax({
                        type: "DELETE",
                        url: '/rubric/delete-scale/' + scale_id,
                        data: {
                            scale_id: scale_id,
                        },
                        success: function(result) {
                            console.log(result);
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                }

                // Update the numbering of the scale
                $(this).parent().nextAll("div:not(:last)").each(function() {
                    var sub_number = $(this).find("#scale-numbering").text();
                    
                    $(this).find("#scale-numbering").text(sub_number - 1);

                    var name = $(this).find("input#scale-"+sub_number).prop("name");
                    var index = name.indexOf("][", 11);
                    var end_index = name.indexOf("]", index+1);
                    console.log(index, end_index);
                    var new_name = name.substring(0, index+2) + (parseInt(name.substring(index+2, end_index)) - 1) + name.substring(end_index);
                    $(this).find("input#scale-"+sub_number).prop("name", new_name).prop("id", "scale-"+(sub_number-1));
                    $(this).find("input[name*='[scale_id]']").prop("name", new_name.replace('scale_description', 'scale_id'));
                });

                // Remove the scale
                $(this).parent().remove();
            });

            // Hide the extra options if the evaluation type is industrial evaluation
            $('#evaluation-type').change(function(e) {
                e.preventDefault();
                var evaluation_type = $(this).val();

                if(evaluation_type == "industrial-evaluation") {
                    $('#extra_options').hide();
                } else {
                    $('#extra_options').show();
                }
            });

            // Validate the total weightage == 100 when submitting form
            $('form').on('submit', function(e) {
                // Check if total weightage == 100
                var total_weightage = 0;
                $('input[name*="sub_criteria_weightage"]').each(function() {
                    total_weightage += parseInt($(this).val());
                });
                if(total_weightage != 100) {
                    alert("Total weightage must be 100.");
                }

                // Check if the number of scales is same for all sub criteria
                var number_of_scales = 0;
                $('input[name*="sub_criteria_name"]').each(function() {
                    var scales = 0;
                    $(this).parent().parent().parent().parent().find('input[name*="scale_description"]').each(function() {
                        scales++;
                    });
                    if(number_of_scales == 0) {
                        number_of_scales = scales;
                    }
                    if(scales != number_of_scales) {
                        alert("Number of scales must be same for all sub criteria.");
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
</x-app-layout>