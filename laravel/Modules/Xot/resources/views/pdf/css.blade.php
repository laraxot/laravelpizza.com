<?php

declare(strict_types=1);

?>
{{-- CSS Base per PDF - Componente riutilizzabile --}}
{{-- 
    Motivazione DRY: Evita duplicazione di stili CSS tra diversi template PDF
    Motivazione KISS: Componente con responsabilità singola e ben definita
    Riutilizzabilità: Può essere utilizzato in qualsiasi PDF del sistema
--}}

<style type="text/css">
    /* ===== STILI BASE ===== */
    body {
        font-family: Arial, sans-serif;
        font-size: 10px;
        line-height: 1.3;
    }

    /* ===== HEADINGS ===== */
    h1 {
        font-size: 16px;
        color: #0066CC;
        text-align: center;
        margin: 10px 0;
        border-bottom: 2px solid #0066CC;
        padding-bottom: 5px;
    }

    h2 {
        font-size: 14px;
        color: #0066CC;
        margin: 15px 0 8px 0;
        padding: 5px;
        background-color: #f0f7ff;
        border-left: 4px solid #0066CC;
    }

    h3 {
        font-size: 12px;
        color: #009246;
        margin: 10px 0 5px 0;
        background-color: #f0fff4;
        padding: 3px 5px;
        border-left: 3px solid #009246;
    }

    /* ===== TABELLE ===== */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
    }

    table.info td {
        border: 1px solid #ddd;
        padding: 6px;
        vertical-align: top;
    }

    table.info .label {
        background-color: #f8f9fa;
        font-weight: bold;
        color: #666;
        width: 30%;
        font-size: 9px;
    }

    table.info .value {
        font-size: 10px;
    }

    /* ===== STATI E ALERT ===== */
    .emergency {
        background-color: #ffe6e8;
        color: #ce2b37;
        padding: 8px;
        margin: 10px 0;
        border-left: 4px solid #ce2b37;
        font-weight: bold;
    }

    .status {
        padding: 2px 6px;
        font-size: 8px;
        font-weight: bold;
        text-transform: uppercase;
        border: 1px solid;
    }

    .status-scheduled {
        background-color: #e6f0ff;
        color: #0066cc;
        border-color: #0066cc;
    }

    .status-confirmed {
        background-color: #e6f7ed;
        color: #009246;
        border-color: #009246;
    }

    .status-completed {
        background-color: #f0f0f0;
        color: #666;
        border-color: #999;
    }

    .status-cancelled {
        background-color: #ffe6e8;
        color: #ce2b37;
        border-color: #ce2b37;
    }

    .status-pending {
        background-color: #fff3e6;
        color: #ff8c00;
        border-color: #ff8c00;
    }

    /* ===== ELEMENTI SI/NO ===== */
    .yes-no {
        padding: 2px 5px;
        font-size: 8px;
        font-weight: bold;
        text-transform: uppercase;
        border: 1px solid;
    }

    .yes {
        background-color: #e6f7ed;
        color: #009246;
        border-color: #009246;
    }

    .no {
        background-color: #ffe6e8;
        color: #ce2b37;
        border-color: #ce2b37;
    }

    /* ===== ELEMENTI MEDICALI ===== */
    .medical-item {
        background-color: #f9f9f9;
        border-left: 3px solid #009246;
        padding: 6px;
        margin-bottom: 8px;
    }

    .medical-question {
        font-weight: bold;
        color: #333;
        margin-bottom: 3px;
        font-size: 9px;
    }

    .medical-answer {
        color: #666;
        font-size: 8px;
    }

    /* ===== BOX E CONTAINER ===== */
    .detail-box {
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        padding: 4px;
        margin-top: 3px;
        font-size: 8px;
    }

    .detail-label {
        font-weight: bold;
        color: #0066cc;
    }

    .studio-box {
        background-color: #e6f0ff;
        border: 2px solid #0066cc;
        padding: 8px;
        margin: 10px 0;
    }

    .notes-box {
        background-color: #fff3e6;
        border: 2px solid #ff8c00;
        padding: 8px;
        margin: 10px 0;
    }

    /* ===== ELEMENTI SPECIFICI ===== */
    .disease-item,
    .tooth-item,
    .prosthesis-item,
    .tartar-item,
    .plaque-item {
        margin-left: 15px;
        font-size: 8px;
        color: #333;
    }

    /* ===== SEZIONI MEDICALI AVANZATE ===== */
    .medical-section {
        margin-bottom: 12px;
        page-break-inside: avoid;
    }

    .medical-section h3 {
        font-size: 12px;
        color: #2c5282;
        background-color: #ebf8ff;
        padding: 4px 8px;
        margin: 8px 0 4px 0;
        border-left: 3px solid #2b6cb0;
    }

    .medical-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 6px;
    }

    .medical-table td {
        padding: 4px 6px;
        vertical-align: top;
        border: 1px solid #e2e8f0;
        font-size: 9px;
    }

    .medical-table .medical-question {
        width: 50%;
        background-color: #f8fafc;
        font-weight: bold;
        color: #4a5568;
    }

    .medical-table .medical-answer {
        width: 50%;
        color: #2d3748;
    }

    /* ===== UTILITY CLASSES ===== */
    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    .text-left {
        text-align: left;
    }

    .font-bold {
        font-weight: bold;
    }

    .font-normal {
        font-weight: normal;
    }

    .text-sm {
        font-size: 8px;
    }

    .text-base {
        font-size: 10px;
    }

    .text-lg {
        font-size: 12px;
    }

    .text-xl {
        font-size: 14px;
    }

    .text-2xl {
        font-size: 16px;
    }

    /* ===== RESPONSIVE PER PDF ===== */
    @page {
        margin: 15mm;
    }

    /* ===== PAGE BREAKS ===== */
    .page-break {
        page-break-before: always;
    }

    .avoid-break {
        page-break-inside: avoid;
    }

    /* ===== PRINT OPTIMIZATIONS ===== */
    @media print {
        body {
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
        }
    }
</style>
