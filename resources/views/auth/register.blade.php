    @foreach ($errors->all() as $error)
        <div> {{ $error }}</div>
    @endforeach



<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- first Name -->
        <div>
            <x-input-label for="first_name" :value="__('Name')" />
            <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('name')" required autofocus autocomplete="name" />
            {{-- <x-input-error :messages="$errors->get('first_name')" class="mt-2" /> --}}
        </div>

        <!-- Last Name -->
        <div class="mt-4">
            <x-input-label for="last_name" :value="__('Last Name')" />
            <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autocomplete="name" />
            {{-- <x-input-error :messages="$errors->get('last_name')" class="mt-2" /> --}}
        </div>

        {{-- username --}}
        <div class="mt-4">
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autocomplete="username" />
            {{-- <x-input-error :messages="$errors->get('username')" class="mt-2" /> --}}
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            {{-- <x-input-error :messages="$errors->get('email')" class="mt-2" /> --}}
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            {{-- <x-input-error :messages="$errors->get('password')" class="mt-2" /> --}}
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            {{-- <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" /> --}}
        </div>

        {{-- phone_number --}}
        <div class="mt-4">
            <x-input-label for="phone_number" :value="__('Phone Number')" />
            <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number')" required autocomplete="phone_number" />
            {{-- <x-input-error :messages="$errors->get('phone_number')" class="mt-2" /> --}}
        </div>

        {{-- country --}}
        <div class="mt-4">
            <x-input-label for="country" :value="__('Country')" />
            <x-text-input id="country" class="block mt-1 w-full" type="text" name="country" :value="old('country')" required autocomplete="country" />
            {{-- <x-input-error :messages="$errors->get('country')" class="mt-2" /> --}}
        </div>

        {{-- bio --}}
        <div class="mt-4">
            <x-input-label for="bio" :value="__('Bio')" />
            <x-text-input id="bio" class="block mt-1 w-full" type="text" name="bio" :value="old('bio')" required autocomplete="bio" />
            {{-- <x-input-error :messages="$errors->get('bio')" class="mt-2" /> --}}
        </div>

        {{-- profile_picture -image file --}}
        <div class="mt-4">
            <x-input-label for="profile_picture" :value="__('Profile Picture')" />
            <x-text-input id="profile_picture" class="block mt-1 w-full" type="file" name="profile_picture" :value="old('profile_picture')" autocomplete="profile_picture" />
            {{-- <x-input-error :messages="$errors->get('profile_picture')" class="mt-2" /> --}}
        </div>


        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
