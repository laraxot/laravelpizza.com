<style type="text/css">
    :root {
        --border-strong: 3px solid #777;
        --border-normal: 1px solid gray;
    }

    body {
        font-size: 6pt;
    }

    table.morpion {
        border: solid 1px #444444;
    }

    table.morpion td {
        border-left: solid 1px #000000;
        border-bottom: solid 1px #000000;
        text-align: left;
        valign: top;
        font-size: 6.3pt;
        height: 12px;
        padding: 1px;
    }

    table.morpion th {
        border-left: solid 1px #000000;
        border-bottom: solid 1px #000000;
        text-align: left;
        valign: top;
        font-size: 7pt;
        height: 40px;
    }

    td.verticale {
        writing-mode: tb-rl;
        filter: flipv fliph;
    }

    .alt {
        background-color: #C0F0C0;
    }

    .rot {
        rotate: 90;
        text-align: center;
        height: 100%;
        width: 100%;
        padding: 0px;
    }

    .thead {
        width: 30px;
        text-align: center;
        vertical-align: middle;
    }

    table{
        width:100%;
    }
    table, table td, table th{
        border-collapse: collapse;
        /*border: solid 1px #ababab;*/
    }
    .text-dark, table td{
        color: #343a40;
    }
    .text-white{
        color: #ffffff;
    }
    table td,
    table th {
        font-size: 11px;
        padding: 3px;
        line-height: 1.2;
        font-family:arial;
    }

    table tr {
        border-bottom: solid 1px #ababab;
    }

    .bg-dark {
        background-color: #343a40;
    }
    .bg-secondary {
        background-color: #6c757d;
    }
    .bg-white {
        background-color: #ffffff;
    }
    .text-left {
        text-align: left;
    }
    .text-right {
        text-align: right;
    }
    .text-center {
        text-align: center;
    }

    table tbody tr.light{
        color:#979797; background-color:#F7F7F7;
    }
    table tbody tr.dark{
        color:#979797; background-color:#E8E8E8;
    }

    tbody tr:nth-child(odd) {
        background: #eee;
    }

    tbody tr:last-child {
        border-bottom: var(--border-strong);
    }

    tbody tr> :last-child {
        border-right: var(--border-strong);
    }

    .top_head>th {
  width: 54mm;
  height: 10mm;
  vertical-align: bottom;
  border-top: var(--border-strong);
  border-bottom: var(--border-strong);
  border-right: 1px solid gray;
}

.top_head :first-child {
  width: 27mm;
  border: var(--border-strong);
}

.top_head :last-child {
  border-right: var(--border-strong);
}


/* left header */

tbody th {
  /*border-left: var(--border-strong);*/
  /*border-right: var(--border-strong);*/
  border-bottom: 1px solid gray;
}

tbody>tr:last-child th {
  border-bottom: var(--border-strong);
}


/* row */

tbody td>div {
  height: 34mm;
  overflow: hidden;
}

.vertical_span_all {
  font-size: 5mm;
  font-weight: bolder;
  text-align: center;
  border-bottom: var(--border-strong);
}

.vertical_span_all div {
  height: 10mm;
}


/* td contents */

.left {
  position: absolute;
  top: 1mm;
  left: 1mm;
}

.right {
  position: absolute;
  left: 1mm;
  bottom: 1mm;
}

.teacher {
  position: absolute;
  right: 1mm;
  bottom: 1mm;
}

.note {
  font-size: 3mm;
}

.note :last-child {
  float: right;
}

@page {
  margin: 5mm;
}

</style>
{{-- <style type="text/css">
    body {
        font-size: 6pt;
    }

    table.morpion {
        border: solid 1px #444444;
    }

    table.morpion td {
        border-left: solid 1px #000000;
        border-bottom: solid 1px #000000;
        text-align: left;
        valign: top;
        font-size: 6pt;
        height: 12px;
        padding: 1px;
    }

    table.morpion th {
        border-left: solid 1px #000000;
        border-bottom: solid 1px #000000;
        text-align: left;
        valign: top;
        font-size: 6pt;
        height: 40px;
    }

    td.verticale {
        writing-mode: tb-rl;
        filter: flipv fliph;
    }

    .alt {
        background-color: #C0F0C0;
    }

    .rot {
        rotate: 90;
        text-align: center;
        height: 100%;
        width: 100%;
        padding: 0px;
    }

    .thead {
        width: 30px;
        text-align: center;
        vertical-align: middle;
    }

</style> --}}
