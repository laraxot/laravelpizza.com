// Catalogo A2UI del pannello: catalogo base + Stat (KPI), Chart (Chart.js) e DataTable.
// Deve coincidere con BuildA2uiSurfaceAction::PANEL_CATALOG e ValidateA2uiComponentsAction (lato server).
// Pattern da datomatic/laravelday-2026 (MIT).
import { html, nothing } from 'lit';
import { z } from 'zod';
import { A2uiLitElement, basicCatalog } from '@a2ui/web_core/v1_0';
import {
    ArcElement, BarController, BarElement, CategoryScale, Chart, DoughnutController, Filler, Legend,
    LinearScale, LineController, LineElement, PieController, PointElement, Tooltip,
} from 'chart.js';

export const PANEL_CATALOG = 'urn:laraxot:a2ui:panel';

Chart.register(ArcElement, BarController, BarElement, CategoryScale, DoughnutController, Filler, Legend, LinearScale, LineController, LineElement, PieController, PointElement, Tooltip);
Chart.defaults.font.family = getComputedStyle(document.documentElement).fontFamily;
Chart.defaults.color = '#6b7280';

const PALETTE = ['#d97706', '#0284c7', '#059669', '#7c3aed', '#db2777', '#0d9488', '#dc2626', '#6b7280'];
const locale = () => document.documentElement.lang || 'it-IT';
const isCircular = (type) => type === 'pie' || type === 'doughnut';
// Etichette lunghe non stanno sotto barre verticali: in quel caso barre orizzontali.
const isHorizontal = ({ type, labels }) => type === 'bar' && labels.some((label) => label.length > 18);

const formatValue = (value, unit) => {
    const formatted = Number(value).toLocaleString(locale());
    if (!unit) return formatted;

    return unit === '%' ? `${formatted}%` : `${formatted} ${unit}`;
};

function chartConfig(props) {
    const circular = isCircular(props.type);
    const horizontal = isHorizontal(props);
    const valueAxis = horizontal ? 'x' : 'y';
    const categoryAxis = horizontal ? 'y' : 'x';

    return {
        type: props.type === 'area' ? 'line' : props.type,
        data: {
            labels: props.labels,
            datasets: props.datasets.map((dataset, index) => {
                const color = PALETTE[index % PALETTE.length];

                return {
                    label: dataset.label,
                    data: dataset.data,
                    backgroundColor: circular ? props.labels.map((_, i) => PALETTE[i % PALETTE.length]) : props.type === 'area' ? `${color}33` : color,
                    borderColor: circular ? '#ffffff' : color,
                    borderWidth: props.type === 'bar' ? 0 : 2,
                    borderRadius: props.type === 'bar' ? 6 : 0,
                    maxBarThickness: 28,
                    fill: props.type === 'area',
                    tension: 0.35,
                    pointRadius: 3,
                    pointBackgroundColor: color,
                };
            }),
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: horizontal ? 'y' : 'x',
            animation: { duration: 400 },
            plugins: {
                legend: { display: circular || props.datasets.length > 1, position: circular ? 'right' : 'top', labels: { boxWidth: 12, boxHeight: 12 } },
                tooltip: { callbacks: { label: (context) => `${circular ? context.label : context.dataset.label}: ${formatValue(context.raw, props.unit)}` } },
            },
            scales: circular ? {} : {
                [categoryAxis]: { grid: { display: false }, border: { display: false } },
                [valueAxis]: { beginAtZero: true, border: { display: false }, ticks: { precision: 0, callback: (value) => formatValue(value, props.unit) } },
            },
        },
    };
}

// Light DOM: lo stile viene da STYLES, iniettato una volta nella pagina.
class LightElement extends A2uiLitElement {
    createRenderRoot() {
        return this;
    }

    // weight = quota di spazio nella Row: il catalogo base la applica ai suoi componenti, non a questi.
    willUpdate(changed) {
        super.willUpdate?.(changed);
        const weight = this.controller?.props?.weight;
        this.style.flex = weight ? `${weight} 1 0%` : '';
        this.style.minWidth = weight ? '0' : '';
    }
}

class ChartElement extends LightElement {
    render() {
        const props = this.controller?.props;
        if (!props) return nothing;
        const height = isHorizontal(props) ? Math.max(220, props.labels.length * 36 + 40) : isCircular(props.type) ? 260 : 280;

        return html`<figure class="a2p-chart"><figcaption>${props.title}</figcaption><div style="height:${height}px"><canvas role="img" aria-label=${props.title}></canvas></div></figure>`;
    }

    updated() {
        const props = this.controller?.props;
        this.chart?.destroy();
        this.chart = props ? new Chart(this.querySelector('canvas'), chartConfig(props)) : null;
    }

    disconnectedCallback() {
        super.disconnectedCallback();
        this.chart?.destroy();
        this.chart = null;
    }
}
ChartElement.tagName = 'a2p-chart';

class StatElement extends LightElement {
    render() {
        const props = this.controller?.props;
        if (!props) return nothing;
        const trend = props.trend?.trim();
        const value = typeof props.value === 'number' ? props.value.toLocaleString(locale()) : props.value;

        return html`<div class="a2p-stat">
            <span class="a2p-stat-label">${props.label}</span>
            <span class="a2p-stat-value">${value}</span>
            ${trend || props.caption ? html`<span class="a2p-stat-caption">${trend ? html`<span class=${trend.startsWith('-') ? 'a2p-trend is-down' : 'a2p-trend'}>${trend}</span> ` : nothing}${props.caption ?? nothing}</span>` : nothing}
        </div>`;
    }
}
StatElement.tagName = 'a2p-stat';

class DataTableElement extends LightElement {
    render() {
        const props = this.controller?.props;
        if (!props) return nothing;
        const cell = (value) => html`<td class=${typeof value === 'number' ? 'is-number' : ''}>${typeof value === 'number' ? value.toLocaleString(locale()) : value}</td>`;

        return html`<figure class="a2p-table">
            ${props.title ? html`<figcaption>${props.title}</figcaption>` : nothing}
            <div class="a2p-table-scroll"><table>
                <thead><tr>${props.columns.map((column) => html`<th scope="col">${column}</th>`)}</tr></thead>
                <tbody>${props.rows.map((row) => html`<tr>${row.map(cell)}</tr>`)}</tbody>
            </table></div>
        </figure>`;
    }
}
DataTableElement.tagName = 'a2p-data-table';

// weight = quota di spazio in una Row (applicata da LightElement).
const weight = z.number().optional();
const textOrNumber = z.union([z.string(), z.number()]);

const component = (name, element, shape) => ({ name, tagName: element.tagName, element, schema: z.object({ ...shape, weight }).strict() });

export const panelCatalog = basicCatalog.derive({
    catalogId: PANEL_CATALOG,
    components: [
        ...basicCatalog.components.values(),
        component('Chart', ChartElement, {
            title: z.string(),
            type: z.enum(['bar', 'line', 'area', 'pie', 'doughnut']),
            labels: z.array(z.string()),
            datasets: z.array(z.object({ label: z.string(), data: z.array(z.number()) })),
            unit: z.string().optional(),
        }),
        component('Stat', StatElement, { label: z.string(), value: textOrNumber, caption: z.string().optional(), trend: z.string().optional() }),
        component('DataTable', DataTableElement, { title: z.string().optional(), columns: z.array(z.string()), rows: z.array(z.array(textOrNumber)) }),
    ],
});

export const STYLES = `
.a2p-surface{display:block;max-width:100%}
.a2p-stat{box-sizing:border-box;height:100%;display:flex;flex-direction:column;gap:2px;padding:12px 14px;border:1px solid rgb(229 231 235);border-radius:12px}
.a2p-stat-label{font-size:12px;color:rgb(107 114 128)}
.a2p-stat-value{font-size:26px;font-weight:600;line-height:1.2}
.a2p-stat-caption{font-size:12px;color:rgb(107 114 128)}
.a2p-trend{color:rgb(5 150 105);font-weight:600}.a2p-trend.is-down{color:rgb(220 38 38)}
.a2p-chart,.a2p-table{margin:0;padding:12px 14px;border:1px solid rgb(229 231 235);border-radius:12px}
.a2p-chart figcaption,.a2p-table figcaption{font-weight:600;font-size:14px;margin-bottom:8px}
.a2p-table-scroll{overflow-x:auto}.a2p-table table{width:100%;border-collapse:collapse;font-size:13px}
.a2p-table th{text-align:left;font-weight:600;color:rgb(107 114 128);border-bottom:1px solid rgb(229 231 235);padding:6px 8px}
.a2p-table td{border-bottom:1px solid rgb(243 244 246);padding:6px 8px;vertical-align:top}.a2p-table td.is-number{text-align:right;font-variant-numeric:tabular-nums}
.dark .a2p-stat,.dark .a2p-chart,.dark .a2p-table{border-color:rgb(255 255 255 / .1)}
.dark .a2p-table th{border-color:rgb(255 255 255 / .1)}.dark .a2p-table td{border-color:rgb(255 255 255 / .05)}
`;
