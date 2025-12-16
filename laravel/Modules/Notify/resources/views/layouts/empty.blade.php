<?php

declare(strict_types=1);

?>
<html>

<head>
    <title>{{ isset($senderName) ? $senderName : '' }}.</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>
    @yield('content')
</body>

</html>
