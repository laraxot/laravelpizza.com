---
title: "login page status"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "login page status"
issues: []
discussions: []
status: draft
---

# Status pagina login: documento estraneo (deprecato)

Questo documento descriveva una pagina di login basata su
`Modules\User\Filament\Widgets\Auth\LoginWidget` con template
`Themes/Sixteen/resources/views/pages/auth/login.blade.php` e URL
`http://127.0.0.1:8000/it/auth/login`.

**Non e' pertinente a questo repository.** Questo progetto (`base_quaeris_fila5`)
usa il tema "Zero", non "Sixteen", e la pagina di login reale e' la classe
nativa Filament `Filament\Auth\Pages\Login` servita dai panel Filament
(`/admin/login`, `/{modulo}/admin/login`, vedi `php artisan route:list --path=login`),
non un widget Livewire custom in un tema Blade. Con ogni probabilita' e' stato
copiato da un progetto sibling dello stesso ecosistema mono-repo
(`base_fixcity_fila5_mono` o `base_ptv_fila5_mono`).

Trovato e segnalato durante l'investigazione del bug Livewire "This page has
expired" al login: vedi
`Modules/Xot/docs/stories/login-page-expired-investigation-2026-09-11.story.md`
e https://github.com/laraxot/module_xot_fila5/issues/119 per la causa reale e
il fix di questo repo.

Contenuto originale rimosso perche' fuorviante: descriveva file/percorsi che
non esistono in questo progetto e rischiava di far perdere tempo a chi lo
avesse usato come riferimento.
