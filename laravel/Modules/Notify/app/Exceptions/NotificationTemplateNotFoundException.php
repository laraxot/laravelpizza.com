<?php

declare(strict_types=1);

namespace Modules\Notify\Exceptions;

use RuntimeException;

/**
 * Il template richiesto non esiste, oppure esiste ma non e' attivo.
 *
 * ## Perche' un'eccezione di dominio e non `Exception`
 *
 * Prima il codice lanciava `new Exception("Template ... non trovato")` in due
 * punti diversi con due messaggi diversi, quindi chi chiamava non poteva
 * distinguere «il template manca» da qualunque altro guasto senza leggere il
 * testo del messaggio. Con un tipo proprio il chiamante puo' decidere: un
 * template mancante in un invio di massa si salta, un guasto vero no
 * (base_quaeris_fila5#112).
 *
 * ## Perche' estende `RuntimeException` e non `Exception`
 *
 * Perche' i `catch (Exception $e)` gia' scritti continuino a prenderla: e'
 * lanciata dentro cicli che registrano l'errore e proseguono, e restringere
 * la gerarchia li farebbe fallire in silenzio.
 */
class NotificationTemplateNotFoundException extends RuntimeException
{
    public static function forCode(string $templateCode): self
    {
        return new self(sprintf('Template %s non trovato o non attivo', $templateCode));
    }
}
