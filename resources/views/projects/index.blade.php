<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Projects') }}</h2>
            <a href="{{ route('projects.create') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-800 text-white text-sm font-semibold rounded-md hover:bg-gray-700">
                New project
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded">{{ session('status') }}</div>
            @endif

            @if ($projects->isEmpty())
                <div class="bg-white shadow-sm sm:rounded-lg p-10 text-center text-gray-500">
                    No projects yet. <a href="{{ route('projects.create') }}" class="text-indigo-600 hover:underline">Create your first project</a>.
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($projects as $project)
                        <a href="{{ route('projects.show', $project) }}"
                           class="block bg-white shadow-sm rounded-lg p-5 hover:shadow-md transition">
                            <div class="font-semibold text-gray-900">{{ $project->name }}</div>
                            <div class="mt-1 text-xs text-gray-500 font-mono break-all">{{ $project->endpoint_slug }}</div>
                            <div class="mt-3 text-sm text-gray-600">{{ $project->errorLogs()->count() }} errors</div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
