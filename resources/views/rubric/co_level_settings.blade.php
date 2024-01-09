<x-app-layout>
    <x-slot name="header">
        CO Level Settings
    </x-slot>

    <x-success-message/>
    
    <div class="px-12">
        <div class="flex justify-between">
            <a href="/rubric" class="font-semibold text-primary-700 text-lg"><i class="fa-regular fa-chevron-left mr-2"></i> BACK</a>
            <a href="/rubric/create-co-level"><x-button><i class="fa-regular fa-plus mr-2"></i>New CO Level</x-button></a>
        </div>
        <div class="mt-2">
            <x-show-table :headers="['CO Level', 'CO Level Description', 'Action']">
                <tbody class="flex flex-col w-full" style="min-height:70vh;">
                    {{-- Normal Rubrics --}}
                    @foreach ($co_levels as $i => $co_level)
                        <tr class="flex px-8 py-2 items-center {{ ($i%2 == 0)? 'bg-primary-50' : '';}}">
                            <td class="mx-4 py-2 text-gray text-sm font-semibold w-4">{{ intval($i) +1 }}.</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $co_level->co_level_name }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $co_level->co_level_description }}</td>
                            <td class="flex py-2 items-center justify-center w-1/3">
                                <a href="/rubric/edit-co-level/{{ $co_level->co_level_id }}" class="rounded-full py-2 px-3 bg-green-100 border border-green-200 justify-center items-center hover:bg-green-200 ml-2">
                                    <i class="fa-regular fa-pen text-green-500 fa-sm"></i>
                                </a>
                                <button type="button" data-modal-target="popup-modal-[{{ $i }}]" data-modal-toggle="popup-modal-[{{ $i }}]" class="rounded-full py-2 px-3 bg-red-50 border border-red-200 justify-center items-center hover:bg-red-100 ml-2"><i class="fa-regular fa-trash-can text-red-500 fa-sm"></i></button>
                            </td>
                        </tr>
                        <x-delete-confirmation-modal route="/rubric/delete-co-level/{{ $co_level->co_level_id }}" title="Delete CO LEVEL" description="Are you sure to delete '{{ $co_level->co_level_name }}' ?" id="{{ $i }}"/>
                    @endforeach
                </tbody>
            </x-show-table>
            <div class="my-4">
                {{ $co_levels->links() }}
            </div>
        </div>
    </div>
</x-app-layout>