<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-[#8b6f47]">Masuk ke Sistem</h1>
        <p class="text-sm text-[#a68a64] mt-1">PBKK — Sistem Akademik ITS</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-[#8b6f47]" />
            <x-text-input id="email"
                          class="block mt-1 w-full border-[#e8dcc8] focus:border-[#8b6f47] focus:ring-[#a68a64]"
                          type="email" name="email" :value="old('email')" required autofocus
                          autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-[#8b6f47]" />
            <x-text-input id="password"
                          class="block mt-1 w-full border-[#e8dcc8] focus:border-[#8b6f47] focus:ring-[#a68a64]"
                          type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                       class="rounded border-[#e8dcc8] text-[#8b6f47] focus:ring-[#a68a64]"
                       name="remember">
                <span class="ms-2 text-sm text-[#a68a64]">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-6">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-[#a68a64] hover:text-[#8b6f47] rounded-md
                          focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#a68a64]"
                   href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3 bg-[#8b6f47] hover:bg-[#6f5838] focus:bg-[#6f5838]
                                       active:bg-[#6f5838] focus:ring-[#a68a64]">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-6 pt-5 border-t border-[#e8dcc8]">
        <p class="text-xs text-[#a68a64] mb-3 text-center font-medium">Login cepat untuk demo:</p>
        <div class="grid grid-cols-2 gap-2">
            <form method="POST" action="{{ route('demo.login', 'admin') }}">
                @csrf
                <button type="submit"
                        class="w-full bg-[#8b6f47] hover:bg-[#6f5838] text-white text-xs py-2 rounded-lg
                               transition-all duration-200 shadow-sm hover:shadow">
                    Admin
                </button>
            </form>
            <form method="POST" action="{{ route('demo.login', 'dosen') }}">
                @csrf
                <button type="submit"
                        class="w-full bg-[#a68a64] hover:bg-[#8b6f47] text-white text-xs py-2 rounded-lg
                               transition-all duration-200 shadow-sm hover:shadow">
                    Dosen
                </button>
            </form>
            <form method="POST" action="{{ route('demo.login', 'asdos') }}">
                @csrf
                <button type="submit"
                        class="w-full bg-[#c9b18a] hover:bg-[#a68a64] text-white text-xs py-2 rounded-lg
                               transition-all duration-200 shadow-sm hover:shadow">
                    Asdos
                </button>
            </form>
            <form method="POST" action="{{ route('demo.login', 'mhs') }}">
                @csrf
                <button type="submit"
                        class="w-full bg-[#6f5838] hover:bg-[#4a3b2a] text-white text-xs py-2 rounded-lg
                               transition-all duration-200 shadow-sm hover:shadow">
                    Mahasiswa
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>