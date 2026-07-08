<?php

declare(strict_types=1);

namespace Modules\Incentivi\Models\Policies;

use Modules\Incentivi\Models\Project;
use Modules\Xot\Contracts\UserContract;
use Override;

class ProjectPolicy extends IncentiviBasePolicy
{
    /**
     * Determine whether the user can view any projects.
     */
    #[Override]
    public function viewAny(UserContract $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the project.
     */
    public function view(UserContract $user, Project $project): bool
    {
        if ($this->isIncentiviAdmin($user)) {
            return true;
        }

        if ($this->isWorkgroupManager($user, $project)) {
            return true;
        }

        // Dipendente può vedere solo i Project del proprio Settore
        // if ($project->settore_id === $user->teams) {
        //     return true;
        // }

        return false;
    }

    /**
     * Determine whether the user can create projects.
     */
    public function create(UserContract $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the project.
     */
    public function update(UserContract $user, Project $project): bool
    {
        // Progetti conclusi o cancellati non possono essere modificati
        if (in_array($project->stato->value, ['concluso', 'cancellato'])) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can delete the project.
     */
    public function delete(UserContract $user, Project $project): bool
    {
        if (! $this->isIncentiviAdmin($user)) {
            return false;
        }

        // Solo progetti in compilazione possono essere eliminati
        return $project->stato->value === 'compilazione';
    }

    /**
     * Determine whether the user can delete any projects.
     */
    public function deleteAny(UserContract $user): bool
    {
        return $this->isIncentiviAdmin($user);
    }

    /**
     * Determine whether the user can approve the project.
     */
    public function approve(UserContract $user, Project $project): bool
    {
        return $this->isIncentiviAdmin($user) && $project->stato->value === 'compilazione';
    }

    /**
     * Determine whether the user can finalize the project.
     */
    public function finalize(UserContract $user, Project $project): bool
    {
        return $this->isIncentiviAdmin($user) && $project->stato->value === 'aggiudicazione';
    }

    /**
     * Determine whether the user can assign workgroup to project.
     */
    public function assignWorkgroup(UserContract $user, Project $project): bool
    {
        return $this->isIncentiviAdmin($user) && $project->stato->value === 'compilazione';
    }

    /**
     * Determine whether the user can calculate incentives.
     */
    public function calculateIncentives(UserContract $user, Project $project): bool
    {
        return ($this->isIncentiviAdmin($user) || $this->isWorkgroupManager($user, $project))
               && $project->stato->value !== 'cancellato';
    }

    /**
     * Determine whether the user can export project data.
     */
    public function export(UserContract $user, Project $project): bool
    {
        return $this->view($user, $project);
    }

    /**
     * Determine whether the user can duplicate the project.
     */
    public function replicate(UserContract $user, Project $project): bool
    {
        return $this->isIncentiviAdmin($user);
    }
}
