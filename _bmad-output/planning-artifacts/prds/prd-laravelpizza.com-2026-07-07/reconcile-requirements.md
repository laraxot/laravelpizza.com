# Reconciliation: PRD FR-1..FR-21 vs .planning/REQUIREMENTS.md

**Source input:** `.planning/REQUIREMENTS.md`
**Target:** `prd.md` (FR-1 – FR-21, §4, §5, §6)

## Coverage Matrix

| REQUIREMENTS.md ID | PRD FR | Match | Notes |
|---|---|---|---|
| ADMN-01 | FR-1 | Faithful | Create/edit/delete Event, incl. venue/performers/sponsors/capacity |
| ADMN-02 | FR-2 | Faithful | Manage Venues/Performers/Sponsors, association to Events |
| ADMN-03 | FR-3 | Faithful | Dashboard with event/registration stats |
| ADMN-04 | FR-4 | Altered (minor scope add) | Original: "manage registrations and attendee lists". PRD FR-4 adds "esportare" (export) capability not present in source requirement or its FR-001 reference. Not necessarily wrong, but it is an added capability not traceable to REQUIREMENTS.md — should be flagged as a PRD-introduced addition, not silently folded into ADMN-04. |
| EVNT-01 | FR-5 | Faithful | Browse upcoming events, no auth |
| EVNT-02 | FR-6 | Faithful | Past events list |
| EVNT-03 | FR-7 | Faithful | Detail page with all metadata |
| EVNT-04 | FR-8 | Faithful | Filter by city/date |
| REGS-01 | FR-9 | Faithful | Register with valid email |
| REGS-02 | FR-10 | Faithful | Immediate email confirmation |
| REGS-03 | FR-11 | Faithful | Over-registration prevention; PRD correctly carries over the "already implemented" (✅) status matching the `[x]` checkbox in REQUIREMENTS.md |
| CMSP-01 | FR-12 | Faithful | Pages rendered from JSON |
| CMSP-02 | FR-13 | Faithful | Content blocks: text, images, event lists |
| CMSP-03 | FR-14 | Faithful | Update via JSON, no deploy |
| LOCL-01 | FR-15 | Faithful | IT/EN via URL locale prefix |
| LOCL-02 | FR-16 | Faithful | Locale switcher on any page |
| LOCL-03 | FR-17 | Faithful | No hardcoded strings |
| QUAL-01 | FR-18 | Faithful | Cookie consent before non-essential cookies |
| QUAL-02 | FR-19 | Faithful | WCAG 2.1 AA |
| QUAL-03 | FR-20 | Faithful | title/meta description/canonical URL |
| QUAL-04 | FR-21 | Faithful | JSON-LD structured data on event detail |

**Result:** All 21 v1 requirements (ADMN-01..04, EVNT-01..04, REGS-01..03, CMSP-01..03, LOCL-01..03, QUAL-01..04) are present in the PRD's FR-1..FR-21 list. Numbering is a clean 1:1 sequential remap (no gaps, no duplicates, no reordering across features).

## v2 / Out-of-Scope Reconciliation

| REQUIREMENTS.md item | PRD location | Match |
|---|---|---|
| PAYM-01 (Stripe/Apple Pay) | §5 Non-Goal, §6.2 Out of Scope | Faithful |
| PAYM-02 (automated invoicing/receipts) | Not explicitly mentioned | **Gap** — PRD §6.2 only says "Pagamenti/biglietti a pagamento (Stripe/Apple Pay) — v2", which covers PAYM-01 but does not explicitly mention invoicing/receipt generation (PAYM-02). It's arguably implied as a sub-item of "payments," but it's not named, unlike COMM-01/02 which are both named individually. |
| COMM-01 (user profiles w/ attendance history) | §5 Non-Goal, §6.2 | Faithful ("Profili utente con storico partecipazioni") |
| COMM-02 (public performer profiles/bios) | §6.2 | Faithful ("profili pubblici Relatori") |
| Out of Scope: Real-time chat | §5, §6.2 | Faithful |
| Out of Scope: Native Apps | §5, §2.2, §6.2 | Faithful |
| Out of Scope: Live streaming | §5, §6.2 | Faithful |
| Out of Scope: External OAuth | §5, §2.2, §6.2 | Faithful |

## Findings Summary

1. **Minor scope addition, not a gap but a traceability issue**: FR-4 (ADMN-04) adds an "esportare" (export) capability for attendee lists that has no basis in REQUIREMENTS.md's ADMN-04 text or FR-001 reference. Should either be tagged `[ASSUMPTION]` in the PRD or removed to keep strict 1:1 traceability.
2. **PAYM-02 (invoicing/receipts) not individually named** in PRD Non-Goals/Out-of-Scope — only the parent payments item (PAYM-01) is explicit. Low severity since it's a logical sub-component of "payments," but strict traceability would name it.
3. No missing v1 requirement: all 21 items map 1:1 to FR-1..FR-21 with consistent meaning.
4. No altered meaning detected beyond the FR-4 export addition noted above.
5. REGS-03's "already implemented" status is correctly and faithfully preserved from the source `[x]` checkbox into FR-11's "✅ già implementato" annotation.

## Verdict

The PRD's FR-1..FR-21 list is **substantively complete and faithful** to REQUIREMENTS.md. Two low-severity issues found: (a) an untraced scope addition in FR-4 (export capability), and (b) PAYM-02 not individually named in the Out-of-Scope section (only its parent PAYM-01 is named). No missing requirements, no altered core meanings, and all v2/out-of-scope items are otherwise correctly reflected.
