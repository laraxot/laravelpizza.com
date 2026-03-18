# Risoluzione Conflitto: XotBaseServiceProvider

## Contesto
`XotBaseServiceProvider` è la classe base per i Service Provider dei moduli Xot. Gestisce la registrazione di risorse, provider, componenti Blade/Livewire e icone SVG. Un recente conflitto git ha evidenziato due approcci:

- **HEAD**: approccio tradizionale, meno dipendenze, meno flessibile.
- **Branch**: uso di azioni dedicate, maggiore modularità, robustezza tramite Assert, registrazione dinamica delle risorse.

## Decisione Architetturale
Si è scelto di integrare le migliorie del branch:
- Uso di azioni dedicate per path e risorse (es. `GetModulePathByGeneratorAction`)
- Registrazione dinamica delle icone SVG tramite `BladeUI\Icons\Factory`
- Uso di `Webmozart\Assert\Assert` per robustezza
- Retrocompatibilità ove possibile

### Motivazione
Questa scelta garantisce:
- Maggiore modularità e testabilità
- Facilità di estensione per i moduli figli
- Allineamento con la filosofia Laraxot e PSR
- Migliore mantenibilità futura

## Impatti
- Tutti i moduli Xot dovranno estendere la nuova base
- Possibile refactor per la registrazione di risorse custom

## Collegamenti
- [Struttura moduli Xot](./MODULE_NAMESPACE_RULES.md)
- [Best Practices Provider](./BEST-PRACTICES.md)
- [docs/links.md globale](../../../../project_docs/links.md)

## Backlink
- [docs/links.md](../../../../project_docs/links.md)
- [docs/MODULE_NAMESPACE_RULES.md](./MODULE_NAMESPACE_RULES.md)
- [docs/BEST-PRACTICES.md](./BEST-PRACTICES.md)
