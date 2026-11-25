<?php

declare(strict_types=1);

namespace Modules\Rating\Models\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Rating\Enums\RuleEnum;
use Modules\Xot\Contracts\HasRecursiveRelationshipsContract;

/**
 * Il criterio di valutazione, visto da chi lo consuma.
 *
 * Sta in `app/Models/Contracts/` e non in `app/Contracts/` perche' porta
 * `@phpstan-require-extends Model`: **non e' implementabile da nient'altro che un model**,
 * quindi la cartella non e' una preferenza, e' un fatto gia' deciso dal contratto stesso.
 * `app/Contracts/` e' per i contratti che vincolano cose che model non sono — in questo
 * stesso modulo, `RatingsFormCallerContract`, che una Page di Filament implementa.
 *
 * Esiste perche' `Rating` e' consumato da sei moduli, ognuno con la propria concreta
 * (`Ptv\Models\Rating`, `Progressioni\Models\Rating`, ...) su una **connessione diversa**.
 * Chi costruisce un campo, una colonna o un filtro non ha bisogno di sapere quale concreta
 * ha in mano: ha bisogno di sapere **che cosa un criterio dichiara di se'**.
 *
 * Estende {@see HasRecursiveRelationshipsContract} perche' l'albero non e' un dettaglio
 * implementativo: un criterio con figli **e' un criterio a scelta**, e i figli sono le sue
 * opzioni. Chi riceve un `RatingContract` puo' chiedere `children()` senza sapere altro.
 *
 * Le proprieta' dichiarate sono quelle su cui **il comportamento cambia**:
 *
 * - `is_readonly` — il criterio si compila o si calcola;
 * - `rule` — con quale regola si valida cio' che ci si scrive;
 * - `parent_id` — se e' figlio di un altro criterio, e quindi se e' un'**opzione**
 *   invece che un campo (vedi `docs/criteri-a-scelta-multipla.md`);
 * - `title` e `txt` — il nome tecnico e quello leggibile, che **non sono la stessa cosa**;
 * - `slug` — l'identificativo stabile, l'unico che sopravvive a un rename.
 *
 * @extends HasRecursiveRelationshipsContract<Model>
 *
 * @phpstan-require-extends Model
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string|null $title
 * @property string|null $txt
 * @property string|null $slug
 * @property bool|null $is_readonly
 * @property bool|null $is_disabled
 * @property int|null $order_column
 * @property Collection<int, Model> $children
 * @property RuleEnum $rule
 */
interface RatingContract extends HasRecursiveRelationshipsContract
{
    /**
     * L'etichetta leggibile del criterio.
     *
     * Nel contratto e non solo sul model perche' chi mostra un criterio — una colonna, una
     * opzione di `Select` — non deve ricavarla da `txt` o `title` per conto proprio:
     * dedurre il comportamento dal testo e' il difetto che questo modulo ha gia' pagato.
     */
    public function getLabel(): string;
}
