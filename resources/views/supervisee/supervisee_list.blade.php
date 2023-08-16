<x-app-layout>
    <x-slot name="header">
        {{ __('Supervisee List') }}
    </x-slot>
    <div class="px-8">
        <x-show-table :headers="['Name', 'PSM', 'Project Title', 'Course']">
            <tbody class="flex flex-col w-full" style="height: 60vh;">
                @foreach ($supervisees as $i => $supervisee)
                    <tr class="flex mx-8 mt-2">
                        <td class="mx-4 py-2 text-gray text-sm font-semibold w-4">{{ $i+1 }}.</td>
                        <td class="py-2 text-gray text-sm font-semibold text-left w-1/4">{{ $supervisee->name }}</td>
                        <td class="py-2 text-gray text-sm font-semibold text-left w-1/4">PSM {{ $supervisee->psm_year }}</td>
                        <td class="py-2 text-gray text-sm font-semibold text-left w-1/4">{{ $supervisee->project_title }}</td>
                        <td class="py-2 text-gray text-sm font-semibold text-left w-1/4">{{ $supervisee->course }}</td>
                    </tr>
                @endforeach
            </tbody>
        </x-show-table>
        <div class="my-4">
            {{ $supervisees->links() }}
        </div>
    </div>
</x-app-layout>