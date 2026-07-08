# Linee guida: evitare JS inline nelle Blade

Obiettivo
- Rimuovere script inline dalle view Blade in favore di bundling con Vite (resources/js) e inclusion via @vite o asset().

Regole raccomandate
1. Nessun JS inline nelle Blade salvo commenti tecnici.
2. Se serve early-boot (prima di Alpine/Livewire), fornire un piccolo asset "early-boot" generato dal build e referenziato con asset(...).
3. Factory Alpine (Alpine.data(...)) deve vivere in `resources/js/theme` e poi essere importata in `resources/js/app.js` quando possibile.
4. Per compatibilità legacy, usare uno shim no-op nei file early-boot che verrà sovrascritto dal bundle.

Procedure
- Sviluppo: modifica in `resources/js`, poi `npm run build && npm run copy`.
- Verifica: eseguire grep per pattern `<script>` su `resources/views` e generare task per ogni occorrenza.

Task consigliati
- Aggiungere un check CI che segnali Blade con tag `<script>` (escludere commenti) e richieda una giustificazione documentata nella docs del modulo.
- Consolidare shims in `themes/*/assets` e automatizzare copia via manifest.
