<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Models\Traits;

use Modules\IndennitaResponsabilita\Models\Message;

trait FunctionTrait
{
    public function msg(string $type): string
    {
        $msg = $this->messages()->firstOrCreate(['type' => $type], ['anno' => $this->anno, 'txt' => $type.' '.$this->anno, 'title' => $type.' '.$this->anno]);
        if (! \is_object($msg)) {
            /*

            return (object) ['title' => $err, 'txt' => $err];
            */
            $err = 'aggiungere ['.$type.'] ad messages';

            return '<h3 style="color:darkred">'.$err.'</h3>';
        }

        return nl2br((string) ($msg->txt ?? ''));
    }

    public function criterioRoot(): ?Message
    {
        /** @var Message|null $message */
        $message = $this->messages()->firstOrCreate([
            'type' => 'criterio',
            'parent_id' => null,
        ]);

        return $message instanceof Message ? $message : null;
    }
}
