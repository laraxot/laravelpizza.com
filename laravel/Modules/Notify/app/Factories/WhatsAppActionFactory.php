<?php

declare(strict_types=1);

namespace Modules\Notify\Factories;

use Exception;
use Illuminate\Support\Facades\Config;
use Modules\Notify\Actions\WhatsApp\Send360dialogWhatsAppAction;
use Modules\Notify\Actions\WhatsApp\SendFacebookWhatsAppAction;
use Modules\Notify\Actions\WhatsApp\SendTwilioWhatsAppAction;
use Modules\Notify\Actions\WhatsApp\SendVonageWhatsAppAction;
use Modules\Notify\Contracts\WhatsAppProviderActionInterface;

use function Safe\preg_replace;

/**
 * Factory per la creazione di azioni WhatsApp.
 *
 * Questa factory centralizza la logica di selezione del driver WhatsApp
 * e la creazione dell'azione corrispondente, seguendo il pattern Factory.
 */
final class WhatsAppActionFactory
{
    /**
     * Crea un'azione WhatsApp basata sul driver specificato o su quello predefinito.
     *
     * @param string|null $driver Driver WhatsApp da utilizzare (se null, viene utilizzato quello predefinito)
     * @return WhatsAppProviderActionInterface Azione WhatsApp corrispondente al driver
     * @throws Exception Se il driver specificato non è supportato
     */
    /**
     * Crea un'azione WhatsApp basata sul driver specificato o su quello predefinito.
     * Utilizza una formula per calcolare il nome della classe dell'azione.
     *
     * @param string|null $driver Driver WhatsApp da utilizzare (se null, viene utilizzato quello predefinito)
     * @return WhatsAppProviderActionInterface Azione WhatsApp corrispondente al driver
     * @throws Exception Se il driver specificato non è supportato o la classe non esiste
     */
    public function create(null|string $driver = null): WhatsAppProviderActionInterface
    {
        $driver ??= Config::get('whatsapp.default', 'twilio');

        // Gestione speciale per driver con caratteri non alfanumerici (es. 360dialog)
        $normalizedDriver = preg_replace('/[^a-zA-Z0-9]/', '', ucfirst(strtolower(is_string($driver) ? $driver : '')));

        // Costruisci il nome completo della classe
        $className = "\\Modules\\Notify\\Actions\\WhatsApp\\Send{$normalizedDriver}WhatsAppAction";

        // Verifica se la classe esiste
        if (!class_exists($className)) {
            throw new Exception(
                'Unsupported WhatsApp driver: ' .
                (is_string($driver) ? $driver : '') .
                    ". Class {$className} not found.",
            );
        }

        // Verifica se la classe implementa l'interfaccia richiesta
        if (!is_subclass_of($className, WhatsAppProviderActionInterface::class)) {
            throw new Exception("Class {$className} does not implement WhatsAppProviderActionInterface.");
        }

        /** @var WhatsAppProviderActionInterface $instance */
        $instance = app($className);
        return $instance;
    }
}
