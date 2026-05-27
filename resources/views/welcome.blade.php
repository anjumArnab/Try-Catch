<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50">
        <div class="relative min-h-screen flex flex-col overflow-hidden">
            <!-- Faded, blurred replica of the error-logging dashboard as a backdrop.
                 Non-interactive and hidden from assistive tech; purely decorative. -->
            <div aria-hidden="true" class="pointer-events-none select-none absolute inset-0 overflow-hidden">
                <div class="opacity-50 blur-[3.5px] pt-20">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
                        <!-- Stat cards -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                                <div class="text-sm text-gray-500">Projects</div>
                                <div class="mt-1 text-3xl font-bold text-gray-900">12</div>
                            </div>
                            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                                <div class="text-sm text-gray-500">Total errors logged</div>
                                <div class="mt-1 text-3xl font-bold text-gray-900">1,284</div>
                            </div>
                        </div>

                        <!-- Recent errors table (mirrors the real dashboard markup) -->
                        <div class="bg-white shadow-sm sm:rounded-lg">
                            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                                <h3 class="font-semibold text-gray-800">Recent errors</h3>
                                <span class="text-sm text-indigo-600">View projects</span>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 text-sm">
                                    <thead class="bg-gray-50 text-left text-xs uppercase text-gray-500">
                                        <tr>
                                            <th class="px-4 py-3">Severity</th>
                                            <th class="px-4 py-3">Project</th>
                                            <th class="px-4 py-3">Message</th>
                                            <th class="px-4 py-3">When</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        <tr>
                                            <td class="px-4 py-3"><x-severity-badge level="fatal" /></td>
                                            <td class="px-4 py-3 text-gray-700">mobile-app</td>
                                            <td class="px-4 py-3 text-gray-900">RangeError: index out of bounds</td>
                                            <td class="px-4 py-3 text-gray-500 whitespace-nowrap">2m ago</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3"><x-severity-badge level="error" /></td>
                                            <td class="px-4 py-3 text-gray-700">api-gateway</td>
                                            <td class="px-4 py-3 text-gray-900">NullPointerException in checkout handler</td>
                                            <td class="px-4 py-3 text-gray-500 whitespace-nowrap">5m ago</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3"><x-severity-badge level="warning" /></td>
                                            <td class="px-4 py-3 text-gray-700">worker</td>
                                            <td class="px-4 py-3 text-gray-900">Timeout connecting to Mongo replica</td>
                                            <td class="px-4 py-3 text-gray-500 whitespace-nowrap">12m ago</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3"><x-severity-badge level="info" /></td>
                                            <td class="px-4 py-3 text-gray-700">web-client</td>
                                            <td class="px-4 py-3 text-gray-900">Deprecated API call: /v1/users</td>
                                            <td class="px-4 py-3 text-gray-500 whitespace-nowrap">18m ago</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3"><x-severity-badge level="debug" /></td>
                                            <td class="px-4 py-3 text-gray-700">mobile-app</td>
                                            <td class="px-4 py-3 text-gray-900">Cache miss for key user:4821</td>
                                            <td class="px-4 py-3 text-gray-500 whitespace-nowrap">25m ago</td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3"><x-severity-badge level="error" /></td>
                                            <td class="px-4 py-3 text-gray-700">api-gateway</td>
                                            <td class="px-4 py-3 text-gray-900">Unhandled rejection: payment declined</td>
                                            <td class="px-4 py-3 text-gray-500 whitespace-nowrap">34m ago</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Scrim: radial fade — strong white halo behind the centered hero text,
                     fading to near-transparent at the edges so the dashboard stays visible. -->
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,rgba(249,250,251,0.92)_0%,rgba(249,250,251,0.6)_38%,rgba(249,250,251,0.15)_75%)]"></div>
            </div>

            <!-- Top navigation -->
            <header class="relative z-10 border-b border-gray-100 bg-white/80 backdrop-blur">
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
            <main class="relative z-10 flex-1 flex items-center">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-28 w-full">
                    <div class="max-w-2xl mx-auto text-center">
                        <span class="inline-flex items-center rounded-md bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-600/10">
                            {{ __('Error & log tracking, simplified') }}
                        </span>

                        <h1 class="mt-6 text-4xl sm:text-5xl font-bold tracking-tight text-gray-900">
                            {{ __('Catch every exception before your users do.') }}
                        </h1>

                        <p class="mt-6 text-lg leading-8 text-gray-600">
                            {{ __('Ingest logs from all your projects, surface errors by severity, and stay ahead of incidents — all in one dashboard.') }}
                        </p>

                        <div class="mt-10 flex items-center justify-center gap-x-4" x-data="{}">
                            <button type="button"
                                    @click="$dispatch('open-modal', 'register-modal')"
                                    class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white tracking-wide hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                                {{ __('Get started') }}
                            </button>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="relative z-10 border-t border-gray-100 bg-white/80 backdrop-blur">
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
