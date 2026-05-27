<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50">
        <div class="min-h-screen flex flex-col">
            <!-- Top navigation -->
            <header class="border-b border-gray-100 bg-white/80 backdrop-blur">
                <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">
                        <a href="/" class="flex items-center gap-2">
                            <x-application-logo class="h-8 w-auto fill-current text-gray-800" />
                            <span class="text-lg font-semibold tracking-tight">{{ config('app.name', 'Laravel') }}</span>
                        </a>

                        <div class="flex items-center gap-4" x-data="{}">
                            <a href="{{ route('login') }}"
                               class="text-sm font-medium text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 rounded-md">
                                {{ __('Log in') }}
                            </a>
                            <button type="button"
                                    @click="$dispatch('open-modal', 'register-modal')"
                                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </nav>
            </header>

            <!-- Hero -->
            <main class="flex-1 flex items-center">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-28 w-full">
                    <div class="max-w-2xl mx-auto text-center">
                        <span class="inline-flex items-center rounded-full bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-600/10">
                            {{ __('Error & log tracking, simplified') }}
                        </span>

                        <h1 class="mt-6 text-4xl sm:text-5xl font-bold tracking-tight text-gray-900">
                            {{ __('Catch every exception before your users do.') }}
                        </h1>

                        <p class="mt-6 text-lg leading-8 text-gray-600">
                            {{ __('Ingest logs from all your projects, surface errors by severity, and stay ahead of incidents — all in one clean dashboard.') }}
                        </p>

                        <div class="mt-10 flex items-center justify-center gap-x-4" x-data="{}">
                            <button type="button"
                                    @click="$dispatch('open-modal', 'register-modal')"
                                    class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white tracking-wide hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                                {{ __('Get started — Register') }}
                            </button>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="border-t border-gray-100 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center text-sm text-gray-400">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}
                </div>
            </footer>
        </div>

        <!-- Registration modal: reuses the same form, endpoint, and validation as /register.
             Auto-opens (show=true) after a failed POST /register redirect-back so inline
             errors and old input are visible without navigating away. -->
        <x-modal name="register-modal" :show="$errors->any()" focusable>
            <div class="p-6">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">{{ __('Create your account') }}</h2>
                        <p class="mt-1 text-sm text-gray-600">{{ __('Get started in seconds.') }}</p>
                    </div>
                    <button type="button"
                            @click="$dispatch('close-modal', 'register-modal')"
                            class="text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 rounded-md"
                            aria-label="{{ __('Close') }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="mt-4">
                    @include('auth.partials.register-form')
                </div>
            </div>
        </x-modal>
    </body>
</html>
