<?php

declare(strict_types=1);

?>
@extends('notify::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('notify.name') !!}
    </p>
@endsection
