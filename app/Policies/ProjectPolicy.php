<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    public function view(User $user, Project $project): bool
    {
        return (string) $project->user_id === (string) $user->id;
    }

    public function update(User $user, Project $project): bool
    {
        return (string) $project->user_id === (string) $user->id;
    }

    public function delete(User $user, Project $project): bool
    {
        return (string) $project->user_id === (string) $user->id;
    }
}
