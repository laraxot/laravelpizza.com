Sto lavorando sul nav pubblico del tema `Meetup` con due obiettivi collegati:

1. impedire che su locale non italiana compaiano ancora `Accedi` / `Registrati` per via di stringhe Blade hardcoded;
2. migliorare la gerarchia UX dei CTA auth, mantenendo `login` come secondary action e `register` come primary CTA.

Direzione implementativa:

- usare solo `pub_theme::navigation.auth.login` e `pub_theme::navigation.auth.register`;
- riallineare i file `navigation.php` delle locale principali;
- rafforzare stile e affordance dei bottoni desktop/mobile;
- aggiungere Pest test sulla home localizzata reale per bloccare regressioni.
