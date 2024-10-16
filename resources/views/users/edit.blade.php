<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit '. $user->name)}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Profile Information') }}
                            </h2>
                    
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Update account's profile information and email address.") }}
                            </p>
                        </header>
                    
                        <form method="post" action="{{ route('users.update', $user) }}" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')
                    
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>
                    
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    
                            <div class="flex items-center gap-4 mt-5">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>
                    
                                @if (session('status') === 'user-updated')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600 dark:text-gray-400"
                                    >{{ __('Saved.') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>                    
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section id="password-section">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Update Password') }}
                            </h2>
                    
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Ensure this account is using a long, random password to stay secure.') }}
                            </p>
                        </header>
                    
                        <form method="post" action="{{ route('users.update-password', $user) }}" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')
                    
                            <div>
                                <x-input-label for="update_password_password" :value="__('New Password')" />
                                <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                            </div>
                    
                            <div>
                                <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
                                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                            </div>
                    
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>
                    
                                @if (session('status') === 'password-updated')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600 dark:text-gray-400"
                                    >{{ __('Saved.') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>
                    
                </div>
            </div>

            @if ($user->status == 0)
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <section class="space-y-6">
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Suspend Account') }}
                                </h2>
                        
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __("Once ".$user->name."'s account is deleted, all of its resources and data will be permanently deleted. Before deleting this account, please download any data or information that you wish to retain.") }}
                                </p>
                            </header>
                        
                            <x-danger-button
                                x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'suspend-user')"
                            >{{ __('Suspend Account') }}</x-danger-button>
                        
                            <x-modal name="suspend-user" :show="$errors->userDeletion->isNotEmpty()" focusable>
                                <form method="post" action="{{ route('users.suspend', $user) }}" class="p-6">
                                    @csrf
                                    @method('patch')
                        
                                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                        {{ __("Are you sure you want to delete ".$user->name." your account?") }}
                                    </h2>
                        
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                        {{ __("Once ".$user->name."'s account is deleted, all of its resources and data will be permanently deleted. Please enter Super Admin password to confirm you would like to permanently delete this user's account.") }}
                                    </p>
                        
                                    <div class="mt-6">
                                        <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                        
                                        <x-text-input
                                            id="password"
                                            name="password"
                                            type="password"
                                            class="mt-1 block w-3/4"
                                            placeholder="{{ __('Password') }}"
                                        />
                        
                                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                                    </div>
                        
                                    <div class="mt-6 flex justify-end">
                                        <x-secondary-button x-on:click="$dispatch('close')">
                                            {{ __('Cancel') }}
                                        </x-secondary-button>
                        
                                        <x-danger-button class="ms-3">
                                            {{ __('Suspend Account') }}
                                        </x-danger-button>
                                    </div>
                                </form>
                            </x-modal>
                        </section>
                        
                    </div>
                </div>
            @else
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <section class="space-y-6">
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Unsuspend Account') }}
                                </h2>
                        
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __($user->name."'s account is suspended, all of its resources and data will be permanently deleted. Before deleting this account, please download any data or information that you wish to retain.") }}
                                </p>
                            </header>
                        
                            <x-danger-button
                                x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'unsuspend-user')"
                            >{{ __('Unsuspend Account') }}</x-danger-button>
                        
                            <x-modal name="unsuspend-user" :show="$errors->userDeletion->isNotEmpty()" focusable>
                                <form method="post" action="{{ route('users.unsuspend', $user) }}" class="p-6">
                                    @csrf
                                    @method('patch')
                        
                                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                        {{ __("Are you sure you want to unsuspend ".$user->name." 's account?") }}
                                    </h2>
                        
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                        {{ __("Once ".$user->name."'s account is deleted, all of its resources and data will be permanently deleted. Please enter Super Admin password to confirm you would like to permanently delete this user's account.") }}
                                    </p>
                        
                                    <div class="mt-6">
                                        <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                        
                                        <x-text-input
                                            id="password"
                                            name="password"
                                            type="password"
                                            class="mt-1 block w-3/4"
                                            placeholder="{{ __('Password') }}"
                                        />
                        
                                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                                    </div>
                        
                                    <div class="mt-6 flex justify-end">
                                        <x-secondary-button x-on:click="$dispatch('close')">
                                            {{ __('Cancel') }}
                                        </x-secondary-button>
                        
                                        <x-danger-button class="ms-3">
                                            {{ __('Unsuspend Account') }}
                                        </x-danger-button>
                                    </div>
                                </form>
                            </x-modal>
                        </section>
                        
                    </div>
                </div>
            @endif

            

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section class="space-y-6">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Delete Account') }}
                            </h2>
                    
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Once ".$user->name."'s account is deleted, all of its resources and data will be permanently deleted. Before deleting this account, please download any data or information that you wish to retain.") }}
                            </p>
                        </header>
                    
                        <x-danger-button
                            x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                        >{{ __('Delete Account') }}</x-danger-button>
                    
                        <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                            <form method="post" action="{{ route('users.destroy', $user) }}" class="p-6">
                                @csrf
                                @method('delete')
                    
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __("Are you sure you want to delete ".$user->name." your account?") }}
                                </h2>
                    
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __("Once ".$user->name."'s account is deleted, all of its resources and data will be permanently deleted. Please enter Super Admin password to confirm you would like to permanently delete this user's account.") }}
                                </p>
                    
                                <div class="mt-6">
                                    <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                    
                                    <x-text-input
                                        id="password"
                                        name="password"
                                        type="password"
                                        class="mt-1 block w-3/4"
                                        placeholder="{{ __('Password') }}"
                                    />
                    
                                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                                </div>
                    
                                <div class="mt-6 flex justify-end">
                                    <x-secondary-button x-on:click="$dispatch('close')">
                                        {{ __('Cancel') }}
                                    </x-secondary-button>
                    
                                    <x-danger-button class="ms-3">
                                        {{ __('Delete Account') }}
                                    </x-danger-button>
                                </div>
                            </form>
                        </x-modal>
                    </section>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>