<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <x-section-border />
            @endif

            {{-- <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div> --}}

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif

            <x-form-section submit="updateProfileInformation">
                <x-slot name="title">
                    {{ __('FYP Information') }}
                </x-slot>
            
                <x-slot name="description">
                    {{ __('Update your FYP\'s title and description. ') }}
                </x-slot>
            
                <x-slot name="form">
                    <!-- FYP Title -->
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="name" value="{{ __('fyp_title') }}" />
                        <x-input id="name" type="text" class="mt-1 block w-full"/>
                        <x-input-error for="name" class="mt-2" />
                    </div>
            
                    <!-- FYP Description -->
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="email" value="{{ __('fyp_description') }}" />
                        <x-input id="email" type="email" class="mt-1 block w-full"/>
                        <x-input-error for="email" class="mt-2" />
                    </div>
                </x-slot>
            
                <x-slot name="actions">
                    <x-button wire:loading.attr="disabled" wire:target="photo">
                        {{ __('Save') }}
                    </x-button>
                </x-slot>
            </x-form-section>
        </div>
    </div>
</x-app-layout>
