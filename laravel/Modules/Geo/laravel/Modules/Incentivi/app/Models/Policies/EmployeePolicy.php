<?php

declare(strict_types=1);

namespace Modules\Incentivi\Models\Policies;

use Modules\Incentivi\Models\Employee;
use Modules\Xot\Contracts\UserContract;
use Override;

class EmployeePolicy extends IncentiviBasePolicy
{
    /**
     * Determine whether the user can view any employees.
     */
    #[Override]
    public function viewAny(UserContract $user): bool
    {
        // return $this->isIncentiviAdmin($user) || $this->isWorkgroupManager($user) || $this->hasHRAccess($user);
        return true;
    }

    /**
     * Determine whether the user can view the employee.
     */
    public function view(UserContract $user, Employee $employee): bool
    {
        if ($this->isIncentiviAdmin($user) || $this->hasHRAccess($user)) {
            return true;
        }

        // I dipendenti possono visualizzare solo i propri dati
        if ($user->id === $employee->id) {
            return true;
        }

        // I responsabili workgroup possono visualizzare dipendenti del loro gruppo
        if ($this->isWorkgroupManager($user) && $employee->workgroups()->whereHas('managers', fn ($q) => $q->where('user_id', $user->id))->exists()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create employees.
     */
    public function create(UserContract $user): bool
    {
        return $this->isIncentiviAdmin($user) || $this->hasHRAccess($user);
    }

    /**
     * Determine whether the user can update the employee.
     */
    public function update(UserContract $user, Employee $employee): bool
    {
        // return $this->isIncentiviAdmin($user) || $this->hasHRAccess($user);
        return true;
    }

    /**
     * Determine whether the user can delete the employee.
     */
    public function delete(UserContract $user, Employee $employee): bool
    {
        if ($this->isIncentiviAdmin($user)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view employee incentives.
     */
    public function viewIncentives(UserContract $user, Employee $employee): bool
    {
        if ($this->isIncentiviAdmin($user) || $this->hasHRAccess($user)) {
            return true;
        }

        // I dipendenti possono vedere solo i propri incentivi
        if ($user->id === $employee->id) {
            return true;
        }

        // I responsabili workgroup possono vedere incentivi dipendenti del loro gruppo
        if ($this->isWorkgroupManager($user) && $employee->workgroups()->whereHas('managers', fn ($q) => $q->where('user_id', $user->id))->exists()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can assign employee to activity.
     */
    public function assignToActivity(UserContract $user, Employee $employee): bool
    {
        if (! ($this->isIncentiviAdmin($user) || $this->isWorkgroupManager($user))) {
            return false;
        }

        // Verifica se il dipendente può essere assegnato (logica da implementare se necessaria)

        return true;
    }

    /**
     * Determine whether the user can deactivate the employee.
     */
    public function deactivate(UserContract $user, Employee $employee): bool
    {
        return $this->isIncentiviAdmin($user) || $this->hasHRAccess($user);
    }

    /**
     * Determine whether the user can activate the employee.
     */
    public function activate(UserContract $user, Employee $employee): bool
    {
        return $this->isIncentiviAdmin($user) || $this->hasHRAccess($user);
    }

    /**
     * Determine whether the user can export employee data.
     */
    public function export(UserContract $user, Employee $employee): bool
    {
        return $this->view($user, $employee);
    }
}
