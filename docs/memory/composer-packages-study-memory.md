# Composer Packages Study Memory

Snapshot 2026-03-02:
- pacchetti installati: 312
- diretti: 62
- transitivi: 250

Invarianti:
- rendering frontoffice dipende da Folio + CMS JSON + namespace `pub_theme::`.
- regressioni admin dipendono soprattutto da Filament/Livewire.
- mismatch tra composer modulo e lock e' segnale di rischio operativo immediato.

Rischi aperti:
- moduli con pacchetti dichiarati non installati (vedi package study).
