<?php

declare(strict_types=1);

?>
@extends('adm_theme::layouts.app')
@section('content')
    <livewire:panel.sort-rows-group groupBy="question,subquestion" />
@endsection
