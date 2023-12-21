<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('FYP Information') }}
        </h2>
    </x-slot>

    <x-success-message />
    <div class="ml-8">
        <div class="text-md font-bold">
            Final Year Project Information
        </div>

        <div class="text-sm font-semibold text-gray-400">
            Update your FYP's title and description. 
        </div>

        <div class="mt-4 mr-8"> 
            <form action="/fyp" method='POST' enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- FYP Title -->
                <div class="mt-4">
                    <x-label for="project_title" value="project title" />
                    <x-input name="project_title" type="text" class="mt-1 block w-full" value="{{ $fyp->project_title }}" required/>
                    <input-error for="project_title" class="mt-2" />
                </div>

                <!-- FYP Description -->
                <div class="mt-4">
                    <x-label for="project_description" value="project_description" />
                    <textarea name="project_description" class="mt-1 block w-full rounded-lg bg-white border-gray-200 focus:border-2 focus:border-primary-200 focus:ring-0 text-gray font-semibold text-sm" rows='8' cols='50' required>{{ $fyp->project_description }}</textarea>
                    <input-error for="project_description" class="mt-2" />
                </div>
                
                <div class="flex mt-4 justify-end w-full">
                    <x-button type="submit">
                        {{ __('Save') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>