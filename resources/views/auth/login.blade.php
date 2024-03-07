<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <!-- Captcha Container -->
        <div id="captcha-container" class="mt-4">
            <!-- Captcha equation will be displayed here -->
        </div>

        <!-- Captcha Input -->
        <div class="mt-4">
            <x-input-label for="captcha" :value="__('Captcha')" />
            <x-text-input id="captcha" class="block mt-1 w-full" type="text" name="captcha" required />
            <x-input-error :messages="$errors->get('captcha')" class="mt-2" />
        </div>

        <!-- Refresh Captcha Button -->
        <button type="button" id="refresh-captcha" class="mt-2">Refresh Captcha</button>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
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
                console.log(data);
                $('#captcha-container').text(data.equation);
            },
            error: function (error) {
                console.error('Error fetching captcha:', error);
            }
        });
    }

    // Refresh captcha on button click
    $('#refresh-captcha').on('click', function () {
        getCaptcha();
    });

    // Initial captcha load
    getCaptcha();
</script>
