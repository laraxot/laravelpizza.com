# Matrice delle impostazioni delle SettingPage

La pagina Filament è una superficie tenant-scoped. La sorgente di verità è la ConfigData;
il file config/{tenant}/{module}.php conserva l’override e la configurazione globale
fornisce il default. Le chiavi non gestite dal form vengono preservate dal merge.

| Tipo | Controllo | Regola |
|---|---|---|
| booleano | Toggle | default esplicito, nessun valore nullo |
| intero | TextInput | numeric, integer, limite minimo |
| elenco breve | TagsInput | valori stringa validati |
| scelta | Select | opzioni finite e default noto |
| segreto | EnvWidget | mai in ConfigData o nel log |

CMS e Xot devono puntare a xra.php, perché pub_theme e adm_theme sono consumati da
XotData e dai namespace Blade pub_theme/adm_theme. Salvare un duplicato in cms.php
non cambia il tema effettivo.
