<?php

declare(strict_types=1);

?>
@include('notify::emails.templates.'.$theme.'.contentStart')
{!! $html !!}
@include('notify::emails.templates.'.$theme.'.contentEnd')
