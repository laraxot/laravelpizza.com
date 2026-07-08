<?php

declare(strict_types=1);

?>
@extends('notify::emails.templates.widgets')

@section('content')

    @include('notify::emails.templates.widgets.articleStart')


    {!! $html !!}

    @include('notify::emails.templates.widgets.articleEnd')


    {{-- @include('notify::emails.templates.widgets.newfeatureStart')

    <h4 class="secondary"><strong>Hello World again</strong></h4>
    <p>This is another test</p>

    @include('notify::emails.templates.widgets.newfeatureEnd') --}}

@stop
