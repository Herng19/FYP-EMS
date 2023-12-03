<x-app-layout>
    <x-slot name="header">
        Rubric
    </x-slot>

    <x-success-message/>
    
    <div class="px-12">
        @hasanyrole('head of research group|coordinator')
        <div class="flex justify-end">
            <a href="/rubric/create-rubric"><x-button><i class="fa-regular fa-plus mr-2"></i>New Rubric</x-button></a>
        </div>
        @endhasanyrole
        <div class="mt-2">
            <x-show-table :headers="['Rubric', 'Evaluation', 'Research Group', 'Action']">
                <tbody class="flex flex-col w-full" style="min-height: 60vh;">
                    {{-- Normal Rubrics --}}
                    @foreach ($rubrics as $i => $rubric)
                        <tr class="flex px-8 py-2 items-center {{ ($i%2 == 0)? 'bg-primary-50' : '';}}">
                            <td class="mx-4 py-2 text-gray text-sm font-semibold w-4">{{ intval($i) +1 }}.</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/4">{{ $rubric->rubric_name }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/4">Evaluation {{ $rubric->evaluation_type[-1] }}</td>
                            <td class="py-2 text-primary-300 text-sm font-semibold text-left w-1/4">{{ $rubric->research_group->research_group_name }} ({{ $rubric->research_group->research_group_short_form }})</td>
                            <td class="flex py-2 items-center justify-center w-1/4">
                                <a href={{ (auth()->user()->hasrole('student'))? "/rubric/student-rubric/view/$rubric->rubric_id" : "/rubric/view/$rubric->rubric_id" }} class="rounded-full py-2 px-3 bg-blue-100 border border-blue-200 justify-center items-center hover:bg-blue-200">
                                    <i class="fa-regular fa-eye text-blue-500 fa-sm"></i>
                                </a>
                                @hasanyrole('head of research group|coordinator')
                                <a href="/rubric/edit/{{ $rubric->rubric_id }}" class="rounded-full py-2 px-3 bg-green-100 border border-green-200 justify-center items-center hover:bg-green-200 ml-2">
                                    <i class="fa-regular fa-pen text-green-500 fa-sm"></i>
                                </a>
                                <button type="button" data-modal-target="popup-modal-[{{ $i }}]" data-modal-toggle="popup-modal-[{{ $i }}]" class="rounded-full py-2 px-3 bg-red-50 border border-red-200 justify-center items-center hover:bg-red-100 ml-2"><i class="fa-regular fa-trash-can text-red-500 fa-sm"></i></button>
                                @endhasanyrole
                            </td>
                        </tr>
                        <x-delete-confirmation-modal route="/rubric/delete/{{ $rubric->rubric_id }}" title="Delete Rubric" description="Are you sure to delete '{{ $rubric->rubric_name }}' ? ***Deletion of this rubric will cause deletion of evaluation record associate with this rubric too." id="{{ $i }}"/>
                    @endforeach
                </tbody>
            </x-show-table>
            <div class="my-4">
                {{ $rubrics->links() }}
            </div>
        </div>
    </div>
</x-app-layout>