<x-app-layout>
    <x-slot name="header">
        <a href="/rubric"><i class="fa-regular fa-chevron-left fa-xs"></i></a>
        {{ $rubric->rubric_name }}
    </x-slot>
    <div class="mt-4 px-8">
        {{-- Download rubric function --}}
        @hasanyrole('supervisor|evaluator|head of research group|coordinator')
        <div class="flex justify-end">
            <a href="/rubric/print/{{ $rubric->rubric_id }}" target="_blank"><x-button><i class="fa-regular fa-print mr-2"></i>Print</x-button></a>
        </div>
        @endhasanyrole
        
        {{-- Rubric Description --}}
        <table class="rounded-lg mt-4 bg-white drop-shadow-[0px_0px_12px_rgba(185,185,185,0.25)] w-full">
            <thead class="w-full">
                <tr class="flex self-stretch mx-8 mt-2 border-b">
                    <th class="my-4 text-primary-700 text-sm font-bold text-left w-1/4 text-center">Elements</th>
                    <th class="my-4 text-primary-700 text-sm font-bold w-1/4 text-center">CO</th>
                    <th class="my-4 text-primary-700 text-sm font-bold w-1/4 text-center">0</th>
                    <th class="my-4 text-primary-700 text-sm font-bold w-1/4 text-center">1</th>
                    <th class="my-4 text-primary-700 text-sm font-bold w-1/4 text-center">2</th>
                    <th class="my-4 text-primary-700 text-sm font-bold w-1/4 text-center">3</th>
                    <th class="my-4 text-primary-700 text-sm font-bold w-1/4 text-center">4</th>
                    <th class="my-4 text-primary-700 text-sm font-bold w-1/4 text-center">5</th>
                    <th class="my-4 text-primary-700 text-sm font-bold text-left w-1/4 text-center">Weightage</th>
                </tr>
            </thead>
            <tbody class="flex flex-col w-full" style="min-height: 65vh;">
                @foreach ($rubric->rubric_criterias as $i => $rubric_criteria)
                    <tr class="flex mx-8 mt-2 items-center">
                        <td class="py-2 text-gray text-sm font-bold text-left w-1/4 break-all">{{ $i+1 }} {{ $rubric_criteria->criteria_name }}</td>
                    </tr>
                    @foreach ($rubric_criteria->sub_criterias as $j => $sub_criteria)
                        <tr class="flex mx-8 mt-2 items-center">
                            <td class="py-2 text-gray text-xs font-semibold text-left w-1/4 pl-4 break-all">{{ $i+1 }}.{{ $j+1 }} {{ $sub_criteria->sub_criteria_name }}</td>
                            <td class="py-2 text-gray text-xs font-semibold text-center w-1/4 uppercase text-center break-all">{{ $sub_criteria->co_level }}</td>
                            @foreach ($sub_criteria->criteria_scales as $scale)
                                @if( $scale->scale_level == 2 || $scale->scale_level == 4 )
                                    <td class="py-2 text-gray-400 text-xs font-semibold text-center w-1/4 break-all">{{ $scale->scale_description }}</td>
                                @else
                                    <td class="py-2 text-gray text-xs font-semibold text-center w-1/4 break-all">{{ $scale->scale_description }}</td>
                                @endif
                            @endforeach
                            <td class="py-2 text-gray text-xs font-semibold text-center w-1/4 uppercase text-center break-all">{{ $sub_criteria->weightage }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>