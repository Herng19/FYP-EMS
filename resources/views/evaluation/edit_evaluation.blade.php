<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Evaluate Student') }}
        </h2>
    </x-slot>
    <div class="px-8">
        {{-- Student Description --}}
        <div class="text-2xl font-bold text-primary-700">{{ $student->name }} - PSM{{ $student->psm_year }}</div>

        {{-- Project Description --}}
        <div class="my-4">
            <div class="text-md font-bold">{{ $student->project->project_title }}</div>
            <div class="text-sm text-gray-400 mt-2">{{ $student->project->project_description }}</div>
        </div>

        {{-- Seperation Line --}}
        <hr/>

        {{-- Evaluation Criteria --}}
        <div class="py-2">
            <form action="/evaluation/{{$student->student_id}}" method="POST">
                <div class="mt-4">
                    <div class="font-bold">Criteria 1</div>
                    <div class="flex px-8 mt-2 justify-between items-center">
                        <div class="text-sm font-semibold text-gray-400">sub-criteria 1</div>
                        <div class="text-sm font-semibold text-gray-400">20%</div>
                        <div>
                            <select id="sub-criteria 1" name="sub-criteria 1" class="block text-sm font-semibold mt-1 w-full px-4 py-2 border-0 rounded-md drop-shadow" required>
                                <option value="1" class="text-gray-400 font-semibold" >1</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex px-8 mt-2 justify-between items-center">
                        <div class="text-sm font-semibold text-gray-400">sub-criteria 2</div>
                        <div class="text-sm font-semibold text-gray-400">30%</div>
                        <div>
                            <select id="sub-criteria 1" name="sub-criteria 1" class="block text-sm font-semibold mt-1 w-full px-4 py-2 border-0 rounded-md drop-shadow" required>
                                <option value="1" class="text-gray-400 font-semibold" >1</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="font-bold">Criteria 2</div>
                    <div class="flex px-8 mt-2 justify-between items-center">
                        <div class="text-sm font-semibold text-gray-400">sub-criteria 1</div>
                        <div class="text-sm font-semibold text-gray-400">20%</div>
                        <div>
                            <select id="sub-criteria 1" name="sub-criteria 1" class="block text-sm font-semibold mt-1 w-full px-4 py-2 border-0 rounded-md drop-shadow" required>
                                <option value="1" class="text-gray-400 font-semibold" >1</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex justify-end mt-8 mx-8">
                    <a href="/evaluation"><x-secondary-button class="mr-2">Cancel</x-secondary-button></a>
                    <x-button>Save</x-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>