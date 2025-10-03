<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;

class ProjectPolicy
{
    /** Determine whether the user can view the project. */
    public function view(User $user, Project $project)
    {
        // Allow admins.
        if ($user->is_admin) {
            return true;
        }

        // If user is linked to a student assigned to this project, allow view.
        if ($user->student_id) {
            return $project->students->contains($user->student_id);
        }

        // Otherwise, allow any authenticated user to view projects.
        return true;
    }

    /** Only admins can create projects */
    public function create(User $user)
    {
        // Only admins may create projects.
        return $user->is_admin;
    }

    /** Only admins can update */
    public function update(User $user, Project $project)
    {
        return $user->is_admin;
    }

    /** Only admins can delete */
    public function delete(User $user, Project $project)
    {
        return $user->is_admin;
    }

    /** Only admins can assign/unassign */
    public function assign(User $user, Project $project)
    {
        return $user->is_admin;
    }

    public function unassign(User $user, Project $project)
    {
        return $user->is_admin;
    }
}
