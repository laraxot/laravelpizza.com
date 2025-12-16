@foreach($getState() as $variable => $value)
    <p>
        {{$variable}}={{$value}}
        @if(!$loop->last),
        @endif
    </p>
@endforeach
