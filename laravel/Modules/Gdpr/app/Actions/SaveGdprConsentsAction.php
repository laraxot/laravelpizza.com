<?php

declare(strict_types=1);

namespace Modules\Gdpr\Actions;

use Illuminate\Support\Facades\Log;
use Modules\Gdpr\Models\Consent;
use Modules\Gdpr\Models\Treatment;
use Modules\User\Models\User;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Spatie\QueueableAction\QueueableAction;

class SaveGdprConsentsAction
{
    use QueueableAction;

    /**
     * Valori di partenza dei tre trattamenti usati dalla registrazione. La versione del documento e' quella della prima
     * pubblicazione: deve seguire l'informativa e le condizioni pubblicate dall'ente (DCP-130, DCP-178).
     *
     * @var array<string, array<string, bool|int|string>>
     */
    private const array TREATMENT_DEFAULTS = [
        'privacy_policy' => ['description' => 'Presa visione dell\'informativa sul trattamento dei dati personali (GDPR artt. 13 e 14)', 'required' => true, 'active' => true, 'weight' => 1, 'documentVersion' => '1.0'],
        'terms_conditions' => ['description' => 'Accettazione delle condizioni d\'uso del servizio', 'required' => true, 'active' => true, 'weight' => 2, 'documentVersion' => '1.0'],
        'marketing_consent' => ['description' => 'Consenso facoltativo a ricevere aggiornamenti e inviti', 'required' => false, 'active' => true, 'weight' => 10, 'documentVersion' => '1.0'],
    ];

    /**
     * Save all GDPR consents for a user.
     *
     * @param  array<string, bool>  $consents  Associative array of consent properties (privacy_accepted, terms_accepted, etc.)
     */
    public function execute(User $user, array $consents, ?string $ipAddress = null, ?string $userAgent = null): void
    {
        $ipAddress ??= request()->ip();
        $userAgent ??= request()->userAgent();

        $consentMapping = [
            'privacy_accepted' => 'privacy_policy',
            'terms_accepted' => 'terms_conditions',
            'marketing_consent' => 'marketing_consent',
        ];

        foreach ($consentMapping as $property => $treatmentName) {
            $isAccepted = $consents[$property] ?? false;
            // La prova dell'accettazione non si salta mai in silenzio: se il trattamento non e' in tabella (seeder mai lanciato) si crea,
            // altrimenti la registrazione "riusciva" senza lasciare traccia di cosa il cittadino aveva accettato (GDPR art. 7 par. 1).
            $defaults = array_key_exists($treatmentName, self::TREATMENT_DEFAULTS) ? self::TREATMENT_DEFAULTS[$treatmentName] : null;
            if ($defaults === null) {
                Log::warning('Unknown GDPR treatment', ['treatment' => $treatmentName]);

                continue;
            }
            $treatment = Treatment::query()->firstOrCreate(['name' => $treatmentName], $defaults);

            Consent::query()->create([
                'user_id' => $user->id,
                'user_type' => $user::class,
                'treatment_id' => $treatment->id,
                'type' => $treatmentName,
                'accepted_at' => $isAccepted ? now() : null,
                'subject_id' => $user->id,
                'created_by' => 'gdpr_register_widget',
                'updated_by' => 'gdpr_register_widget',
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                // quale testo ha accettato: senza versione non si dimostra cosa e' stato accettato
                'metadata' => [
                    'document_version' => app(SafeStringCastAction::class)->execute($treatment->getAttribute('documentVersion')),
                    'document_url' => $treatment->getAttribute('documentUrl'),
                    'locale' => app()->getLocale(),
                ],
            ]);
        }

        Log::debug('GDPR consents saved via action', [
            'user_id' => $user->id,
            'ip' => $ipAddress,
            'consents' => $consents,
        ]);
    }
}
