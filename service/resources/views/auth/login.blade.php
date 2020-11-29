<x-guest-layout>
    <x-authentication-card>
        <!-- container -->
        <div class="">
            <div class="row m-0">

                <div class="col-12 col-md-6 p-4">
                    <x-slot name="logo">
                        <x-logo />
                    </x-slot>

                    <x-validation-errors class="mb-4" />

                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div>
                            <x-label for="email" value="{{ __('$.email') }}" />
                            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                        </div>

                        <div class="mt-4">
                            <x-label for="password" value="{{ __('$.password') }}" />
                            <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                        </div>

                        <div class="block mt-4">
                            <label for="remember_me" class="flex items-center">
                                <input id="remember_me" type="checkbox" class="form-checkbox" name="remember">
                                <span class="ml-2 text-sm text-gray-600">{{ __('auth.remember_me') }}</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-3">

                            @if (Route::has('register'))
                                <x-button type="link" class="ml-3" href="{{ route('register') }}">
                                    {{ __('$.register') }}
                                </x-button>
                            @endif

                            <x-button class="ml-3 btn btn-primary">
                                {{ __('$.login') }}
                            </x-button>

                        </div>

                        @if (Route::has('password.request'))
                            <div class="d-block text-right mt-3">
                            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                                {{ __('auth.forgot_your_password') }}
                            </a>
                            </div>
                        @endif
            
                    </form>
                </div>

                <div class="col-12 col-md-6 p-4" style="background:lightblue;">
                    <h2 class="h2 text-light">{{ __('page.login:welcome') }}</h2>
                    <div class="text-light">
                        <b></b>
                    </div>
                </div>

            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </x-authentication-card>
</x-guest-layout>
