<?php

declare(strict_types=1);

?>
@extends('tenant::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('tenant.name') !!}
    </p>
@endsection
