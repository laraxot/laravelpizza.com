<?php

declare(strict_types=1);

?>
@extends('adm_theme::layouts.app')
@section('content')
    <a class="btn btn-primary">+</a>
    <table class="table table-bordered">
    @foreach ($rows as $row)
        <tr>
            <td>{{ $row-> }}</td>

        </tr>
    @endforeach
    </table>
@endsection
