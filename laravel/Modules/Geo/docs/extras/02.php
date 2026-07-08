<?php

declare(strict_types=1);

$line = 'burger.letters.com - - [01/Jul/1995:00:00:12 -0400] "GET /images/NASA-logosmall.gif HTTP/1.0" 304 0';
$pos = strpos(strtolower($line), '.gif');
$s1 = substr($line, 0, $pos + 4);
$pos = strrpos($s1, '/');
echo '<br/>'.$pos;

echo '[<br/>'.substr($s1, $pos + 1);
