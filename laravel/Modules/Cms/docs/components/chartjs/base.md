---
title: Base
description: Base
extends: _layouts.documentation
section: content
path: it/docs/components/chartjs
---

# Base {#base}

Crea un grafico in Chartjs

Nome Componente:
```php
x-chartjs.base 
```

Parametri:

```php
string $chartid 
string $type (base)
array $labels
array $data
string $title
```

Esempio:

```php
<x-chartjs.base 
chartId="1" 
type="base" 
:labels="['day 1','day 2','day 3']" 
:data=[4,2,1] 
title="Valori Giornalieri"
>

</x-chartjs.base>
```

Per altre informazioni leggere documentazione [ChartJs](https://www.chartjs.org/docs/latest/).
## Collegamenti tra versioni di base.md
* [base.md](laravel/Modules/Chart/docs/components/chartjs/base.md)
* [base.md](laravel/Modules/Cms/docs/components/chartjs/base.md)

