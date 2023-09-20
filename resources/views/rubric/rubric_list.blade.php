<x-app-layout>
    <x-slot name="header">
        Rubric
    </x-slot>
    <div class="mt-4 px-12">
        <div class="flex justify-end">
            <a href="/rubric/create-rubric"><x-button><i class="fa-regular fa-plus mr-2"></i>New Rubric</x-button></a>
        </div>
        <div class="mt-2">
            <x-show-table :headers="['Rubric', 'Evaluation', 'Research Group', 'Action']">
                <tbody class="flex flex-col w-full" style="height: 60vh;">
                    {{-- Normal Rubrics --}}
                    @foreach ($rubrics as $i => $rubric)
                        <tr class="flex mx-8 mt-2">
                            <td class="mx-4 py-2 text-gray text-sm font-semibold w-4">{{ $i+1 }}.</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/4">{{ $rubric->name }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/4">Normal Evaluation</td>
                            <td class="py-2 text-primary-700 text-sm font-bold text-left w-1/4">{{ $rubric->research_group }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-center w-1/4">
                                <a href="/rubric/edit/{{ $rubric->rubric_id }}" class="rounded-full py-2 pl-2.5 pr-1.5 bg-green-100 justify-center items-center hover:bg-green-200">
                                    <i class="fa-regular fa-pen text-green-500"></i>
                                </a>
                                <a href="/rubric/delete/{{ $rubric->rubric_id }}" class="rounded-full py-2 px-3 bg-red-50 justify-center items-center hover:bg-red-100">
                                    <i class="fa-regular fa-trash-can text-red-500"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach

                    {{-- Industrial Rubrics --}}
                    @role('coordinator')
                    @foreach ($industrial_rubrics as $i => $rubric)
                        <tr class="flex mx-8 mt-2">
                            <td class="mx-4 py-2 text-gray text-sm font-semibold w-4">{{ $i+1 }}.</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/4">{{ $rubric->name }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/4">Industrial Evaluation</td>
                            <td class="py-2 text-primary-700 text-sm font-bold text-left w-1/4">{{ $rubric->research_group }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-center w-1/4">
                                <a href="/rubric/edit/{{ $rubric->rubric_id }}" class="rounded-full py-2 pl-2.5 pr-1.5 bg-green-100 justify-center items-center hover:bg-green-200">
                                    <i class="fa-regular fa-pen text-green-500"></i>
                                </a>
                                <a href="/rubric/delete/{{ $rubric->rubric_id }}" class="rounded-full py-2 px-3 bg-red-50 justify-center items-center hover:bg-red-100">
                                    <i class="fa-regular fa-trash-can text-red-500"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    @endrole
                </tbody>
            </x-show-table>
        </div>
    </div>
</x-app-layout>