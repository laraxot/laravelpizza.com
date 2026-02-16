# Regole Namespace PSR-4 per Tutti i Moduli (Regola Globale)

## Regola Fondamentale
- **Mai** usare il segmento `App` nel namespace delle classi di un modulo.
- Il namespace deve essere sempre:
  ```php
  namespace Modules\<NomeModulo>\<Directory>;
  ```
  Anche se la classe si trova in `app/`, il namespace NON deve includere `App`.

## Regola PSR-4
- Il namespace riflette la struttura delle directory a partire da `Modules/<NomeModulo>/app/`, senza includere `app`.
- Esempio:
  - File: `Modules/Notify/app/Console/Commands/AnalyzeTranslationFiles.php`
  - Namespace: `Modules\Notify\Console\Commands`

## Applicazione
- Questa regola si applica a **tutti** i moduli (Notify, Cms, Xot, ecc.), **inclusi i modelli**.
- Evitare l'uso di proprietà deprecate come `protected $casts` nei modelli: preferire override tramite metodo `casts()`.
- Per esempi specifici, vedere la documentazione nei singoli moduli:
  - [Patient: Regole Modelli](../../Patient/project_docs/models.md)
  - [Notify Namespace Rules](../../Notify/project_docs/NAMESPACE_RULES.md)

## Collegamenti
- [Regole Namespace Moduli - Root Docs](../../../project_docs/namespace-moduli.md)

---

**Ultimo aggiornamento:** 2025-05-13

**Link bidirezionale:** Aggiornare anche la root docs e la docs dei moduli coinvolti.
