<x-app-layout>
    <x-slot name="header">
        Create Rubric
    </x-slot>
    <div class="my-4 px-8">
        <form action="/rubric/create-rubric" method="POST">
            @csrf
            <div>
                {{-- Rubric Basic Info --}}
                <div class="font-bold text-gray">Rubric Info</div>
                <div class="px-4 mt-2">
                    <x-input id="rubric-name" class="block text-sm mt-1 w-full pl-4" type="text" name="rubric_name" placeholder="Rubric Name" value="{{ old('rubric_name')}}" required/>
                    <div class="flex grid grid-cols-3 gap-4 mt-2">
                        <div>
                            <select id="research-group" name="research_group" class="block text-sm font-semibold mt-1 w-full bg-primary-100 text-primary-300 px-4 py-2 border-0 rounded-md" required>
                                <option value="" class="text-primary-700 font-semibold" default>Reseach Group</option>
                                @foreach ($research_groups as $research_group)
                                    @if($research_group->research_group_id == old('research_group'))
                                        <option value="{{ $research_group->research_group_id }}" class="text-primary-700 font-semibold" selected>{{ $research_group->research_group_name }} ({{ $research_group->research_group_short_form }} )</option>
                                    @else
                                        <option value="{{ $research_group->research_group_id }}" class="text-primary-700 font-semibold">{{ $research_group->research_group_name }} ({{ $research_group->research_group_short_form }} )</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <select id="evaluation-number" name="evaluation_number" class="block text-sm font-semibold mt-1 w-full bg-primary-100 text-primary-300 px-4 py-2 border-0 rounded-md" required>
                                <option value="evaluation1" class="text-primary-700 font-semibold" @if(old('evaluation_number') == "evaluation1") selected @endif>Evaluation 1 (by supervisor)</option>
                                <option value="evaluation2" class="text-primary-700 font-semibold" @if(old('evaluation_number') == "evaluation2") selected @endif>Evaluation 2 (by evaluators)</option>
                                <option value="evaluation3" class="text-primary-700 font-semibold" @if(old('evaluation_number') == "evaluation3") selected @endif>Evaluation 3 (by supervisor)</option>
                            </select>
                        </div>
                        <div>
                            <select id="PSM" name="PSM" class="block text-sm font-semibold mt-1 w-full bg-primary-100 text-primary-300 px-4 py-2 border-0 rounded-md" required>
                                <option value="1" class="text-primary-700 font-semibold" @if(old('PSM') == "1") selected @endif>PSM 1</option>
                                <option value="2" class="text-primary-700 font-semibold" @if(old('PSM') == "2") selected @endif>PSM 2</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mt-6 mx-4" id="criteria-form">
                    {{-- Rubric Elements --}}
                    <div class="font-bold text-gray text-sm">Elements</div>
                    {{-- Main Criteria --}}
                    <div class="mt-4 px-4" id="criteria-0">
                        <div class="flex items-center">
                            <label id="main-numbering" class="mr-2 text-gray-500 text-sm font-semibold">1</label>
                            <x-input id="criteria-name" class="block text-sm mt-1 w-full pl-4" type="text" name="criteria[0][criteria_name]" value="{{ old('criteria[0][criteria_name]')}}" placeholder="Criteria Name" required/>
                            <button type="button" class="delete-criteria ml-2 py-2 px-3 bg-red-50 rounded-full hover:bg-red-100"><i class="fa-regular fa-trash-can text-red-500"></i></button>
                        </div>
                        {{-- Sub Criteria --}}
                        <div class="px-8 mt-2" id="criteria-0-0">
                            <div class="flex">
                                <div class="grid grid-cols-5 gap-2 w-full">
                                    <div class="col-span-3 flex items-center">
                                        <label id="sub-numbering" class="mr-2 text-gray-500 text-sm font-semibold">1.1</label>
                                        <x-input id="sub-criteria-name" class="block text-sm mt-1 w-full pl-4" type="text" name="criteria[0][0][sub_criteria_name]" value="{{ old('criteria[0][0][sub_criteria_name]')}}" placeholder="Sub Criteria Name" required/>    
                                    </div>
                                    <div>
                                        <x-input id="sub-criteria-weightage" class="block text-sm mt-1 w-full pl-4" type="number" name="criteria[0][0][sub_criteria_weightage]" value="{{ old('criteria[0][0][sub_criteria_weightage]')}}" placeholder="Weightage(%)" min='1' max='100' required/>
                                    </div>
                                    <div>
                                        <select id="sub-criteria-co-level" name="criteria[0][0][sub_criteria_co_level]" class="block text-sm font-semibold mt-1 w-full bg-primary-100 text-primary-300 px-4 py-2 border-0 rounded-md" required>
                                            <option value="co-1" class="text-primary-700 font-semibold" @if(old('criteria[0][0][sub_criteria_co_level]') == "co-1") selected @endif>CO 1</option>
                                            <option value="co-2" class="text-primary-700 font-semibold" @if(old('criteria[0][0][sub_criteria_co_level]') == "co-2") selected @endif>CO 2</option>
                                            <option value="co-3" class="text-primary-700 font-semibold" @if(old('criteria[0][0][sub_criteria_co_level]') == "co-3") selected @endif>CO 3</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="button" class="delete-sub-criteria ml-2 my-1 py-2 px-3 bg-red-50 rounded-full hover:bg-red-100"><i class="fa-regular fa-trash-can text-red-500"></i></button>
                            </div>
                            <div class="mt-2 pl-6 pr-12">
                                <x-input id="sub-criteria-description" class="block text-sm mt-1 w-full pl-4" type="text" name="criteria[0][0][sub_criteria_description]" value="{{ old('criteria[0][0][sub_criteria_description]')}}" placeholder="Sub Criteria Description" required/>
                            </div>

                            {{-- Description for each level --}}
                            <div class="px-12">
                                <div class="flex items-center mt-2">
                                    <label for="scale-0" class="mx-2 text-gray-400" id="scale-numbering">0</label>
                                    <x-input id="scale-0" class="block text-sm mt-1 w-full pl-4" type="text" name="criteria[0][0][scale_0]" value="{{ old('criteria[0][0][scale_0]')}}" placeholder="Mark Description" required/>
                                    <button type="button" class="delete-scale mx-2"><i class="fa-regular fa-trash-can text-red-500"></i></button>
                                </div>
                                <div class="flex items-center mt-2">
                                    <label for="scale-1" class="mx-2 text-gray-400" id="scale-numbering">1</label>
                                    <x-input id="scale-1" class="block text-sm mt-1 w-full pl-4" type="text" name="criteria[0][0][scale_1]" value="{{ old('criteria[0][0][scale_1]')}}" placeholder="Mark Description" required/>
                                    <button type="button" class="delete-scale mx-2"><i class="fa-regular fa-trash-can text-red-500"></i></button>
                                </div>
                                <div class="flex items-center mt-2">
                                    <label for="scale-2" class="mx-2 text-gray-400" id="scale-numbering">2</label>
                                    <x-input id="scale-2" class="block text-sm mt-1 w-full pl-4" type="text" name="criteria[0][0][scale_2]" value="{{ old('criteria[0][0][scale_2]')}}" placeholder="Mark Description" required/>
                                    <button type="button" class="delete-scale mx-2"><i class="fa-regular fa-trash-can text-red-500"></i></button>
                                </div>
                                <div class="flex items-center mt-2">
                                    <label for="scale-3" class="mx-2 text-gray-400" id="scale-numbering">3</label>
                                    <x-input id="scale-3" class="block text-sm mt-1 w-full pl-4" type="text" name="criteria[0][0][scale_3]" value="{{ old('criteria[0][0][scale_3]')}}" placeholder="Mark Description" required/>
                                    <button type="button" class="delete-scale mx-2"><i class="fa-regular fa-trash-can text-red-500"></i></button>
                                </div>
                                <div class="flex items-center mt-2">
                                    <label for="scale-4" class="mx-2 text-gray-400" id="scale-numbering">4</label>
                                    <x-input id="scale-4" class="block text-sm mt-1 w-full pl-4" type="text" name="criteria[0][0][scale_4]" value="{{ old('criteria[0][0][scale_4]')}}" placeholder="Mark Description" required/>
                                    <button type="button" class="delete-scale mx-2"><i class="fa-regular fa-trash-can text-red-500"></i></button>
                                </div>
                                <div class="flex items-center mt-2">
                                    <label for="scale-5" class="mx-2 text-gray-400" id="scale-numbering">5</label>
                                    <x-input id="scale-5" class="block text-sm mt-1 w-full pl-4" type="text" name="criteria[0][0][scale_5]" value="{{ old('criteria[0][0][scale_5]')}}" placeholder="Mark Description" required/>
                                    <button type="button" class="delete-scale mx-2"><i class="fa-regular fa-trash-can text-red-500"></i></button>
                                </div>
                                {{-- Add New Scale Button --}}
                                <div class="mt-4 ml-8">
                                    <button type="button" class="add-scale-button text-primary-700 font-bold text-[11px] border-gray-200 border-2 rounded-md px-3 py-2 hover:bg-gray-100"><i class="fa-regular fa-circle-plus fa-lg mr-2"></i>ADD SCALE</button>
                                </div>
                            </div>
                        </div>
                        {{-- Add New Sub Criteria Button --}}
                        <div class="mt-4 ml-16">
                            <button type="button" class="add-sub-criteria-button text-primary-700 font-bold text-[11px] border-gray-200 border-2 rounded-md px-3 py-2 hover:bg-gray-100"><i class="fa-regular fa-circle-plus fa-lg mr-2"></i>ADD SUB CRITERIA</button>
                        </div>
                    </div>
                    {{-- Add New Criteria Button --}}
                    <div class="mt-4 ml-8">
                        <button type="button" class="add-criteria-button text-primary-700 font-bold text-[11px] border-gray-200 border-2 rounded-md px-3 py-2 hover:bg-gray-100"><i class="fa-regular fa-circle-plus fa-lg mr-2"></i>ADD CRITERIA</button>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex justify-end mt-8 mx-8">
                <a href="/rubric"><x-secondary-button class="mr-2">Cancel</x-secondary-button></a>
                <x-button>Create</x-button>
            </div>
        </form>
    </div>

    {{-- JQuery --}}
    <script>
        $(document).ready(function() {
            // Add new sub criteria
            $('#criteria-form').on('click', '.add-sub-criteria-button', function(e) {
                e.preventDefault();

                // Clone the last sub criteria
                var new_element = $(this).parent().prev().clone();

                // Clear all the input except for "<in between>"
                new_element.find("input").each(function() {
                    $(this).val("");
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
                    $(this).val("");
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

                // Clear all input
                new_element.find("input").val("");

                // Update the numbering of the scale
                var main_number = new_element.find("#scale-numbering").text(parseInt(new_element.find("#scale-numbering").text()) + 1);

                // Update the id of the criteria
                var name = new_element.find("input").prop("name");
                var index = name.indexOf("_");
                var end_index = name.indexOf("]", index);
                var new_name = name.substring(0, index+1) + (parseInt(name.substring(index+1, end_index)) + 1) + name.substring(end_index);
                new_element.find("input").prop("name", new_name);

                // Append the new criteria
                $(this).parent().before(new_element);
            });

            // Delete the criteria
            $('#criteria-form').on('click', '.delete-criteria', function(e) {
                e.preventDefault();

                // Check if there is only one criteria left, if yes, do not allow deletion
                if($(this).parent().parent().parent().children().length <= 3) {
                    alert("A rubric must have at least one criteria.");
                    return;
                }

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
                // Check if there is only one sub criteria left, if yes, do not allow deletion
                if($(this).parent().parent().parent().children().length <= 3) {
                    alert("A criteria must have at least one sub criteria.");
                    return;
                }

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

                // Update the numbering of the scale
                $(this).parent().nextAll("div:not(:last)").each(function() {
                    var sub_number = $(this).find("#scale-numbering").text();
                    
                    $(this).find("#scale-numbering").text(sub_number - 1);

                    var name = $(this).find("input").prop("name");
                    var index = name.indexOf("_");
                    var end_index = name.indexOf("]", index);
                    var new_name = name.substring(0, index+1) + (parseInt(name.substring(index+1, end_index)) - 1) + name.substring(end_index);
                    $(this).find("input").prop("name", new_name);
                });

                // Remove the scale
                $(this).parent().remove();
            });
        });
    </script>
</x-app-layout>