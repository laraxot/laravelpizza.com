<?php

declare(strict_types=1);

namespace Modules\Lang\Actions\Filament;

use Filament\Actions\Action;
use Filament\Forms\Components\Field;
use Filament\Infolists\Components\Entry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Tables\Columns\Column;
use Filament\Tables\Filters\BaseFilter;
use Illuminate\Support\Arr;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Modules\Lang\Actions\SaveTransAction;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Actions\File\SvgExistsAction;
use Modules\Xot\Actions\GetTransKeyAction;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * Etichette, intestazioni, segnaposto e testi d'aiuto dei componenti Filament presi dai file di lingua del modulo che
 * li usa; applicata a tutti i componenti con `configureUsing()` in LangServiceProvider.
 *
 * @see docs/contracts/auto-label-action.md
 * @contract docs/contracts/auto-label-action.md
 */
class AutoLabelAction
{
    use QueueableAction;

    /**
     * Undocumented function.
     * return number of input added.
     */
    /**
     * Il frame dello stack che identifica chi ha chiesto l'etichetta.
     *
     * Da quella classe si ricava la chiave di traduzione, quindi da questo
     * metodo dipende il **nome dei file di lingua** che il progetto scrive: e'
     * il punto piu' delicato di questa action, ed e' anche l'unico che non si
     * puo' pilotare dall'esterno, perche' legge lo stack delle chiamate.
     *
     * Per questo e' un metodo a parte: le fixture
     * `AutoLabelNullCallerStub` e `AutoLabelForcedKeyStub` lo sovrascrivevano
     * **gia'** per provare il ramo senza chiamante e quello con la sola chiave
     * `class`, ma qui non esisteva — l'override era inerte e i due test
     * esercitavano il percorso normale (base_quaeris_fila5#234).
     *
     * ## Perche' lo `slice(1)` in testa
     *
     * `debug_backtrace()` prima stava dentro `execute()`, e `array_slice(..., 2)`
     * contava i frame **da li'**. Spostare la chiamata qui aggiunge il frame di
     * questo metodo, quindi senza lo scarto iniziale la finestra si sposterebbe
     * di uno e cambierebbe la classe scelta — cioe' le chiavi di traduzione, cioe'
     * i file su disco. Lo scarto riporta la numerazione a com'era: questa
     * estrazione **non** cambia comportamento, ed e' una proprieta' voluta.
     *
     * Il `2` resta un numero magico, com'era prima; sostituirlo con un criterio
     * («il primo frame fuori da questa classe») e' una modifica a se', da fare
     * sapendo che si riscrivono delle chiavi.
     *
     * @return array<string, mixed>  il frame trovato, o `[]` se nessuno corrisponde
     */
    protected function findCallerFrame(Field|Entry|BaseFilter|Column|Step|Action|Section $component): array
    {
        $backtrace = array_slice(debug_backtrace(), 1);
        $backtrace_slice = array_slice($backtrace, 2);

        $frame = Arr::first($backtrace_slice, function (array $item) use ($component): bool {
            if ($item['function'] === 'execute') {
                return false;
            }

            if (
                isset($item['object'])
                    && Str::startsWith($item['object']::class, 'Modules\\')
                    && $item['object'] !== $component
            ) {
                return true;
            }

            if (isset($item['class']) && Str::startsWith($item['class'], 'Modules\\')) {
                $reflection_class = new \ReflectionClass($item['class']);
                if (! $reflection_class->isAbstract()) {
                    return true;
                }
            }

            return false;
        });

        return is_array($frame) ? $frame : [];
    }

    public function execute(Field|Entry|BaseFilter|Column|Step|Action|Section $component, string $type = 'label'): Field|Entry|BaseFilter|Column|Step|Action|Section
    {
        $class = $this->findCallerFrame($component);

        if ($class !== []) {
            // Un frame di `debug_backtrace()` non ha chiavi garantite: `object`
            // c'e' solo per le chiamate su un'istanza, `class` solo per quelle
            // su una classe, e una funzione libera non ha ne' l'una ne' l'altra.
            // Prima qui c'era `isset()` e poi l'uso diretto, che bastava perche'
            // PHPStan deduceva la forma del frame dal predicato di ricerca;
            // ora che la ricerca e' un metodo sovrascrivibile quella deduzione
            // non vale piu', ed e' giusto: una fixture puo' restituire
            // `['function' => 'foo']`, cioe' esattamente il frame senza nessuna
            // delle due chiavi (base_quaeris_fila5#234).
            $object = $class['object'] ?? null;
            $named = $class['class'] ?? null;

            $object_class = null;
            if (is_object($object)) {
                $object_class = $object::class;
            } elseif (is_string($named) && $named !== '') {
                $object_class = $named;
            }

            if ($object_class === null) {
                // Non si sa di chi sia il componente, quindi non si sa quale
                // chiave usare: si restituisce il componente come sta.
                //
                // Prima qui c'era `throw new \Exception('No object class
                // found')`. Questa action mette **etichette**: se non riesce a
                // indovinare il chiamante dallo stack delle chiamate, il
                // peggio che deve succedere e' un campo senza etichetta
                // tradotta — non una pagina che non si apre. Un `throw` qui
                // fa cadere il rendering di tutto il form per una questione
                // estetica.
                //
                // Era anche incoerente col ramo gemello: quando **nessun**
                // frame corrisponde, poco sotto, si ripiega su `lang::txt` e si
                // tira avanti. Quel caso e' piu' probabile di questo.
                //
                // In produzione non succede — il predicato di ricerca accetta
                // solo frame con `object` o `class` — e lo si vede solo
                // sovrascrivendo `findCallerFrame()`, come fa la fixture
                // `AutoLabelNullCallerStub`, il cui test si chiama appunto
                // «null caller frame returns component early»
                // (base_quaeris_fila5#234). Non si scrive niente nei file di
                // lingua, perche' una chiave inventata per un componente
                // senza padrone resterebbe li' per sempre.
                return $component;
            }

            $trans_key = app(GetTransKeyAction::class)->execute($object_class);
        } else {
            $trans_key = 'lang::txt';
        }

        $label_tkey = null;
        $val = 'no-set-val';
        // Valore da persistere quando la traduzione non esiste ancora. Di norma coincide
        // con il segmento di chiave, ma non sempre: vedi le sezioni senza titolo.
        $default_val = null;

        if ($component instanceof Step) {
            Assert::string($val = $component->getLabel());
            $label_tkey = $trans_key.'.steps.'.$val.'';
        }
        if ($label_tkey === null && $component instanceof Section) {
            $val = $component->getHeading();
            if ($val === null) {
                // Una sezione senza titolo e' una scelta: raggruppa i campi senza
                // annunciarsi. Serve comunque un segmento di chiave, e `empty` lo fa, ma
                // il valore salvato deve restare vuoto — altrimenti la prima visita
                // persiste la stringa "empty" e da li' in poi la sezione mostra quella
                // parola come intestazione.
                $val = 'empty';
                $default_val = '';
            }
            if (! is_string($val)) {
                $val = app(SafeStringCastAction::class)->execute($val);
            }
            $label_tkey = $trans_key.'.sections.'.$val.'';
        }
        if ($label_tkey === null && method_exists($component, 'getName')) {
            Assert::string($val = $component->getName());
            $label_tkey = $trans_key.'.fields.'.$val.'';
        }

        if ($component instanceof Action) {
            Assert::string($val = $component->getName());
            $label_tkey = $trans_key.'.actions.'.$val.'';
        }

        $label_key = $label_tkey.'.'.Str::snake($type);

        /*
         * Solo l'etichetta ha un ripiego sensato nel nome del campo. Per testo d'aiuto, segnaposto,
         * descrizione e simili il nome del campo («email», «value», «remember») finiva salvato nei file
         * lang e mostrato sotto ogni campo: si salva vuoto, e un valore uguale al nome non si applica.
         */
        $isAuxiliaryText = ! in_array($type, ['label', 'icon'], strict: true);
        if ($isAuxiliaryText) {
            $default_val ??= '';
        }

        $label = trans($label_key);
        // Se la traduzione manca si salva (solo in locale, vedi SaveTransAction) ma solo per l'etichetta:
        // per helper_text, placeholder, description e tooltip il "valore di comodo" era il nome del campo,
        // che poi compariva sotto e dentro i campi ("route", "postal_code"). Meglio nessun testo d'aiuto.
        if (is_string($label) && $label_key === $label && 'label' === $type) {
            app(SaveTransAction::class)->execute($label_key, $default_val ?? $val);
        }
        if ($isAuxiliaryText && is_string($label) && ($label === '' || $label === $val)) {
            return $component;
        }
        // Un'azione con l'etichetta ancora uguale al proprio nome («edit», «delete», «restore») tiene
        // l'etichetta già tradotta di Filament («Modifica», «Elimina», «Ripristina»).
        if ($component instanceof Action && is_string($label) && $label === $val) {
            return $component;
        }
        if (! is_string($label)) {
            $component->label('FIX:'.$label_key);

            return $component;
        }
        if ($label_key === $label || ! method_exists($component, $type)) {
            return $component;
        }
        /*
        if (is_string($label) && $label_key !== $label && method_exists($component, $type)) {

                if ($type === 'icon' && !app(SvgExistsAction::class)->execute($label)) {

                    $component->{$type}('heroicon-o-question-mark-circle');
                    return $component;
                }
                if (strip_tags($label) !== $label && in_array($type, ['helperText'], strict: true)) {
                    $component->{$type}(new HtmlString($label));
                } else {
                    $component->{$type}($label);
                }

        }
        */
        if ($type === 'icon' && app(SvgExistsAction::class)->execute($label)) {
            if (method_exists($component, 'iconButton')) {
                $component->iconButton();
            }
            $component->{$type}($label);

            // $component->label('FIX:'.$label_key);
            return $component;
        }
        if ($type === 'icon' && ! app(SvgExistsAction::class)->execute($label)) {
            // $component->{$type}($label);
            if (method_exists($component, 'iconButton')) {
                $component->iconButton();
            }

            // $component->label('FIX:'.$label_key);
            // $component->tooltip('FIX:'.$label_key);
            // $component->{$type}('heroicon-o-question-mark-circle');

            // $component->{$type}(null);
            return $component;
        }

        if (strip_tags($label) !== $label && in_array($type, ['helperText'], strict: true)) {
            $component->{$type}(new HtmlString($label));

            return $component;
        }

        $component->{$type}($label);

        return $component;
    }
}
