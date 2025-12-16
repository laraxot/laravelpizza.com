<?php

declare(strict_types=1);

?>
<div>

    <ul>
    @foreach ($getState() as $key=>$value)
        @include('job::filament.tables.columns.array.item',['key'=>$key,'value'=>$value])
    @endforeach
    </ul>
</div>
