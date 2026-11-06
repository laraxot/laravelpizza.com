# Piano di completamento — Lang

## Scopo
Gestire traduzioni, chiavi, fallback, sincronizzazione e cambio lingua in modo coerente tra runtime e pannelli.

## Piano BMAD

1. Mappare caricamento, precedenza, fallback, editor, sincronizzazione e refresh del pannello.
2. Preservare le chiavi esistenti e distinguere contenuto tradotto da configurazione tecnica.
3. Sostituire API deprecate con il pattern Filament supportato e testare il cambio locale.
4. Verificare la `SettingPage` e la relativa traduzione senza duplicare fonti.
5. Chiudere gate statici, Pest e audit delle chiavi mancanti.

## Criteri di accettazione
Il cambio lingua aggiorna la UI senza perdita di stato, il fallback è deterministico e le chiavi sono mantenibili.

