<x-app-layout>
    <x-slot name="header">
        <a href="/industrial evaluator"><i class="fa-regular fa-chevron-left fa-sm"></i></a>
        Edit Industrial Evaluator
    </x-slot>

    <x-success=message />
    <div class="mt-2 mb-4 mx-12">
        <div class="flex font-bold">
            <div>Evaluator's Information</div>
        </div>
        <div class="mt-2 mx-4">
            <form action="/industrial evaluator/edit/{{ $industrial_evaluator->industrial_evaluator_id }}" method="POST">
                @csrf
                @method('put')
                <div class="flex flex-col mt-2">
                    <label for="evaluator_name" class="font-semibold text-sm text-gray mb-2">Evaluator's Name</label>
                    <x-input name="evaluator_name" type="text" placeholder="Evaluator's Name" value="{{ $industrial_evaluator->evaluator_name }}"/>
                    @error('evaluator_name')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="flex flex-col mt-2">
                    <label for="company" class="font-semibold text-sm text-gray mb-2">Company</label>
                    <x-input name="company" type="text" placeholder="Company" value="{{ $industrial_evaluator->company }}"/>
                    @error('company')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="flex flex-col mt-2">
                    <label for="position" class="font-semibold text-sm text-gray mb-2">Position</label>
                    <x-input name="position" type="text" placeholder="Position" value="{{ $industrial_evaluator->position }}"/>
                    @error('position')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <x-button type="submit" class="mt-4">Update</x-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>