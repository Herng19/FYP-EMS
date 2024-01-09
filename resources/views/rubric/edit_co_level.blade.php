<x-app-layout>
    <x-slot name="header">
        Create CO Level
    </x-slot>

    <div class="mt-2 mb-4 mx-12 bg-white rounded-md py-6 px-8">
        <div class="flex items-center">
            <i class="fa-sharp fa-solid fa-user-tie text-primary-700"></i>
            <div class="flex font-bold text-primary-700 ml-2">
                <div>CO Level's Information</div>
            </div>
        </div>
        <div class="mt-2 mx-4">
            <form action="/rubric/edit-co-level/{{ $co_level->co_level_id }}" method="POST">
                @method('PUT')
                @csrf
                <div class="flex flex-col mt-4">
                    <label for="co_level_name" class="font-semibold text-sm text-gray mb-2">CO Level Name</label>
                    <x-input name="co_level_name" type="text" placeholder="CO Level's Name" value="{{ $co_level->co_level_name }}" required/>
                    @error('co_level_name')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="flex flex-col mt-4">
                    <label for="co_level_description" class="font-semibold text-sm text-gray mb-2">CO Level Descripion</label>
                    <x-input name="co_level_description" type="text" placeholder="CO Level Description" value="{{ $co_level->co_level_description }}" required/>
                    @error('co_level_description')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="flex justify-end items-center mt-4">
                    <a href="/rubric/co-level-settings"><x-secondary-button class="mr-2">back</x-secondary-button></a>
                    <x-button type="submit">UDPATE</x-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>