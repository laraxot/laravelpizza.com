# Correzione chiamate dinamiche ApplyMetatagToPanelAction → MetatagData

## Contesto
Nel pattern Laraxot/Xot, ogni chiamata `$panel->nome($metatag->getNome())` in `ApplyMetatagToPanelAction` presuppone che in `MetatagData` esista il metodo `getNome()`. Se mancante, va creato per garantire:
- Consistenza API tra Panel e DataObject
- Prevedibilità e automazione delle estensioni future
- Compliance con PHPStan livello 10 (tipizzazione, assenza di errori mixed, docblock)

## Procedura
1. **Individuazione chiamata mancante**: Se in `ApplyMetatagToPanelAction` compare una chiamata a `$panel->nome($metatag->getNome())` e in `MetatagData` manca `getNome()`, va implementato.
2. **Tipizzazione**: Il metodo deve essere fortemente tipizzato e documentato secondo le regole PHPStan livello 10.
3. **Documentazione**: Aggiornare questa guida e aggiungere nota di correzione in `docs/index.md` della root con collegamento a questa pagina.
4. **Collegamento bidirezionale**: In `docs/index.md` aggiungere link a questa guida e viceversa.

## Esempio
```php
// In ApplyMetatagToPanelAction.php
->brandLogo($metatag->getLogoHeader())
// In MetatagData.php
public function getLogoHeader(): string { ... }
```

## Regole PHPStan Livello 10
1. Tutti i metodi devono avere return type hint
2. Tutti i parametri devono avere type hint
3. I docblock devono essere completi e accurati
4. Non sono ammessi errori mixed
5. Le proprietà devono essere tipizzate
6. I metodi devono essere documentati con PHPDoc
7. Le eccezioni devono essere gestite e documentate
8. I valori di ritorno null devono essere esplicitamente dichiarati
9. Le dipendenze devono essere iniettate tramite constructor
10. I trait devono essere documentati

## Motivazione
Questo pattern consente:
- Estensibilità automatica delle API
- Riduzione errori runtime
- Facilità di refactoring e documentazione
- Compliance con gli standard di qualità PHPStan livello 10

---
**Ultima modifica:** 2025-04-16
**Collegamento indice:** [../../../../docs/index.md](../../../../docs/index.md)

## Metodi Validati
- `getBrandName()`: Restituisce il nome del brand (titolo della pagina)
- `getLogoHeader()`: Restituisce il percorso del logo dell'header
- `getLogoHeaderDark()`: Restituisce il percorso del logo dell'header per la modalità scura
- `getLogoHeight()`: Restituisce l'altezza del logo
- `getFavicon()`: Restituisce il percorso del favicon
- `getFilamentColors()`: Restituisce i colori formattati per Filament
- `getAllColors()`: Restituisce tutti i colori in formato chiave-valore
- `getColors()`: Restituisce l'array raw dei colori

## Note di Implementazione
1. Tutte le proprietà sono tipizzate con `@var` annotations
2. Tutti i metodi hanno return type hint
3. I docblock sono completi e descrittivi
4. Le dipendenze sono gestite tramite dependency injection
5. I trait sono documentati con il loro scopo
6. Le eccezioni sono gestite e documentate
7. I valori null sono esplicitamente dichiarati
8. Le strutture dati complesse sono tipizzate con array shapes
