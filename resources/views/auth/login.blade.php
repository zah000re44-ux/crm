<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-b from-gray-50 to-white px-4">
        <div class="w-full max-w-md">

            {{-- Logo --}}
            <div class="text-center mb-6">
                <div class="flex justify-center">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-gray-900 text-white flex items-center justify-center font-extrabold text-xl">
                            R
                        </div>
                        <div class="text-left leading-tight">
                            <div class="text-2xl font-extrabold text-gray-900">Real Estate CRM</div>
                            <div class="text-xs text-gray-500">إدارة العملاء العقاريين</div>
                        </div>
                    </div>
                </div>
                <p class="text-sm text-gray-500 mt-4">تسجيل الدخول إلى حسابك</p>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">

                {{-- Session Status --}}
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <x-input-label for="email" value="الإيميل" />
                        <x-text-input
                            id="email"
                            class="block mt-1 w-full rounded-xl border-gray-200 focus:border-gray-900 focus:ring-gray-900"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autofocus
                            autocomplete="username"
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    {{-- Password --}}
                    <div>
                        <x-input-label for="password" value="كلمة المرور" />
                        <x-text-input
                            id="password"
                            class="block mt-1 w-full rounded-xl border-gray-200 focus:border-gray-900 focus:ring-gray-900"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                        />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    {{-- Remember + Forgot --}}
                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center gap-2 text-gray-600">
                            <input
                                id="remember_me"
                                type="checkbox"
                                class="rounded border-gray-300 text-gray-900 focus:ring-gray-900"
                                name="remember"
                            >
                            تذكرني
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-gray-600 hover:text-gray-900 font-semibold"
                               href="{{ route('password.request') }}">
                                نسيت كلمة المرور؟
                            </a>
                        @endif
                    </div>

                    {{-- Submit --}}
                    <div class="pt-2">
                        <button
                            type="submit"
                            class="w-full inline-flex items-center justify-center px-4 py-2 rounded-lg bg-gray-900 text-white text-sm font-semibold hover:bg-black focus:outline-none focus:ring-2 focus:ring-gray-300"
                        >
                            تسجيل الدخول
                        </button>
                    </div>

                </form>
            </div>

            <div class="text-center text-xs text-gray-400 mt-6">
                © {{ date('Y') }} Real Estate CRM
            </div>
        </div>
    </div>
</x-guest-layout>
