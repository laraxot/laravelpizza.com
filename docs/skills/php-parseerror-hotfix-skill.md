# PHP ParseError Hotfix Skill

## Trigger
Fatal error con `ParseError`/`unexpected token` durante bootstrap Laravel.

## Workflow
1. Aprire file/linea indicati nello stack trace.
2. Cercare placeholder/commenti spezzati o merge markers.
3. Applicare fix minimo sintatticamente valido.
4. Lint immediato con `php -l` sul file.
5. Aggiornare issue/discussion con root cause + fix + esito verifica.
