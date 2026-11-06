# Piano di completamento — UI

## Scopo
Fornire componenti, layout e primitive condivise per interfacce Filament e frontoffice coerenti e accessibili.

## Piano BMAD

1. Mappare componenti, contratti di rendering, icone, form, tabelle, layout e temi consumatori.
2. Uniformare API Filament supportate, stati vuoti, accessibilità e traduzioni senza creare wrapper inutili.
3. Verificare `live()`/reattività, rendering icone e compatibilità con i pannelli.
4. Verificare `SettingPage` e configurazione UI solo dove esiste una decisione reale.
5. Chiudere PHPStan, test Livewire/Filament, lint e audit visuale mirato.

## Criteri di accettazione
I componenti sono riusabili, tipizzati, accessibili e non impongono assunzioni di dominio ai moduli consumatori.

