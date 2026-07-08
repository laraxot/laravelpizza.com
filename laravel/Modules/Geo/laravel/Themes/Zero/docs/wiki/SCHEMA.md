# Theme Zero Wiki — Schema e Convenzioni

## Dominio
Tema Zero per la piattaforma PTVX. Tema base/default con layout, stili e componenti Blade per l'interfaccia pubblica e amministrativa.

## Tipi di Entità
- **Class**: Classi PHP, traits, interfacce specifiche del modulo
- **Pattern**: Pattern architetturali usati nel modulo
- **Rule**: Vincoli rigidi che non devono mai essere violati
- **Decision**: Decisioni architetturali con relativa motivazione

## Entità Principali
- ZeroThemeServiceProvider: Provider del tema\n- ZeroLayout: Layout principale\n- ZeroComponent: Componenti Blade specifici

## Pattern Rilevanti
- Theme Pattern: override view Laravel\n- Component Pattern: componenti Blade riutilizzabili

## Protocollo di Ingest
1. Leggere il documento sorgente raw
2. Estrarre entità (classi, pattern, regole, decisioni)
3. Scrivere/aggiornare pagine entità in `entities/`
4. Scrivere/aggiornare pagine concetti in `concepts/`
5. Aggiungere un riassunto in `sources/`
6. Aggiornare il catalogo `index.md`
7. Appendere a `log.md`

## Convenzione Nomi File
- `concepts/{kebab-case}.md`
- `entities/{ClassName}.md`
- `comparisons/{a}-vs-{b}.md`
- `sources/{source-filename}.md`

## Regola Cross-linking
Ogni pagina DEVE linkare almeno un'altra pagina wiki.
Le pagine orfane sono un errore di lint.

## Standard di Qualità
- Nessuna claim obsoleta oltre 30 giorni senza ri-verifica
- Ogni pagina entità deve riferirsi al doc sorgente raw
- Le contraddizioni tra pagine devono essere risolte immediatamente
