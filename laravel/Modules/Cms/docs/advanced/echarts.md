---
title: Echarts
description: Echarts
extends: _layouts.documentation
section: content
path: it/docs/advanced/
---

# Echarts {#echarts}

Echarts è una libreria JavaScript open-source per la creazione di grafici e visualizzazioni dei dati. Può essere utilizzata con Laravel, un framework PHP per lo sviluppo di applicazioni web, e Apache, un server web open-source.

Per utilizzare Echarts con Laravel e Apache, dovrai prima installare e configurare Laravel e Apache sul tuo computer. Una volta fatto ciò, puoi seguire i seguenti passaggi:

Installa Echarts utilizzando il gestore dei pacchetti npm:

```console
npm install echarts --save
```

Importa Echarts nel tuo file JavaScript utilizzando il seguente codice:

```javascript
import echarts from 'echarts';
```

Crea un nuovo grafico utilizzando il seguente codice:

```javascript
let myChart = echarts.init(document.getElementById('myChart'));
```

Definire i dati per il grafico utilizzando il seguente codice:

```javascript
let data = [120, 200, 150, 80, 70, 110, 130];
```

Definire le opzioni per il grafico utilizzando il seguente codice:

```javascript
let options = {
    xAxis: {
        type: 'category',
        data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
    },
    yAxis: {
        type: 'value'
    },
    series: [{
        data: data,
        type: 'line'
    }]
};
```

Imposta le opzioni per il grafico utilizzando il seguente codice:

```javascript
myChart.setOption(options);
```

Mostra il grafico utilizzando il seguente codice:

```javascript
myChart.showLoading();
```

In questo modo, puoi utilizzare Echarts con Laravel e Apache per creare un grafico e visualizzare i dati. Tuttavia, questo è solo un semplice esempio e puoi personalizzare il codice per soddisfare le tue esigenze specifiche.




## Collegamenti tra versioni di echarts.md
* [echarts.md](laravel/Modules/Chart/docs/advanced/echarts.md)
* [echarts.md](laravel/Modules/Cms/docs/advanced/echarts.md)

