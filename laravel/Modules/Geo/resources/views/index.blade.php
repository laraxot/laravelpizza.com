<?php

declare(strict_types=1);

?>
@extends('geo::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('geo.name') !!}
    </p>
@stop
