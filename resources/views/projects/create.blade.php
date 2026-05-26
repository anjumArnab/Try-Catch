<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('New Project') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('projects.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Project name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                      :value="old('name')" required autofocus placeholder="e.g. Here We Go" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        <p class="mt-2 text-sm text-gray-500">
                            A unique ingest endpoint and a secret API key will be generated automatically.
                        </p>
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Create project') }}</x-primary-button>
                        <a href="{{ route('projects.index') }}" class="text-sm text-gray-600 hover:underline">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
