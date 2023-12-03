<x-app-layout>
    <x-slot name="header">
    </x-slot>
    <div class="mb-4 px-8">
        <a href={{ (auth('student')->check())? "/rubric/student-rubric" : "/rubric" }} class="font-semibold text-primary-700 text-lg"><i class="fa-regular fa-chevron-left mr-2"></i>{{ $rubric->rubric_name }}</a>
        {{-- Download rubric function --}}
        @hasanyrole('supervisor|evaluator|head of research group|coordinator')
        <div class="flex justify-end">
            <a href="/rubric/print/{{ $rubric->rubric_id }}" target="_blank"><x-button><i class="fa-regular fa-print mr-2"></i>Print</x-button></a>
        </div>
        @endhasanyrole
        
        {{-- Rubric Description --}}
        <table class="rounded-lg mt-4 bg-white drop-shadow-[0px_0px_12px_rgba(185,185,185,0.25)] w-full">
            <thead class="w-full">
                <tr class="flex self-stretch px-8 pt-2 border-b-2 border-b-primary-200">
                    <th class="my-4 text-primary-700 text-sm font-bold text-left w-1/4 text-center">Elements</th>
                    <th class="my-4 text-primary-700 text-sm font-bold w-1/4 text-center">CO</th>
                    @for($i = 0; $i < $scale_num; $i++)
                        <th class="my-4 text-primary-700 text-sm font-bold w-1/4 text-center">{{ $i }}</th>
                    @endfor
                    <th class="my-4 text-primary-700 text-sm font-bold text-left w-1/4 text-center">Weightage</th>
                </tr>
            </thead>
            <tbody class="flex flex-col w-full" style="min-height: 65vh;">
                @foreach ($rubric->rubric_criterias as $i => $rubric_criteria)
                    <tr class="flex px-8 py-2 items-center">
                        <td class="py-2 text-gray text-sm font-bold text-left w-1/4 break-all">{{ $i+1 }} {{ $rubric_criteria->criteria_name }}</td>
                    </tr>
                    @foreach ($rubric_criteria->sub_criterias as $j => $sub_criteria)
                        <tr class="flex px-8 pt-2 items-center {{ ($j%2 == 0)? 'bg-primary-50' : '';}}">
                            <td class="py-2 text-gray text-xs font-semibold text-left w-1/4 pl-4 break-all">{{ $i+1 }}.{{ $j+1 }} {{ $sub_criteria->sub_criteria_name }}</td>
                            <td class="py-2 text-gray text-xs font-semibold text-center w-1/4 uppercase text-center break-all">{{ $sub_criteria->co_level }}</td>
                            @foreach ($sub_criteria->criteria_scales as $scale)
                                @if( $scale->scale_level % 2 == 1 )
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