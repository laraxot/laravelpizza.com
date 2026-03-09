# Mcamara Laravel Localization Memory

Memoria operativa:

- la locale prefissata nell'URL va risolta da `mcamara/laravel-localization` nel routing/middleware layer;
- i Blade non devono diventare il posto dove "si sistema" la lingua;
- i link tra lingue vanno generati con le API della libreria, non concatenando stringhe a mano;
- i test devono chiedere esplicitamente `/it`, `/en`, `/de` e verificare il risultato renderizzato.
