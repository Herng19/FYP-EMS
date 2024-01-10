<x-app-layout>
    <x-slot name="header">
        {{__('Student Schedule')}}
    </x-slot>
    <div class="mx-12">
        {{-- Normal Evaluation --}}
        <div class="justify-start px-4 py-4 shadow-md rounded-lg bg-white">
            @if(null != $student->slot)
            <div class="text-primary-700 font-bold text-xl">Evaluation 2</div>
            <div class="grid grid-cols-6 gap-4 ml-8 mt-4">
                <div class="inline-block text-gray-500 font-bold text-sm text-end">Evaluation Date : </div>
                <div class="inline-block col-span-5 text-gray font-bold text-sm">{{(date("d-m-Y", strtotime($student->slot->start_time)))}}</div>
            </div>
            <div class="grid grid-cols-6 gap-4 ml-8 mt-4">
                <div class="inline-block text-gray-500 font-bold text-sm text-end">Timeslot : </div>
                <div class="inline-block col-span-5 text-gray font-bold text-sm">{{(date("H:i", strtotime($student->slot->start_time)))}} - {{(date("H:i", strtotime($student->slot->end_time)))}}</div>
            </div>
            <div class="grid grid-cols-6 gap-4 ml-8 mt-4">
                <div class="inline-block text-gray-500 font-bold text-sm text-end">Venue : </div>
                <div class="inline-block col-span-5 text-gray font-bold text-sm">{{ ($student->psm_year == 1)? $student->slot->venues->venue_code : $student->slot->booths->booth_code }} {{ ($student->psm_year == 1)? $student->slot->venues->venue_name : $student->slot->booths->booth_name }}</div>
            </div>
            <div class="grid grid-cols-6 gap-4 ml-8 mt-4">
                <div class="inline-block text-gray-500 font-bold text-sm text-end">Evaluators : </div>
                @foreach($student->evaluators as $evaluator)
                    <div class="flex items-center col-span-5 text-gray font-bold text-sm">
                        <img class="h-8 w-8 rounded-full object-cover mr-2" src="{{ $evaluator->profile_photo_url }}" alt="{{ $evaluator->name }}" />
                        {{ $evaluator->name }}
                    </div>
                    <div class=""></div>
                @endforeach
            </div>
            @else
            <div class="font-semibold">No Slot Found</div>
            @endif
        </div>

        {{-- Industrial Evaluation --}}
        @if($industrial_evaluation !== null)
        <div class="justify-start px-4 py-4 shadow-md rounded-lg bg-white mt-4">
            <div class="text-primary-700 font-bold text-xl">Industrial Evaluation</div>
            <div class="grid grid-cols-6 gap-4 ml-8 mt-4">
                <div class="inline-block text-gray-500 font-bold text-sm text-end">Evaluation Date : </div>
                <div class="inline-block col-span-5 text-gray font-bold text-sm">{{(date("d-m-Y", strtotime($student->industrial_evaluation_slot->start_time)))}}</div>
            </div>
            <div class="grid grid-cols-6 gap-4 ml-8 mt-4">
                <div class="inline-block text-gray-500 font-bold text-sm text-end">Timeslot : </div>
                <div class="inline-block col-span-5 text-gray font-bold text-sm">{{(date("H:i", strtotime($student->industrial_evaluation_slot->start_time)))}} - {{(date("H:i", strtotime($student->industrial_evaluation_slot->end_time)))}}</div>
            </div>
            <div class="grid grid-cols-6 gap-4 ml-8 mt-4">
                <div class="inline-block text-gray-500 font-bold text-sm text-end">Venue : </div>
                <div class="inline-block col-span-5 text-gray font-bold text-sm">{{ $student->industrial_evaluation_slot->booths->booth_code }} {{ $student->slot->booths->booth_name }}</div>
            </div>
            <div class="grid grid-cols-6 gap-4 ml-8 mt-4">
                <div class="inline-block text-gray-500 font-bold text-sm text-end">Evaluators : </div>
                @foreach($industrial_evaluators as $evaluator)
                    <div class="flex items-center col-span-5 text-gray font-bold text-sm">
                        {{ $evaluator->evaluator_name }}
                    </div>
                    <div class=""></div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Precaution --}}
        <div class="my-8">
            <div class="flex items-center justify-start">
                <i class="fa-regular fa-triangle-exclamation text-primary-700 font-bold"></i>
                <div class="text-primary-700 font-bold ml-2">Precaution</div>
            </div>
            <ul class="list-disc ml-8 mt-2">
                <li class="text-gray-500 font-semibold text-sm">Please wear formal attire for presentation.</li>
                <li class="text-gray-500 font-semibold text-sm">Be prepared at the location 5 minutes before the presentation start. </li>
                <li class="text-gray-500 font-semibold text-sm">Bring your own laptop/ Use desktop in lab. </li>
                <li class="text-gray-500 font-semibold text-sm">Be polite to your evaluator. </li>
            </ul>
        </div>
    </div>
</x-app-layout>