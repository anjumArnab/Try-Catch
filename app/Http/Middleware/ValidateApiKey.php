<?php

namespace App\Http\Middleware;

use App\Models\Project;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateApiKey
{
    public function handle(Request $request, Closure $next): Response
    {
        $endpoint = (string) $request->route('endpoint');

        $project = Project::withoutGlobalScopes()
            ->where('endpoint_slug', $endpoint)
            ->first();

        if (! $project) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unknown endpoint.',
            ], 404);
        }

        $providedKey = $request->header('X-Api-Key') ?: $request->bearerToken();

        if (! $providedKey || ! hash_equals((string) $project->api_key, (string) $providedKey)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid API key.',
            ], 401);
        }

        $request->attributes->set('project', $project);

        return $next($request);
    }
}
