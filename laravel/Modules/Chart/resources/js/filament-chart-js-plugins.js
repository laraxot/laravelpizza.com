import ChartDataLabels from 'chartjs-plugin-datalabels';

window.filamentChartJsPlugins ??= [];
window.filamentChartJsPlugins.push(ChartDataLabels);

const tooltipNote = {
    id: 'tooltipNote',
    beforeDraw: chart => {
      console.log('chart');
    }
  }

  const doughnutLabel={
    id: 'doughnutLabel',
    ///*
    beforeDatasetsDraw(chart, args, pluginOptions){
        if(chart.config.options.plugins.doughnutLabel== undefined){
            return;
        }
        const{ctx,data}=chart;
        ctx.save();
        const xCoor= chart.getDatasetMeta(0).data[0].x;
        const yCoor= chart.getDatasetMeta(0).data[0].y;
        ctx.font = 'bold 30px sans-serif';
        ctx.fillStyle = "rgba(0, 0, 0, 1)";
        ctx.textAlign = 'center';
        ctx.textBaseLine = 'middle';
        //var text=data.labels[0];
        //console.log(chart.config.options.plugins.doughnutLabel.label);
        var text=chart.config.options.plugins.doughnutLabel.label;
        
        ctx.fillText(text,xCoor,yCoor);
    }
    //*/
   /*
    afterDatasetsDraw(chart, args, options) {
        const {ctx, chartArea: {left, right, top, bottom, width, height}} = chart;

        ctx.save();

        var fontSize = width * 4.5 / 100;
        var lineHeight = fontSize + (fontSize * {{$take}} / 100);

        ctx.font = "bolder " + fontSize + "px Arial";
        ctx.fillStyle = "rgba(0, 0, 0, 1)";
        ctx.textAlign = "center";
        ctx.fillText("{{$average}}", width / 2, (height / 2 + top - (lineHeight)));
        ctx.restore();

        ctx.font = fontSize + "px Arial";
        ctx.fillStyle = "rgba(0, 0, 0, 1)";
        ctx.textAlign = "center";
        ctx.fillText("MEDIA", width / 2, (height / 2 + top) + fontSize - lineHeight);
        ctx.restore();

        ctx.font = fontSize + "px Arial";
        ctx.fillStyle = "rgba(0, 0, 0, 1)";
        ctx.textAlign = "center";
        ctx.fillText("COMPLESSIVA", width / 2, (height / 2 + top) + fontSize);
        ctx.restore();
    }
    */
  }


  // const percYLabel={
  //   id: 'percYLabel',
  //   ///*
  //   beforeDatasetsDraw(chart){
  //       if(chart.config.options.scales.y.ticks.callback.label== undefined){
  //           return;
  //       }
  //       const{ctx,data}=chart;
  //       ctx.save();
  //       var text=chart.config.optionsscales.y.ticks.callback.label + '%';
        
  //       ctx.fillText(text);
  //   }
  // }
 
window.filamentChartJsPlugins ??= []
//window.filamentChartJsPlugins.push(tooltipNote);
window.filamentChartJsPlugins.push(doughnutLabel);
