<x-guest-layout>
    <x-authentication-card>
        <x-validation-errors class="mb-4" />

            @session('status')
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ $value }}
                </div>
            @endsession
                <div class="shrink-0 flex items-center justify-center mb-5">
                    <img class="h-18 w-18 transition-transform duration-500 ease-in-out hover:rotate-[360deg]"
                    src="{{ asset('app-logo.png') }}">
                        <h class="font-3xl font-bold text-3xl text-white">SPRINGHIVE</h>
                    </img>
                </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
        
                        <div>
                            <x-label for="email" value="{{ __('Email') }}" class="text-white" />
                            <x-input id="email" class="block mt-1 w-full bg-transparent text-white" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        </div>
        
                        <div class="mt-4">
                            <x-label for="password" value="{{ __('Password') }}" class="text-white" />
                            <x-input id="password" class="block mt-1 w-full bg-transparent text-white" type="password" name="password" required autocomplete="current-password" />
                        </div>
        
                        <div class="block mt-4">
                            <label for="remember_me" class="flex items-center">
                                <x-checkbox id="remember_me" name="remember" />
                                <span class="ms-2 text-sm text-white">{{ __('Remember me') }}</span>
                            </label>
                        </div>
        
                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ms-4">
                                {{ __('Log in') }}
                            </x-button>
                        </div>

                    </form>

    </x-authentication-card>
</x-guest-layout>
