<?php

declare(strict_types=1);

namespace Modules\Geo\Actions;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Modules\Geo\Models\Address;
use Spatie\QueueableAction\QueueableAction;

/**
 * Action to update coordinates for multiple addresses based on their full addresses.
 */
class UpdateClientCoordinatesBulkAction
{
    use QueueableAction;

    public function __construct(
        private readonly GetAddressDataFromFullAddressAction $getAddressDataFromFullAddressAction,
    ) {
    }

    /**
     * Execute the action to update coordinates for a collection of addresses.
     *
     * @param Collection<int, Address> $addresses
     *
     * @return array{success_count: int, error_messages: array<string>}
     */
    public function execute(Collection $addresses): array
    {
        $successCount = 0;
        $errorMessages = [];

        DB::transaction(function () use ($addresses, &$successCount, &$errorMessages) {
            foreach ($addresses as $address) {
                $fullAddress = is_string($address->full_address) ? $address->full_address : '';
                $addressData = $this->getAddressDataFromFullAddressAction->execute($fullAddress);

                if ($addressData !== null) {
                    $toArray = $addressData->toArray();
                    /** @var array<string, mixed> $up */
                    $up = Arr::only($toArray, ['latitude', 'longitude']);
                    /** @var array<string, mixed> $up */
                    $address->update($up);
                    ++$successCount;

                    continue;
                }

                // PHPStan L10: $address->name è già string|null, non serve is_string()
                $addressName = $address->name ?? 'Unknown';
                $errors = $this->getAddressDataFromFullAddressAction->getErrors();
                // PHPStan L10: Collection::implode() restituisce string, non serve ?:
                $errorMsg = $errors->implode(', ');
                if ($errorMsg === '') {
                    $errorMsg = 'Errore sconosciuto';
                }
                $errorMessages[] = "Errore per {$addressName}: {$errorMsg}";
            }
        });

        return [
            'success_count' => $successCount,
            'error_messages' => $errorMessages,
        ];
    }
}
