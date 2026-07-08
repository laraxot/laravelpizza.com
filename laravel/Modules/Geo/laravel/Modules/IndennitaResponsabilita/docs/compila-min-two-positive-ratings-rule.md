# Compila Indennita Responsabilita: vincolo minimo 2 valutazioni > 0

## Contesto
Nella pagina `CompilaIndennitaResponsabilita` la legenda richiede che il salvataggio sia consentito solo se **almeno 2 campi valutazione** hanno un valore strettamente maggiore di `0`.

Riferimento implementativo:
- `Modules/IndennitaResponsabilita/app/Filament/Resources/IndennitaResponsabilitaResource/Pages/CompilaIndennitaResponsabilita.php`

## Regola applicata
Prima dell'update delle pivot `ratings`, viene eseguita una validazione di business:

- considera solo le valutazioni **editabili** (`is_readonly = false`)
- conta i valori numerici `> 0`
- se il conteggio e' inferiore a 2, interrompe il salvataggio con `ValidationException`

Messaggio mostrato:
- `Almeno 2 valutazioni devono avere un valore maggiore di 0.`

## Scelte architetturali
- Regola centralizzata in metodo dedicato: `ensureAtLeastTwoPositiveRatings()`
- Invocazione nel `save()` prima di `updateExistingPivot()`
- Costante esplicita per soglia minima: `MIN_POSITIVE_RATINGS = 2`

Questo mantiene il codice DRY+KISS e rende il vincolo semplice da modificare in futuro.

## Note di compatibilita
La regola non altera il pattern Filament/Xot gia' adottato:
- `infolist(Schema $schema): Schema` per dati read-only
- `getFormSchema()` per campi editabili
- nessun override di metodi `final` della `XotBasePage`

## Collegamenti
- `Modules/IndennitaResponsabilita/docs/infolist_compila_page_fix.md`
- `Modules/Xot/docs/filament/min_two_positive_ratings_rule.md`
