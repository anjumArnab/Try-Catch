<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreErrorLogRequest;
use App\Models\ErrorLog;
use App\Models\Project;
use Illuminate\Http\JsonResponse;

class LogErrorController extends Controller
{
    public function store(StoreErrorLogRequest $request): JsonResponse
    {
        /** @var Project $project */
        $project = $request->attributes->get('project');

        $data = $request->validated();

        $log = ErrorLog::create([
            'user_id' => $project->user_id,
            'project_id' => $project->id,
            'project_name' => $project->name,
            'message' => $data['message'],
            'stack_trace' => $data['stack_trace'] ?? null,
            'error_type' => $data['error_type'] ?? null,
            'severity_level' => $data['severity_level'] ?? 'error',
            'device_model' => $data['device_model'] ?? null,
            'os_version' => $data['os_version'] ?? null,
            'flutter_version' => $data['flutter_version'] ?? null,
            'app_version' => $data['app_version'] ?? null,
            'custom_payload' => $data['custom_payload'] ?? null,
            'client_timestamp' => $data['timestamp'] ?? null,
        ]);

        return response()->json([
            'status' => 'ok',
            'error_id' => (string) $log->id,
        ], 201);
    }
}
