

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Users') }}
        </h2>
    </x-slot>
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <form method="POST" action="{{ route('users.store') }}">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Role --}}
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Role')" />
                    <select name="role" id="role">
                        <option value="3">User</option>
                        <option value="2">Admin</option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                </div>


                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">

                    <x-primary-button class="ms-4">
                        {{ __('Add User') }}
                    </x-primary-button>
                </div>
            </form>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">
                
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="table">
                        <thead>
                            <tr>
                                <td class="px-5">Name</td>
                                <td class="px-5">Email</td>
                                <td class="px-5">Role</td>
                                <td class="px-5">Status</td>
                                <td class="px-5">Created At</td>
                                {{-- <td class="px-5">Updated At</td> --}}
                                <td class="px-5">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            
                                @foreach ($users as $user)

                                    @php
                                        if($user->role == 2){

                                            $userRole = 'Admin';

                                        }elseif($user->role == 3) {

                                            $userRole = 'User';

                                        }

                                        if($user->status == 0){

                                            $userStatus = 'Access';

                                        }elseif ($user->status == 1) {
                                            
                                            $userStatus = 'Suspended';

                                        }
                                    @endphp

                                    <tr>
                                        <td class="px-5">{{ $user->name }}</td>
                                        <td class="px-5">{{ $user->email }}</td>
                                        <td class="px-5">{{ $userRole }}</td>
                                        <td class="px-5">{{ $userStatus }}</td>
                                        <td class="px-5">{{ $user->created_at->format('l, F j, Y') }}</td>
                                        {{-- <td class="px-5">{{ $user->updated_at->format('l, F j, Y') }}</td> --}}
                                        <td class="px-5"><a href="{{route("users.edit", $user)}}">{{ __('Edit') }}</a></td>
                                    </tr>
                                @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>