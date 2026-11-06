<?php

declare(strict_types=1);
/*
 * Messaggi di validazione del modulo Media.
 *
 * `mime` e' la chiave usata da Modules\Media\Rules\FileExtensionRule::message().
 * Finche' questo file non e' esistito la regola restituiva la chiave grezza
 * `media::validation.mime` come messaggio d'errore all'utente.
 */

return [
    'mime' => 'Il file deve avere una di queste estensioni: :mimes.',
];
