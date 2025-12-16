<?php

declare(strict_types=1);

?>
@extends('pub_theme::layouts.base')

@section('body')
    @yield('content')

    @isset($slot)
        {{ $slot }}
    @endisset
@endsection
