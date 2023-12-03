<x-app-layout>
    <x-slot name="header">
        <a href="/industrial evaluator"><i class="fa-regular fa-chevron-left fa-sm"></i></a>
        Add Industrial Evaluator
    </x-slot>

    <div class="mt-2 mb-4 mx-12 bg-white rounded-md py-6 px-8">
        <div class="flex items-center">
            <i class="fa-sharp fa-solid fa-user-tie text-primary-700"></i>
            <div class="flex font-bold text-primary-700 ml-2">
                <div>Evaluator's Information</div>
            </div>
        </div>
        <div class="mt-2 mx-4">
            <form action="/industrial evaluator/create" method="POST">
                @csrf
                <div class="flex flex-col mt-2">
                    <label for="evaluator_name" class="font-semibold text-sm text-gray mb-2">Evaluator's Name</label>
                    <x-input name="evaluator_name" type="text" placeholder="Evaluator's Name" value="{{ old('evaluator_name') }}"/>
                    @error('evaluator_name')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="flex flex-col mt-2">
                    <label for="company" class="font-semibold text-sm text-gray mb-2">Company</label>
                    <x-input name="company" type="text" placeholder="Company" value="{{ old('company') }}"/>
                    @error('company')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="flex flex-col mt-2">
                    <label for="position" class="font-semibold text-sm text-gray mb-2">Position</label>
                    <x-input name="position" type="text" placeholder="Position" value="{{ old('position') }}"/>
                    @error('position')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="flex justify-end items-center mt-4">
                    <a href="/industrial evaluator"><x-secondary-button class="mr-2">back</x-secondary-button></a>
                    <x-button type="submit">Add</x-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>