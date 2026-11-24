<?php

declare(strict_types=1);

namespace Modules\Lang\Models\Traits\Mutators;

use Illuminate\Support\Str;

/**
 * Attribute mutators and accessors for the Post model.
 */
trait PostMutators
{
    public function setTitleAttribute(string $value): void
    {
        $this->attributes['title'] = $value;
        $this->attributes['guid'] = Str::slug($value);
    }

    public function getTitleAttribute(?string $value): ?string
    {
        if ($value !== null) {
            return $value;
        }

<<<<<<< HEAD
        $postType = is_string($this->attributes['post_type'] ?? null) ? $this->attributes['post_type'] : '';
        $postId = is_scalar($this->attributes['post_id'] ?? null) ? $this->attributes['post_id'] : '';
        $value = $postType.' '.$postId;
=======
        $value = $this->computeTitle();
>>>>>>> laraxot/dev
        $this->title = $value;

        if ($this->getKey() !== null) {
            $this->update(['title' => $value]);
        }

        return $value;
    }

<<<<<<< HEAD
=======
    /**
     * Il guid del post, ricalcolato quando quello salvato non e' utilizzabile.
     *
     * ## Il difetto che aveva
     *
     * `Str::slug($this->title ?? '')` di un titolo vuoto e' la stringa vuota, e
     * la stringa vuota non supera mai il controllo qui sopra. Il risultato erano
     * due cose insieme:
     *
     * - un guid vuoto **scritto sul database**, cioe' una URL rotta resa
     *   permanente;
     * - una `update()` a **ogni lettura** di quel post, per sempre, perche' il
     *   valore ricalcolato continuava a non superare il controllo.
     *
     * Ora il ripiego non e' mai vuoto, quindi il valore scritto supera il
     * controllo alla lettura successiva e il ciclo si chiude.
     *
     * ## Quello che resta da decidere
     *
     * Questo accessor **scrive**: leggere `$post->guid` emette una `UPDATE`.
     * Elencare cinquanta post puo' emettere cinquanta scritture, e dentro una
     * transazione modifica lo stato di righe che il chiamante credeva di stare
     * solo leggendo. `getTitleAttribute()`, qui sopra, fa la stessa cosa.
     *
     * Non lo si tocca in questa correzione perche' la scrittura ha uno scopo —
     * riparare le righe vecchie con guid mancante — e toglierla cambia il
     * comportamento delle rotte che su quel guid si appoggiano. La scelta sta in
     * base_quaeris_fila5#235.
     */
>>>>>>> laraxot/dev
    public function getGuidAttribute(?string $value): ?string
    {
        if (is_string($value) && $value !== '' && ! str_contains($value, ' ')) {
            return $value;
        }

<<<<<<< HEAD
        $value = Str::slug($this->title ?? '');
=======
        $value = $this->computeGuid();
>>>>>>> laraxot/dev
        $this->guid = $value;

        if ($this->getKey() !== null) {
            $this->update(['guid' => $value]);
        }

        return $value;
    }

<<<<<<< HEAD
=======
    /**
     * Il titolo da cui ricavare il guid, oppure null se non ce n'e' uno usabile.
     *
     * Esiste come metodo a parte perche' «qual e' il titolo buono» e' la sola
     * variabile di {@see computeGuid()}, e perche' la fixture
     * `Modules\Lang\Tests\Fixtures\PostNullTitleForGuidStub` la sovrascriveva
     * **gia'** per verificare il ramo senza titolo — ma qui non esisteva, quindi
     * l'override era inerte e il test misurava il percorso normale
     * (base_quaeris_fila5#234).
     */
    protected function titleForGuid(): ?string
    {
        $title = $this->title;

        if (is_string($title) && trim($title) !== '') {
            return $title;
        }

        // Il titolo salvato e' vuoto, ma un titolo **calcolabile** c'e': e' lo
        // stesso che `getTitleAttribute()` mostrerebbe, cioe' «<post_type>
        // <post_id>». Un post di tipo `x` con id 1 deve quindi avere guid `x-1`,
        // non un ripiego casuale: il guid e' una URL, e una URL che descrive la
        // riga vale piu' di otto caratteri a caso.
        $computed = $this->computeTitle();

        return trim($computed) !== '' ? $computed : null;
    }

    /**
     * Il titolo ricavato dal tipo e dall'id, per i post che non ne hanno uno.
     *
     * Serve a {@see getTitleAttribute()} e a {@see titleForGuid()}: senza
     * questo metodo il secondo avrebbe dovuto chiamare il primo, che **scrive**
     * (base_quaeris_fila5#235), e leggere il guid avrebbe riparato anche il
     * titolo — un effetto collaterale in piu' a ogni lettura. Qui il calcolo e'
     * separato dalla scrittura, e chi vuole solo il valore non paga la
     * `UPDATE`.
     */
    private function computeTitle(): string
    {
        $postType = is_string($this->attributes['post_type'] ?? null) ? $this->attributes['post_type'] : '';
        $postId = is_scalar($this->attributes['post_id'] ?? null) ? $this->attributes['post_id'] : '';

        return $postType.' '.$postId;
    }

    /**
     * Un guid non vuoto, deterministico quando il post e' salvato.
     *
     * Deterministico non e' un dettaglio: siccome l'accessor scrive, un ripiego
     * casuale darebbe un guid diverso a ogni lettura e riscriverebbe la riga
     * ogni volta. Per un post salvato il ripiego e' quindi la sua chiave, che e'
     * stabile e unica; solo per un post non ancora salvato — che non ha
     * identita' e non viene scritto, perche' `getKey()` e' null — si usa una
     * stringa casuale.
     */
    private function computeGuid(): string
    {
        $title = $this->titleForGuid();

        if ($title !== null) {
            $slug = Str::slug($title);

            // Un titolo di sola punteggiatura, o scritto in un alfabeto che
            // Str::slug() non traslittera, da' comunque slug vuoto.
            if ($slug !== '') {
                return $slug;
            }
        }

        $key = $this->getKey();

        if (is_scalar($key) && (string) $key !== '') {
            return 'post-'.$key;
        }

        return 'post-'.Str::random(8);
    }

>>>>>>> laraxot/dev
    public function getTxtAttribute(?string $value): ?string
    {
        return $value ?? '';
    }
}
