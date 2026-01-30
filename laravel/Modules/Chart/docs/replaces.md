# Sostituzioni e Aggiornamenti

> **Nota**: Per una versione più aggiornata e dettagliata di questa documentazione, consulta [Replaces in Bashscripts](../bashscripts/docs/replaces.md)

public static function form\(Form \$form\): Form\s*\{\s*return \$form\s*->schema\(\[\s*([\s\S]*?)\s*\]\);\s*\}



public static function getFormSchema(): array
    {
        return [
            $1
        ]; 
    }

---------------------------------------------


public static function table\(Table \$table\): Table\s*\{[\s\S]*?\n\s*\}

## Collegamenti tra versioni di replaces.md
* [replaces.md](../bashscripts/docs/replaces.md)
* [replaces.md](replaces.md)

