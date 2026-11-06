<?php

declare(strict_types=1);

namespace Modules\Media\Models\Traits;

use Exception;
use Modules\Media\Models\Media;

/**
 * Mutator + gemelli di {@see Media}.
 *
 * Ogni `get{X}Attribute()` delega a `get{X}()` nello stesso file
 * (regola accessor-twin: cache/persistenza nell'accessor, calcolo puro nel gemello).
 *
 * @phpstan-require-extends Media
 */
trait MediaMutator
{
    public function getUrlConv(string $conv): string
    {
        $url = $this->getUrl();
        $info = pathinfo($url);
        if (! isset($info['dirname'])) {
            throw new Exception('['.__LINE__.']['.class_basename($this).']');
        }
        $url = '#';
        switch ($conv) {
            case 'thumb':
                $url = $info['dirname'].'/conversions/'.$info['filename'].'-thumb.jpg';

                break;
            case '800':
                $url = $info['dirname'].'/conversions/'.$info['filename'].'-800.jpg';

                break;
            case '400':
                $url = $info['dirname'].'/conversions/'.$info['filename'].'-400.jpg';

                break;
        }

        return url($url);
    }

    /**
     * @return array<int, array{name: string, generated: bool, src: string}>
     */
    public function getEntryConversionsAttribute(): array
    {
        return $this->getEntryConversions();
    }

    /**
     * @return array<int, array{name: string, generated: bool, src: string}>
     */
    public function getEntryConversions(): array
    {
        $conversions = [];
        foreach ($this->getGeneratedConversions() as $conv => $state) {
            $item = [
                'name' => is_string($conv) ? $conv : ((string) $conv),
                'generated' => (bool) $state,
                'src' => $this->getUrlConv(is_string($conv) ? $conv : ((string) $conv)),
            ];
            $conversions[] = $item;
        }

        return $conversions;
    }
}
