<?php

declare(strict_types=1);

namespace Modules\AI\Actions\Vision;

use Modules\AI\Datas\AIConfigData;
use Modules\AI\Enums\AiProviderEnum;
use Modules\AI\Exceptions\AiRequestException;
use Safe\Exceptions\UrlException;
use Spatie\QueueableAction\QueueableAction;

use function Safe\base64_decode;

/**
 * Modifica un'immagine secondo istruzioni (es. "pulisci questo logo su sfondo bianco") e restituisce
 * la nuova immagine. Agnostica: le istruzioni le scrive il modulo che la usa.
 *
 * Endpoint immagini di OpenRouter (`/images`): immagine di partenza in `input_references`
 * (data URI), risposta in `data[0].b64_json` con `media_type`.
 */
class EditImageAction
{
    use QueueableAction;

    public function __construct(private readonly ImageDataUriAction $dataUri) {}

    /**
     * @return array{mime: string, bytes: string}
     *
     * @throws AiRequestException
     */
    public function execute(string $imagePath, string $instructions, ?string $model = null, string $aspectRatio = '1:1'): array
    {
        $config = AIConfigData::make();
        $model ??= $config->image_model;
        if ($config->free_models_only && ! AiProviderEnum::OpenRouter->isFreeModel($model)) {
            throw new AiRequestException('Nessun modello gratuito genera immagini: modifica non disponibile con ai.free_models_only.');
        }
        // Solo OpenRouter modifica immagini: Groq non ha modelli con output di immagini.
        $json = app(OpenAiCompatibleRequestAction::class)->execute(AiProviderEnum::OpenRouter, '/images', [
            'model' => $model,
            'prompt' => $instructions,
            'input_references' => [$this->dataUri->execute($imagePath)],
            'aspect_ratio' => $aspectRatio,
            'output_format' => 'png',
            'n' => 1,
        ], $config->vision_timeout);

        $b64 = data_get($json, 'data.0.b64_json');
        try {
            $bytes = is_string($b64) ? base64_decode($b64, true) : '';
        } catch (UrlException $e) {
            throw new AiRequestException('Immagine restituita non valida.', previous: $e);
        }
        if ($bytes === '') {
            throw new AiRequestException('Il servizio AI non ha restituito un\'immagine.');
        }

        $mime = data_get($json, 'data.0.media_type');

        return ['mime' => is_string($mime) && $mime !== '' ? $mime : 'image/png', 'bytes' => $bytes];
    }
}
