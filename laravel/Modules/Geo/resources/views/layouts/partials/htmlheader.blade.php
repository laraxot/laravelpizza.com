<?php

declare(strict_types=1);

?>
<head>
    {!! Theme::metatags() !!}
    {{--
    <link rel="shortcut icon" href="icons/favicon.ico">
    <link rel="apple-touch-icon" sizes="152x152" href="icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="icons/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" sizes="32x32" href="icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="icons/favicon-16x16.png">
    <link rel="manifest" href="icons/site.webmanifest">
    <link rel="mask-icon" href="icons/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta charset="UTF-8">
    <meta name="description" content="farmshops.eu ist eine Übersichtskarte von Hofläden, Märkten, Essensautomaten und anderen Direktvermarktern aus der DACH-Region (Deutschland, Österreich, Schweiz). Die Karte erhält alle ihre Daten von Openstreetmap, bereitet sie optisch auf und unterstützt die Pflege der Daten indem sie fehlende Werte sichtbar macht und direkt auf den entsprechenden Ort auf OSM und in andere Kartendienste verlinkt."
    />
    <meta name="keywords" content="Hofladen, Hofläden, Bauernladen, Direktvermarkter, Verkauf ab Hof, Karte, Map, Farmshops, Bauernladen, Openstreetmap, Biologisch, Lokales Essen, Milchautomat, Eierautomat, Essensautomat, Open Knowledge, Freies Wissen, OKFN, Code for Karlsruhe, Code for Germany, Deutschland, Schweiz, Österreich"
    />
    --}}
    {{--
    <link href="css/leaflet.css" type="text/css" rel=stylesheet>
    <link rel="stylesheet" href="css/leaflet-sidebar.css" />
    <link rel="stylesheet" href="css/MarkerCluster.css" />
    <link rel="stylesheet" href="css/fontawesome-all.min.css" />
    <link rel="stylesheet" href="css/L.Control.Locate.min.css" />
    <link href="css/style.css" type="text/css" rel=stylesheet>
    --}}
    @php
        if(0){
            Theme::add('theme/pub/css/leaflet.css');
            Theme::add('theme/pub/css/leaflet-sidebar.css');
            Theme::add('theme/pub/css/leaflet.extra-markers.min.css');
            Theme::add('theme/pub/css/MarkerCluster.css');
            Theme::add('theme/pub/css/fontawesome-all.min.css');
            Theme::add('theme/pub/css/L.Control.Locate.min.css');
            Theme::add('theme/pub/css/style.css');
        }else{
            Theme::add('geo::css/geo.css');
        }
    @endphp
    {!! Theme::showStyles(false) !!}
    {{--
    <title>farmshops.eu - Finde Hofläden, Märkte, Automaten und andere Direktvermarkter und hole dir lokale Nahrungsmittel, gesunde Produkte und gutes Essen</title>
    <meta property="og:image" content="https://raw.githubusercontent.com/CodeforKarlsruhe/direktvermarkter/master/img/direktvermarkter.png"
    />
    <meta name="twitter:image:src" content="https://raw.githubusercontent.com/CodeforKarlsruhe/direktvermarkter/master/img/direktvermarkter.png"
    />
    <meta name="country" content="Germany">
    <meta name="country" content="Austria">
    <meta name="country" content="Switzerland">
    --}}
</head>
