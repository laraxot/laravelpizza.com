<?php

declare(strict_types=1);

namespace Modules\User\Actions\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Spatie\QueueableAction\QueueableAction;

/**
 * UpdateUserAction: Action generica per l'aggiornamento dei dati utente.
 *
 * Questa action gestisce l'aggiornamento dei dati di base dell'utente.
 * Può essere estesa dai moduli specifici per aggiungere logica personalizzata.
 */
class UpdateUserAction
{
    use QueueableAction;

    /**
     * Esegue l'aggiornamento dell'utente.
     *
     * @param Model                $user L'utente da aggiornare
     * @param array<string, mixed> $data I dati da aggiornare
     *
     * @throws \Exception Se l'aggiornamento fallisce
     *
     * @return Model L'utente aggiornato
     */
    public function execute(Model $user, array $data): Model
    {
        try {
            DB::beginTransaction();

            // Prepara i dati per l'aggiornamento
            $updateData = $this->prepareUpdateData($data);

            // Valida i dati specifici per l'aggiornamento
            $this->validateUpdateData($user, $updateData);

            // Aggiorna l'utente
            $user->fill($updateData);
            $user->save();

            // Esegue operazioni post-aggiornamento se necessarie
            $this->afterUpdate($user, $updateData);

            DB::commit();

            Log::info('Utente aggiornato con successo', [
                'user_id' => $user->getKey(),
                'updated_fields' => array_keys($updateData),
            ]);

            $updatedUser = $user->fresh();
            if (! ($updatedUser instanceof Model)) {
                throw new \Exception('Failed to refresh user model after update');
            }

            return $updatedUser;
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error("Errore nell'aggiornamento utente", [
                'user_id' => $user->getKey(),
                'error' => $e->getMessage(),
                'data' => $updateData ?? [],
            ]);

            throw $e;
        }
    }

    /**
     * Prepara i dati per l'aggiornamento rimuovendo campi non aggiornabili.
     *
     * @param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    protected function prepareUpdateData(array $data): array
    {
        // Rimuovi campi che non dovrebbero essere aggiornati direttamente
        $excludeFields = [
            'id',
            'email_verified_at',
            'remember_token',
            'created_at',
            'updated_at',
        ];

        $updateData = array_diff_key($data, array_flip($excludeFields));

        // Gestione speciale per la password
        if (isset($updateData['password'])) {
            if (empty($updateData['password'])) {
                // Se la password è vuota, rimuovila dai dati di aggiornamento
                unset($updateData['password']);
            } else {
                // Hash della password se presente
                $updateData['password'] = Hash::make(SafeStringCastAction::cast($updateData['password']));
            }
        }

        // Gestione dell'email per evitare duplicati
        if (isset($updateData['email'])) {
            $email = SafeStringCastAction::cast($updateData['email']);
            $updateData['email'] = strtolower($email);
        }

        return $updateData;
    }

    /**
     * Valida i dati di aggiornamento.
     *
     * @param array<string, mixed> $data
     *
     * @throws ValidationException
     */
    protected function validateUpdateData(Model $user, array $data): void
    {
        // Validazione email univoca
        if (isset($data['email'])) {
            $existingUser = $user
                ->newQuery()
                ->where('email', $data['email'])
                ->where('id', '!=', $user->getKey())
                ->first();

            if ($existingUser) {
                throw ValidationException::withMessages(['email' => __('user::validation.email_already_taken')]);
            }
        }

        // Validazioni aggiuntive possono essere aggiunte qui
        // o nelle classi che estendono questa action
    }

    /**
     * Operazioni da eseguire dopo l'aggiornamento.
     * Può essere sovrascritto dalle classi che estendono questa action.
     *
     * @param array<string, mixed> $data
     */
    protected function afterUpdate(Model $user, array $data): void
    {
        // Implementazione di default vuota
        // Le classi derivate possono sovrascrivere questo metodo per:
        // - Inviare notifiche
        // - Aggiornare cache
        // - Registrare log di audit
        // - Gestire relazioni
    }
}
