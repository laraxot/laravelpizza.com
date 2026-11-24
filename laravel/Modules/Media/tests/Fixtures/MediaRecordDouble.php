<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Il tipo che le action di Media ricevono davvero: un model che ha media.
 *
 * ## Perche' non basta mockare l'interfaccia
 *
 * I test facevano `createMock(HasMedia::class)` e poi
 * `$record->method('update')`, ottenendo:
 *
 *     MethodCannotBeConfiguredException
 *     Trying to configure method "update" which cannot be configured because it
 *     does not exist, has not been specified, is final, or is static
 *
 * `Spatie\MediaLibrary\HasMedia` dichiara `media()`, `addMedia()`,
 * `copyMedia()`, `hasMedia()`, `getMedia()` — e **non** `update()`, che e' di
 * Eloquent. Un mock PHPUnit espone i metodi che il tipo dichiara, quindi
 * `update` non c'era.
 *
 * Il codice di produzione invece e' corretto: quell'interfaccia porta
 * `@mixin Model` nel suo docblock, cioe' Spatie dichiara che chi la implementa
 * **e' anche** un model — ed e' per questo che PHPStan, a livello max, non
 * segnala `$record->update(...)` in `SaveAttachmentsAction`. Il tipo dichiarato
 * dice meno di quanto l'interfaccia prometta, e il mock prende alla lettera il
 * tipo.
 *
 * Questo doppio tiene insieme le due meta' di quella promessa, cosi' i test
 * mockano quello che la produzione riceve davvero invece di una sua parte
 * (base_quaeris_fila5#241).
 */
class MediaRecordDouble extends Model implements HasMedia
{
    use InteractsWithMedia;
}
