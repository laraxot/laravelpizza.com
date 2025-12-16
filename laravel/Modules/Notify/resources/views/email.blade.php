<?php

declare(strict_types=1);

?>
@extends('notify::layouts.' . $theme ?? 'app')
@section('content')
    {!! $body_html !!}
@endsection
