<?php

declare(strict_types=1);

namespace Modules\Notify\Enums;

/**
 * Enum per i tipi di media supportati
 *
 * Questo enum centralizza la gestione dei tipi di media disponibili
 * e fornisce metodi helper per ottenere le opzioni e le etichette.
 */
enum MediaTypeEnum: string
{
    case IMAGE = 'image';
    case VIDEO = 'video';
    case DOCUMENT = 'document';
    case AUDIO = 'audio';

    /**
     * Restituisce le opzioni per il componente Select di Filament
     *
     * @return array<string, string>
     */
    public static function options(): array
    {
        return [
            self::IMAGE->value => 'Image',
            self::VIDEO->value => 'Video',
            self::DOCUMENT->value => 'Document',
            self::AUDIO->value => 'Audio',
        ];
    }

    /**
     * Restituisce le etichette localizzate per il componente Select di Filament
     *
     * @return array<string, string>
     */
    public static function labels(): array
    {
        return [
            self::IMAGE->value => __('notify::whatsapp.media_types.image'),
            self::VIDEO->value => __('notify::whatsapp.media_types.video'),
            self::DOCUMENT->value => __('notify::whatsapp.media_types.document'),
            self::AUDIO->value => __('notify::whatsapp.media_types.audio'),
        ];
    }

    /**
     * Verifica se un tipo di media è supportato
     *
     * @param string $type
     * @return bool
     */
    public static function isSupported(string $type): bool
    {
        return in_array($type, array_column(self::cases(), 'value'), strict: true);
    }

    /**
     * Restituisce il tipo di media predefinito
     *
     * @return self
     */
    public static function getDefault(): self
    {
        return self::IMAGE;
    }
}
