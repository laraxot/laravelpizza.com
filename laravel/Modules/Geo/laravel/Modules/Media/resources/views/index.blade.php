<?php

declare(strict_types=1);

?>
@extends('media::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('media.name') !!}</p>
@endsection
