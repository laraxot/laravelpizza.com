# Claude for Open Source — eligibility playbook

## Perché esiste questo documento

Anthropic offre **6 mesi di Claude Ultra** (piano top, include Claude Code) ai
maintainer/contributor open-source che superano **una** delle soglie ufficiali,
oppure via track discrezionale "ecosystem impact".

Fonte ufficiale: [Claude for Open Source](https://claude.com/contact-sales/claude-for-oss).

Questo playbook serve a:

1. misurare onestamente dove siamo;
2. scegliere la pista più realistica;
3. rendere **questa** repo una prova credibile di impatto OSS (non gaming).

## Requisiti di base (tutti)

- persona fisica, maggiorenne, paese supportato da Claude.ai;
- account GitHub **≥ 2 anni**, in buona fede;
- attività OSS pubblica negli ultimi **90 giorni**;
- almeno un progetto con licenza **OSI-approved** (qui: **MIT**);
- una sola subscription programma per persona.

`laraxot/laravelpizza.com` è pubblica, MIT, con attività recente: i requisiti
di base del progetto sono OK. La candidatura è **personale** (ogni maintainer
applica per sé).

## Soglie maintainer track (ne basta una)

| Pista | Soglia | Stato tipico di questa repo |
| --- | --- | --- |
| Dependents / packages | 500 repo dipendenti **o** 100 pacchetti | Non ancora (app starter, non libreria virale) |
| Downloads | 200k+/mese aggregati su registry | Non ancora (Packagist Laraxot << 200k) |
| Foundation committer | ruolo formale su progetto riconosciuto | Solo se il candidato lo ha altrove |
| Active contributor | **100+ PR merged** in repo **non** tuoi (12 mesi) | Misura sul profilo GitHub del candidato |
| Community builder | **20+ contributor esterni unici** con PR merged (12 mesi) | Gap principale da chiudere |
| OpenSSF criticality | score ≥ **0.4** | Improbabile a breve per un meetup starter |
| Ecosystem impact | narrativa + evidenze (discrezionale) | **Pista immediata** se spieghi bene Laraxot |

## Strategia business (DRY + KISS)

**Scopo del prodotto:** starter riusabile per meetup Laravel (Folio + Volt +
Filament + moduli Laraxot), non un e-commerce pizza.

**Politica OSS:** qualità e contribution reali battono vanity metrics. Anthropic
può scontare attività banale/automatizzata.

**Tre piste in parallelo:**

1. **Ora — Ecosystem impact**  
   Candidati con narrativa: piattaforma meetup chiavi-in-mano, 14 moduli
   PHPStan 10, tema Meetup, MIT, usato come base multi-tenant Laraxot.
2. **90 giorni — Community builder**  
   Obiettivo: ≥ 20 contributor esterni unici con **PR merged**.  
   Regola operativa: niente solo-push del maintainer per lavoro community;
   si accettano e mergiano PR da fork.
3. **Continuativo — Active contributor (personale)**  
   100+ PR merged su repo altrui (Laravel, Filament, upstream).  
   Indipendente da questa repo, ma vale per la stessa persona.

## Checklist repo (cosa deve essere vero prima di applicare)

- [x] LICENSE MIT in root
- [x] `CODE_OF_CONDUCT.md` in root
- [x] `SECURITY.md` con canale privato
- [x] `CONTRIBUTING.md` che spinge fork + PR
- [x] Issue templates + label `good first issue` / `help wanted`
- [x] Workflow OpenSSF Scorecard (`.github/workflows/openssf-scorecard.yml`)
- [x] Discussioni GitHub abilitate sul repo
- [x] Issue etichettate `good first issue` (parti da #585–#587 + label su #560/#574/#576)
- [ ] PR merged da contributor esterni (target: 20 unici in 12 mesi)
- [x] Attività pubblica recente sul repo (commit negli ultimi 90 giorni)

Misura lo stato con:

```bash
bash .github/scripts/claude-oss-eligibility-check.sh
# opzionale: passa login GitHub per la pista 100+ PR esterne
# bash .github/scripts/claude-oss-eligibility-check.sh laraxot/laravelpizza.com marco76tv
```

## Draft candidatura (max ~500 parole) — Ecosystem impact

Usa questo testo come base (personalizza numeri aggiornati dallo script):

> I maintain `laraxot/laravelpizza.com` (MIT), an open-source Laravel 12 starter
> for running real Laravel meetups: modular Laraxot architecture (14 modules),
> Filament 5 admin, Folio+Volt front office, PHPStan level 10, and a production
> Meetup theme. The goal is a replicable “meetup-in-a-box” for local PHP
> communities, not a toy demo.
>
> Why ecosystem impact: organizers and community builders need a opinionated,
> quality-gated Laravel stack that already encodes hard lessons (tenant theme
> resolution, localization, CMS blocks, XotBase Filament patterns). This repo
> packages those rules as runnable software + living docs in every module.
>
> How I will use Claude Ultra / Claude Code: triage community PRs faster, keep
> PHPStan 10 green across modules, write acceptance tests for Folio pages, and
> turn meetup organizer feedback into small merged contributions from newcomers
> (`good first issue` track).
>
> Evidence: public MIT repo, Code of Conduct, Security policy, Contributing
> guide that requires fork+PR, OpenSSF Scorecard workflow, and an active issue
> backlog labeled for external contributors.

Aggiungi link a: repo, CONTRIBUTING, 2–3 good first issue, Scorecard badge quando
disponibile, Packagist se rilevante.

## Cosa non fare

- Non inventare contributor o PR fake.
- Non contare bot/`claude` come contributor esterni umani.
- Non puntare solo alle stars: le soglie attuali non le usano.
- Non applicare due volte per “accelerare”: non aiuta.

## Dopo l’approvazione

- Attiva il codice entro **90 giorni**.
- I 6 mesi partono dall’attivazione.
- Gli overage oltre Ultra possono essere a pagamento.
- A fine periodo la subscription non rinnova da sola.

## Collegamenti

- [Contributing (root)](../CONTRIBUTING.md)
- [Contributing (docs)](contributing.md)
- [Code of Conduct](../CODE_OF_CONDUCT.md)
- [Security](../SECURITY.md)
- [MCP / Claude Code config](mcp-claude-code-configuration.md)
