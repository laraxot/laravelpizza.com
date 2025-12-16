<?php

declare(strict_types=1);

?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#" lang="{{ $lang }}">
@section('htmlheader')
	@include('geo::layouts.partials.htmlheader')
@show
<body>
@yield('body')
@section('scripts')
	@include('geo::layouts.partials.scripts')
@show
</body>
</html>
