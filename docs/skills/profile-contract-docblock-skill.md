# Skill: profile contract docblock

## Trigger

Quando ide-helper o un edit manuale genera PHPDoc per `creator`, `updater`, `deleter` o altre relazioni profilo trasversali.

## Workflow

1. cercare i PHPDoc generati nel cluster toccato;
2. verificare se il tipo usa un model concreto invece del contratto;
3. correggere al contratto `\Modules\Xot\Contracts\ProfileContract|null`;
4. aggiornare docs/rules/memory e tracking GitHub se la regola non era ancora esplicita.
