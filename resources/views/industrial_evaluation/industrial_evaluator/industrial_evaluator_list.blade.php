<x-app-layout>
    <x-slot name="header">
        Industrial Evaluator List
    </x-slot>

    <x-success-message />

    <div class="mt-2 mb-4 mx-12">
        <div class="flex justify-end items-center">
            <a href="/industrial evaluator/create"><x-button><i class="fa-regular fa-plus mr-2"></i>new evaluator</x-button></a>
        </div>
        <x-show-table :headers="['Name', 'Company', 'Position', 'Action']">
            <tbody class="flex flex-col w-full" style="min-height: 60vh;">
                {{-- Normal Rubrics --}}
                @foreach ($industrial_evaluators as $i => $industrial_evaluator)
                    <tr class="flex px-8 py-2 items-center {{ ($i%2 == 0)? 'bg-primary-50' : '';}}">
                        <td class="mx-4 py-2 text-gray text-sm font-semibold w-4">{{ $loop->iteration }}.</td>
                        <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $industrial_evaluator->evaluator_name }}</td>
                        <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $industrial_evaluator->company }}</td>
                        <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $industrial_evaluator->position }}</td>
                        <td class="flex py-2 items-center justify-center w-1/3">
                            <a href="/industrial evaluator/edit/{{ $industrial_evaluator->industrial_evaluator_id }}" class="rounded-full py-2 px-3 bg-green-100 justify-center items-center hover:bg-green-200">
                                <i class="fa-regular fa-pen text-green-500 fa-sm"></i>
                            </a>
                            <button type="button" data-modal-target="popup-modal-[{{ $i }}]" data-modal-toggle="popup-modal-[{{ $i }}]" class="rounded-full py-2 px-3 bg-red-50 justify-center items-center hover:bg-red-100 ml-2"><i class="fa-regular fa-trash-can text-red-500 fa-sm"></i></button>
                        </td>
                    </tr>
                    <x-delete-confirmation-modal route="/industrial evaluator/delete/{{ $industrial_evaluator->industrial_evaluator_id }}" title="Delete Evaluator" description="Are you sure to delete '{{ $industrial_evaluator->evaluator_name }}' ?" id="{{ $i }}"/>
                @endforeach
            </tbody>
        </x-show-table>
    </div>
</x-app-layout>