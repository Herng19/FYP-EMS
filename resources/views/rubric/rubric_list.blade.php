<x-app-layout>
    <x-slot name="header">
        Rubric
    </x-slot>

    <x-success-message/>
    
    <div class="mt-4 px-12">
        <div class="flex justify-end">
            <a href="/rubric/create-rubric"><x-button><i class="fa-regular fa-plus mr-2"></i>New Rubric</x-button></a>
        </div>
        <div class="mt-2">
            <x-show-table :headers="['Rubric', 'Evaluation', 'Research Group', 'Action']">
                <tbody class="flex flex-col w-full" style="min-height: 60vh;">
                    {{-- Normal Rubrics --}}
                    @foreach ($rubrics as $i => $rubric)
                        <tr class="flex mx-8 mt-2 items-center">
                            <td class="mx-4 py-2 text-gray text-sm font-semibold w-4">{{ intval($i) +1 }}.</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/4">{{ $rubric->rubric_name }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/4">{{ ($rubric->psm_year == "1" || $rubric->psm_year == "2" )? "Normal Evaluation" : "Industrial Evaluation" }}</td>
                            <td class="py-2 text-gray-400 text-sm font-semibold text-left w-1/4">{{ $rubric->research_group_name }}</td>
                            <td class="flex py-2 items-center justify-center w-1/4">
                                <a href="/rubric/view/{{ $rubric->rubric_id }}" class="rounded-full py-2 px-3 bg-primary-100 justify-center items-center hover:bg-primary-200">
                                    <i class="fa-regular fa-eye text-primary-500"></i>
                                </a>
                                <a href="/rubric/edit/{{ $rubric->rubric_id }}" class="rounded-full py-2 px-3 bg-green-100 justify-center items-center hover:bg-green-200 ml-2">
                                    <i class="fa-regular fa-pen text-green-500"></i>
                                </a>
                                <form action="/rubric/delete/{{ $rubric->rubric_id}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-full py-2 px-3 bg-red-50 justify-center items-center hover:bg-red-100 ml-2"><i class="fa-regular fa-trash-can text-red-500"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </x-show-table>
            <div class="my-4">
                {{ $rubrics->links() }}
            </div>
        </div>
    </div>
</x-app-layout>