<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Projects</div>
                    <div class="mt-1 text-3xl font-bold text-gray-900">{{ $projectCount }}</div>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Total errors logged</div>
                    <div class="mt-1 text-3xl font-bold text-gray-900">{{ $totalErrors }}</div>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-800">Recent errors</h3>
                    <a href="{{ route('projects.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">View projects</a>
                </div>

                @if ($recentErrors->isEmpty())
                    <div class="p-6 text-gray-500">No errors logged yet.</div>
                @else
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
                                @foreach ($recentErrors as $error)
                                    <tr>
                                        <td class="px-4 py-3"><x-severity-badge :level="$error->severity_level" /></td>
                                        <td class="px-4 py-3 text-gray-700">{{ $error->project_name }}</td>
                                        <td class="px-4 py-3 text-gray-900 max-w-md truncate" title="{{ $error->message }}">{{ $error->message }}</td>
                                        <td class="px-4 py-3 text-gray-500 whitespace-nowrap">{{ $error->created_at?->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
