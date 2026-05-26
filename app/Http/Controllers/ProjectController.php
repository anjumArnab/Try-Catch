<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = Project::orderBy('created_at', 'desc')->get();

        return view('projects.index', ['projects' => $projects]);
    }

    public function create(): View
    {
        return view('projects.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $project = Project::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
        ]);

        return redirect()
            ->route('projects.show', $project)
            ->with('status', 'Project created. Copy your API key below — keep it secret.');
    }

    public function show(Request $request, Project $project): View
    {
        $this->authorize('view', $project);

        $query = $project->errorLogs()->orderBy('created_at', 'desc');

        if ($severity = $request->input('severity')) {
            $query->where('severity_level', $severity);
        }

        if ($errorType = $request->input('error_type')) {
            $query->where('error_type', $errorType);
        }

        if ($search = $request->input('q')) {
            $query->where('message', 'like', '%'.$search.'%');
        }

        if ($from = $request->input('from')) {
            $query->where('created_at', '>=', Carbon::parse($from)->startOfDay());
        }

        if ($to = $request->input('to')) {
            $query->where('created_at', '<=', Carbon::parse($to)->endOfDay());
        }

        $logs = $query->paginate(25)->withQueryString();

        return view('projects.show', [
            'project' => $project,
            'logs' => $logs,
            'filters' => $request->only(['severity', 'error_type', 'q', 'from', 'to']),
        ]);
    }

    public function destroy(Project $project): RedirectResponse
    {
        $this->authorize('delete', $project);

        $project->errorLogs()->delete();
        $project->delete();

        return redirect()
            ->route('projects.index')
            ->with('status', 'Project deleted.');
    }

    public function regenerateKey(Project $project): RedirectResponse
    {
        $this->authorize('update', $project);

        $project->update(['api_key' => Project::generateApiKey()]);

        return redirect()
            ->route('projects.show', $project)
            ->with('status', 'API key regenerated. Update your Flutter app with the new key.');
    }
}
