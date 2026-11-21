---
title: "Notify Module — Document"
type: docs/bmad
status: active
module: Notify
scope: documentation
bmad_version: 1.0
updated: 2026-10-06
---

# Notifica — Fix Blade preview (scopo: anteprima mail notifica)
- Funzionalità: preview HTML/Text della mail notifica (`preview-mail-template.blade.php`).
- Errore: residuo `{cat << 'EOF' ...` (tentativo generazione logo.svg inline).
- Correzione: rimosso residuo, ripristinato `{!! $this->record->body_html !!}`.
- Lezione (BMAD): mai mescolare generazione shell (cat <<) con Blade.
