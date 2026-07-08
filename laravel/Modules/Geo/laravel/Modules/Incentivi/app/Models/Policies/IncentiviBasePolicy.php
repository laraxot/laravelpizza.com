<?php

declare(strict_types=1);

namespace Modules\Incentivi\Models\Policies;

use Illuminate\Database\Eloquent\Model;
use Modules\Incentivi\Models\Project;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\Policies\XotBasePolicy;

abstract class IncentiviBasePolicy extends XotBasePolicy
{
    /**
     * Verifica se l'utente è amministratore del modulo incentivi.
     */
    protected function isIncentiviAdmin(UserContract $user): bool
    {
        return $user->hasRole(['super-admin', 'incentivi-admin']);
    }

    /**
     * Verifica se l'utente è responsabile di un workgroup.
     */
    protected function isWorkgroupManager(UserContract $user, ?Model $model = null): bool
    {
        if (! $user->hasRole('workgroup-manager')) {
            return false;
        }

        // Se non c'è un modello specifico, è sufficiente avere il ruolo
        if ($model === null) {
            return true;
        }

        // Per ora ritorna true se ha il ruolo, la logica specifica sarà implementata nelle policy figlie
        return true;
    }

    /**
     * Verifica se l'utente ha accesso HR.
     */
    protected function hasHRAccess(UserContract $user): bool
    {
        return $user->hasRole(['super-admin', 'incentivi-admin', 'hr-manager']);
    }

    /**
     * Verifica se l'utente ha accesso finanziario.
     */
    protected function hasFinanceAccess(UserContract $user): bool
    {
        return $user->hasRole(['super-admin', 'incentivi-admin', 'finance-manager']);
    }

    /**
     * Verifica se l'utente è assegnato a un progetto specifico.
     */
    protected function isAssignedToProject(UserContract $user, ?Model $project): bool
    {
        if ($project === null) {
            return false;
        }

        // Verifica se è un'istanza di Project
        if ($project instanceof Project) {
            // Verifica se l'utente è assegnato al progetto tramite le attività
            $activities = $project->activities();
            $exists = $activities
                ->whereHas('employees', fn ($q) => $q->where('employee_id', $user->id))
                ->exists();
            if (is_bool($exists) && $exists) {
                return true;
            }

            // Verifica se l'utente è assegnato direttamente al progetto
            $employees = $project->employees();
            $exists = $employees->where('employee_id', $user->id)->exists();

            return is_bool($exists) ? $exists : false;
        }

        return false;
    }

    /**
     * Verifica se un progetto è modificabile basandosi sul suo stato.
     */
    protected function isProjectEditable(?Model $project): bool
    {
        if ($project === null) {
            return false;
        }

        // Verifica se il progetto ha la proprietà stato usando isset (non property_exists per attributi magici)
        if (! isset($project->stato)) {
            return true;
        }

        $stato = $project->stato;

        // Se stato è un enum, ottieni il valore
        if (is_object($stato) && isset($stato->value)) {
            $stato = $stato->value;
        }

        // Progetti conclusi o cancellati non sono modificabili
        return ! in_array($stato, ['concluso', 'cancellato']);
    }

    /**
     * Verifica se l'utente è il dipendente stesso o ha accesso amministrativo.
     */
    protected function canAccessEmployee(UserContract $user, Model $employee): bool
    {
        // L'utente può accedere ai propri dati (usando getKey() per compatibilità)
        if ($user->getKey() === $employee->getKey()) {
            return true;
        }

        // Amministratori e HR possono accedere a tutti i dipendenti
        if ($this->hasHRAccess($user)) {
            return true;
        }

        // Per ora semplificato, la logica specifica sarà nelle policy figlie
        return false;
    }
}
