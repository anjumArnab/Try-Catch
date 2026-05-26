<?php

namespace App\Http\Controllers;

use App\Models\ErrorLog;
use App\Models\Project;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $projects = Project::orderBy('created_at', 'desc')->get();
        $recentErrors = ErrorLog::orderBy('created_at', 'desc')->limit(10)->get();

        return view('dashboard', [
            'projects' => $projects,
            'projectCount' => $projects->count(),
            'totalErrors' => ErrorLog::count(),
            'recentErrors' => $recentErrors,
        ]);
    }
}
