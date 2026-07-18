<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-900">Create Account</h2>
        <p class="text-sm text-gray-500 mt-1">Join us to start submitting proposals</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="space-y-5 bg-gray-50/50 p-6 rounded-xl border border-gray-100">
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" class="text-gray-700 font-semibold" />
                <x-text-input id="name" class="block mt-2 w-full border-gray-300 focus:border-amber-500 focus:ring-amber-500 rounded-lg shadow-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-semibold" />
                <x-text-input id="email" class="block mt-2 w-full border-gray-300 focus:border-amber-500 focus:ring-amber-500 rounded-lg shadow-sm" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold" />
                <x-text-input id="password" class="block mt-2 w-full border-gray-300 focus:border-amber-500 focus:ring-amber-500 rounded-lg shadow-sm"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700 font-semibold" />
                <x-text-input id="password_confirmation" class="block mt-2 w-full border-gray-300 focus:border-amber-500 focus:ring-amber-500 rounded-lg shadow-sm"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full flex justify-center items-center px-4 py-3 bg-amber-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-amber-700 active:bg-amber-900 focus:outline-none focus:border-amber-900 focus:ring ring-amber-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-sm">
                {{ __('Register') }}
            </button>
        </div>
        
        <div class="mt-6 text-center text-sm text-gray-600">
            Already have an account? 
            <a href="{{ route('login') }}" class="font-bold text-amber-600 hover:text-amber-500">Log in here</a>
        </div>
    </form>
</x-guest-layout>
