<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $project->name }}</h2>
                <p class="text-xs text-gray-500 font-mono">{{ $project->endpoint_slug }}</p>
            </div>
            <form method="POST" action="{{ route('projects.destroy', $project) }}"
                  onsubmit="return confirm('Delete this project and all its logs? This cannot be undone.');">
                @csrf
                @method('DELETE')
                <button class="text-sm text-red-600 hover:text-red-800">Delete project</button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded">{{ session('status') }}</div>
            @endif

            {{-- Integration details --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-5" x-data="{ revealed: false }">
                <h3 class="font-semibold text-gray-800">Integration</h3>

                <div>
                    <label class="block text-xs uppercase text-gray-500 mb-1">Ingest endpoint (POST)</label>
                    <div class="flex items-center gap-2">
                        <code class="flex-1 bg-gray-50 border border-gray-200 rounded px-3 py-2 text-sm break-all"
                              x-ref="endpoint">{{ url('/api/'.$project->endpoint_slug.'/log-error') }}</code>
                        <button type="button" class="text-sm text-indigo-600 hover:text-indigo-800"
                                @click="navigator.clipboard.writeText($refs.endpoint.innerText)">Copy</button>
                    </div>
                </div>

                <div>
                    <label class="block text-xs uppercase text-gray-500 mb-1">API key (send as <span class="font-mono">X-Api-Key</span> header)</label>
                    <div class="flex items-center gap-2">
                        <code class="flex-1 bg-gray-50 border border-gray-200 rounded px-3 py-2 text-sm break-all"
                              x-ref="apikey">
                            <span x-show="revealed">{{ $project->api_key }}</span>
                            <span x-show="!revealed">{{ str_repeat('•', 24) }}</span>
                        </code>
                        <button type="button" class="text-sm text-gray-600 hover:text-gray-900"
                                @click="revealed = !revealed" x-text="revealed ? 'Hide' : 'Reveal'"></button>
                        <button type="button" class="text-sm text-indigo-600 hover:text-indigo-800"
                                @click="navigator.clipboard.writeText('{{ $project->api_key }}')">Copy</button>
                        <form method="POST" action="{{ route('projects.regenerate-key', $project) }}"
                              onsubmit="return confirm('Regenerate the API key? The old key will stop working immediately.');">
                            @csrf
                            <button class="text-sm text-amber-600 hover:text-amber-800">Regenerate</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Filters --}}
            <div class="bg-white shadow-sm sm:rounded-lg p-4">
                <form method="GET" action="{{ route('projects.show', $project) }}"
                      class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3 items-end">
                    <div class="lg:col-span-2">
                        <label class="block text-xs text-gray-500 mb-1">Search message</label>
                        <input type="text" name="q" value="{{ $filters['q'] ?? '' }}"
                               class="w-full border-gray-300 rounded-md shadow-sm text-sm" placeholder="contains…">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Severity</label>
                        <select name="severity" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                            <option value="">All</option>
                            @foreach (['debug','info','warning','error','fatal'] as $level)
                                <option value="{{ $level }}" @selected(($filters['severity'] ?? '') === $level)>{{ ucfirst($level) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Error type</label>
                        <input type="text" name="error_type" value="{{ $filters['error_type'] ?? '' }}"
                               class="w-full border-gray-300 rounded-md shadow-sm text-sm" placeholder="e.g. Exception">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">From</label>
                        <input type="date" name="from" value="{{ $filters['from'] ?? '' }}"
                               class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">To</label>
                        <input type="date" name="to" value="{{ $filters['to'] ?? '' }}"
                               class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                    </div>
                    <div class="lg:col-span-6 flex gap-3">
                        <button class="px-4 py-2 bg-gray-800 text-white text-sm font-semibold rounded-md hover:bg-gray-700">Filter</button>
                        <a href="{{ route('projects.show', $project) }}" class="px-4 py-2 text-sm text-gray-600 hover:underline">Reset</a>
                    </div>
                </form>
            </div>

            {{-- Logs --}}
            <div class="bg-white shadow-sm sm:rounded-lg">
                @if ($logs->isEmpty())
                    <div class="p-6 text-gray-500">No errors match these filters.</div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50 text-left text-xs uppercase text-gray-500">
                                <tr>
                                    <th class="px-4 py-3">Severity</th>
                                    <th class="px-4 py-3">Type</th>
                                    <th class="px-4 py-3">Message</th>
                                    <th class="px-4 py-3">When</th>
                                    <th class="px-4 py-3"></th>
                                </tr>
                            </thead>
                            @foreach ($logs as $log)
                                    <tbody x-data="{ open: false }" class="divide-y divide-gray-100">
                                        <tr class="cursor-pointer hover:bg-gray-50" @click="open = !open">
                                            <td class="px-4 py-3"><x-severity-badge :level="$log->severity_level" /></td>
                                            <td class="px-4 py-3 text-gray-700">{{ $log->error_type ?? '—' }}</td>
                                            <td class="px-4 py-3 text-gray-900 max-w-md truncate" title="{{ $log->message }}">{{ $log->message }}</td>
                                            <td class="px-4 py-3 text-gray-500 whitespace-nowrap">{{ $log->created_at?->format('Y-m-d H:i:s') }}</td>
                                            <td class="px-4 py-3 text-indigo-600 text-xs" x-text="open ? 'Hide' : 'Details'"></td>
                                        </tr>
                                        <tr x-show="open" x-cloak>
                                            <td colspan="5" class="px-4 py-4 bg-gray-50">
                                                <dl class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs mb-3">
                                                    <div><dt class="text-gray-500">Error ID</dt><dd class="font-mono">{{ $log->id }}</dd></div>
                                                    <div><dt class="text-gray-500">Device</dt><dd>{{ $log->device_model ?? '—' }}</dd></div>
                                                    <div><dt class="text-gray-500">OS</dt><dd>{{ $log->os_version ?? '—' }}</dd></div>
                                                    <div><dt class="text-gray-500">Flutter</dt><dd>{{ $log->flutter_version ?? '—' }}</dd></div>
                                                    <div><dt class="text-gray-500">App version</dt><dd>{{ $log->app_version ?? '—' }}</dd></div>
                                                    <div><dt class="text-gray-500">Client time</dt><dd>{{ optional($log->client_timestamp)?->format('Y-m-d H:i:s') ?? '—' }}</dd></div>
                                                </dl>
                                                @if ($log->stack_trace)
                                                    <div class="mb-3">
                                                        <div class="text-xs text-gray-500 mb-1">Stack trace</div>
                                                        <pre class="bg-gray-900 text-gray-100 text-xs rounded p-3 overflow-x-auto whitespace-pre-wrap">{{ $log->stack_trace }}</pre>
                                                    </div>
                                                @endif
                                                @if (!empty($log->custom_payload))
                                                    <div>
                                                        <div class="text-xs text-gray-500 mb-1">Custom payload</div>
                                                        <pre class="bg-gray-100 text-gray-800 text-xs rounded p-3 overflow-x-auto">{{ json_encode($log->custom_payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                            @endforeach
                        </table>
                    </div>

                    <div class="px-4 py-3 border-t border-gray-100">
                        {{ $logs->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
