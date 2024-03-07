<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" id="registerForm">
        @csrf
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

         <div id="captcha-container" class="mt-4">
        </div>

        <div class="mt-4">
            <x-input-label for="captcha" :value="__('Captcha')" />
            <x-text-input id="captcha" class="block mt-1 w-full" type="text" name="captcha" required />
            <x-input-error :messages="$errors->get('captcha')" class="mt-2" />
        </div>

        <button type="button" id="refresh-captcha" class="mt-2 underline text-sm text-gray-600">Refresh Captcha</button>
        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Pay $50') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    function getCaptcha() {
        $.ajax({
            url: '{{ route('captcha') }}',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#captcha-container').text(data.equation);
            },
            error: function (error) {
                console.error('Error fetching captcha:', error);
            }
        });
    }

    $('#refresh-captcha').on('click', function () {
        getCaptcha();
    });

    getCaptcha();
</script>
