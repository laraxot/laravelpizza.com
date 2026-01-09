<?php

declare(strict_types=1);

namespace Modules\Geo\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Modules\Geo\Datas\AddressData;
use Spatie\QueueableAction\QueueableAction;

/**
 * Action per aggiornare le coordinate geografiche di un modello basandosi sul suo indirizzo.
 *
 * Questa action utilizza il geocoding per ottenere le coordinate (latitude/longitude)
 * da un indirizzo completo e aggiorna il modello con i dati risultanti.
 *
 * Supporta qualsiasi modello che implementi:
 * - Proprietà `full_address` (string|null) - indirizzo completo per geocoding
 * - Proprietà `latitude` (float|null) - coordinata latitudine da aggiornare
 * - Proprietà `longitude` (float|null) - coordinata longitudine da aggiornare
 *
 * @example
 * ```php
 * // Utilizzo sincrono
 * $action = app(UpdateCoordinatesFromAddressAction::class);
 * $action->execute($client); // Client con full_address, latitude, longitude
 *
 * // Utilizzo asincrono
 * $action->onQueue('geo')->execute($client);
 * ```
 */
class UpdateCoordinatesFromAddressAction
{
    use QueueableAction;

    /**
     * Collection per memorizzare eventuali errori durante l'esecuzione.
     */
    private Collection $errors;

    public function __construct(
        private readonly GetAddressDataFromFullAddressAction $getAddressDataAction,
    ) {
        $this->errors = collect();
    }

    /**
     * Esegue l'aggiornamento delle coordinate per un modello.
     *
     * @param Model $model Il modello da aggiornare (deve avere full_address, latitude, longitude)
     *
     * @return bool True se l'aggiornamento è riuscito, false altrimenti
     */
    public function execute(Model $model): bool
    {
        // Reset errori per questa esecuzione
        $this->errors = collect();

        // Ottieni l'indirizzo completo dal modello
        $fullAddress = $this->getFullAddressFromModel($model);

        if (empty($fullAddress)) {
            $this->errors->push(__('geo::actions.update_coordinates.errors.empty_address'));

            return false;
        }

        // Esegui geocoding per ottenere i dati dell'indirizzo
        $addressData = $this->getAddressDataAction->execute($fullAddress);

        if ($addressData === null) {
            // Raccogli errori dal servizio di geocoding
            $geocodingErrors = $this->getAddressDataAction->getErrors();
            if ($geocodingErrors->isNotEmpty()) {
                $this->errors->merge($geocodingErrors);
            } else {
                $this->errors->push(__('geo::actions.update_coordinates.errors.geocoding_failed'));
            }

            return false;
        }

        // Aggiorna il modello con le coordinate ottenute
        return $this->updateModelCoordinates($model, $addressData);
    }

    /**
     * Restituisce la collezione degli errori verificatisi durante l'esecuzione.
     *
     * @return Collection<int, string>
     */
    public function getErrors(): Collection
    {
        return $this->errors;
    }

    /**
     * Ottiene l'indirizzo completo dal modello.
     *
     * @return string Indirizzo completo o stringa vuota
     */
    private function getFullAddressFromModel(Model $model): string
    {
        // Ottieni l'indirizzo completo dal modello
        // Usa getAttribute per type safety e supporta accessor automatico
        /** @var string|int|float|bool|null $fullAddressRaw */
        $fullAddressRaw = $model->getAttribute('full_address');

        // Eloquent chiama automaticamente l'accessor se esiste quando si accede alla proprietà
        // Usiamo una reflection per ottenere il valore formattato se l'accessor esiste
        if (method_exists($model, 'getFullAddressAttribute')) {
            // Eloquent accessor pattern: get{AttributeName}Attribute($value)
            // Chiamiamo direttamente il metodo con il valore raw
            $fullAddress = $model->getFullAddressAttribute($fullAddressRaw);

            return is_string($fullAddress) ? $fullAddress : '';
        }

        // Fallback: attributo diretto
        return is_string($fullAddressRaw) ? $fullAddressRaw : '';
    }

    /**
     * Aggiorna le coordinate del modello con i dati ottenuti dal geocoding.
     *
     * @return bool True se l'aggiornamento è riuscito
     */
    private function updateModelCoordinates(Model $model, AddressData $addressData): bool
    {
        try {
            $model->update([
                'latitude' => $addressData->latitude,
                'longitude' => $addressData->longitude,
            ]);

            return true;
        } catch (\Exception $e) {
            // Log dell'errore per debugging
            Log::error('Errore aggiornamento coordinate', [
                'model' => $model::class,
                'model_id' => $model->getKey(),
                'error' => $e->getMessage(),
            ]);

            $this->errors->push($e->getMessage());

            return false;
        }
    }
}
