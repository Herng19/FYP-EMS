<x-app-layout>
    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>
    <div class="mx-20 grid grid-cols-2 gap-20">
        {{-- Evaluation Schedule --}}
        <div class="bg-primary-700 rounded-lg py-4 px-8 drop-shadow-[0px_1px_18px_rgba(0,160,161,0.5)]">
            <div class="flex justify-between items-center">
                <div class="text-white font-bold text-lg">
                    Evaluation Schedule
                </div>
                <a href="/evaluation schedule/student-schedule" class="text-white text-sm font-semibold">
                    View
                </a>
            </div>
            <div class="py-8 px-4">
                <div class="mt-4 flex items-center">
                    <i class="fa-regular fa-calendar-minus text-primary-700 p-4 bg-primary-100 rounded-full h-12 w-12"></i>
                    @if(null != $student->slot)
                    <div class="ml-4 items-center">
                        <div class="text-primary-100 text-xs font-semibold">
                            {{ strtoupper(date("d M Y", strtotime($student->slot->start_time))), strtoupper(date("l", strtotime($student->slot->start_time))) }}
                        </div>
                        <div class="text-md font-bold text-white">
                            {{(date("H:i", strtotime($student->slot->start_time)))}} - {{(date("H:i", strtotime($student->slot->end_time)))}}
                        </div>
                    </div>
                    @else
                    <div class="text-primary-100 ml-4">No Slot</div>
                    @endif
                </div>
                <div class="mt-4 flex items-center">
                    <i class="fa-regular fa-location-dot text-primary-700 p-4 bg-primary-100 rounded-full h-12 w-12 text-center "></i>
                    @if($student->slot != null)
                    <div class="ml-4 items-center">
                        <div class="text-primary-100 text-xs font-semibold">
                            {{ ($student->psm_year == 1)? $student->slot->venues->venue_name : $student->slot->booths->booth_name; }}
                        </div>
                        <div class="text-md font-bold text-white">
                            {{ ($student->psm_year == 1)? $student->slot->venues->venue_code : $student->slot->booths->booth_code; }}
                        </div>
                    </div>
                    @else
                    <div class="text-primary-100 ml-4">No Slot</div>
                    @endif
                </div>
            </div>
        </div>
        {{-- Project Information --}}
        <div class="rounded-lg py-4 px-8 shadow-md bg-white">
            <div class="flex justify-between items-center">
                <div class="font-bold text-lg text-gray">
                    Project
                </div>
                <a href="/fyp" class="text-sm text-primary-700 font-semibold">
                    Edit
                </a>
            </div>
            <div class="py-8 px-4">
                <div class="flex">
                    <div class="text-md font-bold text-primary-700">
                        {{ $student->project->project_title }}
                    </div>
                </div>
                <div class="mt-4 h-20 overflow-hidden">
                    <div class="text-sm font-normal text-gray-400 text-justify">
                        {{ $student->project->project_description}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-12 mx-20 shadow-md bg-white rounded-lg p-8">
        <div class="flex justify-between items-center">
            <div class="font-bold text-lg text-gray-700">
                Overall Rubric
            </div>
            <a href="/rubric/student-rubric" class="text-sm text-primary-700 font-semibold">
                View
            </a>
        </div>
        <div class="flex mx-8 mt-4 justify-between">
            <div class="font-semibold">First Evaluation (By SV)</div>
            <div class="text-primary-700 font-bold">30%</div>
        </div>
        <div class="flex mx-8 mt-4 justify-between">
            <div class="font-semibold">Presentation Evaluation (By 2 Evaluators)</div>
            <div class="text-primary-700 font-bold">40%</div>
        </div>
        <div class="flex mx-8 mt-4 justify-between">
            <div class="font-semibold">Second Evaluation (By SV)</div>
            <div class="text-primary-700 font-bold">30%</div>
        </div>
        <hr class="mt-4"/>
        <div class="flex mx-8 mt-4 justify-between">
            <div class="font-semibold">Total</div>
            <div class="text-primary-700 font-bold">100%</div>
        </div>
    </div>
</x-app-layout>