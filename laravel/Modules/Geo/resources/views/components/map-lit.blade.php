@php
$lat = $lat ?? null;
$lng = $lng ?? null;
@endphp
<div x-data="map-litProps" class="map-lit-container">
  <map-lit
    id="ticket-map"
    data-url="/data/tickets.json"
    height="clamp(360px,58vh,560px)"
    style="height:clamp(360px,58vh,560px);display:block;width:100%"
    aria-label="{{ __('fixcity::ticket.map.image.alt') }}"
    @if($lat !== null) lat="{{ $lat }}" @endif
    @if($lng !== null) lng="{{ $lng }}" @endif
  ></map-lit>
</div>