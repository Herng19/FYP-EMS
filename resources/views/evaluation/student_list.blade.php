<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Evaluation') }}
        </h2>
    </x-slot>

    <x-error-message/>
    <x-success-message/>

    <div class="px-8">
        {{-- Student List --}}
        <x-show-table :headers="['Name', 'PSM', 'Project Title', 'Marks', 'Action']">
            <tbody class="flex flex-col w-full" style="min-height: 70vh;">
                @foreach ($evaluatees as $i => $evaluatee)
                    <tr class="flex px-8 py-2 items-center {{ ($i%2 == 0)? 'bg-primary-50' : '';}}">
                        <td class="mx-4 py-2 text-gray text-sm font-semibold w-4">{{ $i+1 }}.</td>
                        <td class="py-2 text-gray text-sm font-semibold text-left w-1/4">{{ $evaluatee->name }}</td>
                        <td class="py-2 text-gray text-sm font-semibold text-left w-1/4">PSM {{ $evaluatee->psm_year }}</td>
                        <td class="py-2 text-gray text-sm font-semibold text-left w-1/4">{{ $evaluatee->project_title }}</td>
                        <td class="py-2 text-gray-400 text-sm font-semibold text-left w-1/4">{{ (array_key_exists($evaluatee->student_id, $total_marks))? $total_marks[$evaluatee->student_id] : "0" }}/100</td>
                        <td class="py-2 text-gray text-sm font-semibold text-center w-1/4">
                            <a href="/evaluation/{{ $evaluatee->student_id}}" class="rounded-full px-3 py-3 text-primary-700 hover:bg-primary-100">
                                <i class="fa-regular fa-pen text-inherit fa-lg"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </x-show-table>
        <div class="my-4">
            {{ $evaluatees->links() }}
        </div>
    </div>
</x-app-layout>