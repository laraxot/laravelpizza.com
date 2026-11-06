<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\String;

use Spatie\QueueableAction\QueueableAction;

class GetPronounceablePasswordAction
{
    use QueueableAction;

    /**
     * Genera una password con lettere, cifra e simbolo usando casualità crittografica.
     *
     * @param  int  $length  Lunghezza richiesta (default: 12, minimo: 5)
     */
    public function execute(int $length = 12): string
    {
        $length = max(5, $length);
        $vowels = 'aeiou';
        $consonants = 'bcdfghjklmnprstvwxyz';
        $specials = '!#*-_=+:?';
        $password = '';

        for ($index = 0; $index < $length - 3; $index++) {
            $alphabet = $index % 2 === 0 ? $consonants : $vowels;
            $password .= $alphabet[random_int(0, strlen($alphabet) - 1)];
        }

        $uppercase = strtoupper($password[random_int(0, strlen($password) - 1)]);
        $password .= $uppercase.random_int(0, 9).$specials[random_int(0, strlen($specials) - 1)];

        for ($index = strlen($password) - 1; $index > 0; $index--) {
            $swapIndex = random_int(0, $index);
            $character = $password[$index];
            $password[$index] = $password[$swapIndex];
            $password[$swapIndex] = $character;
        }

        return $password;
    }
}
