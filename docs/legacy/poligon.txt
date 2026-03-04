https://stackoverflow.com/questions/5065039/find-point-in-polygon-php

Array
(
    [0] => stdClass Object
        (
            [lat] => 43.685927
            [lng] => -79.745829
        )

    [1] => stdClass Object
        (
            [lat] => 43.686004
            [lng] => -79.745954
        )

    [2] => stdClass Object
        (
            [lat] => 43.686429
            [lng] => -79.746642
        )


function is_in_polygon2($longitude_x, $latitude_y,$polygon){
  $i = $j = $c = 0;
  $points_polygon = count($polygon)-1;
  for ($i = 0, $j = $points_polygon ; $i < $points_polygon; $j = $i++) {
    if ( (($polygon[$i]->lat  >  $latitude_y != ($polygon[$j]->lat > $latitude_y)) &&
     ($longitude_x < ($polygon[$j]->lng - $polygon[$i]->lng) * ($latitude_y - $polygon[$i]->lat) / ($polygon[$j]->lat - $polygon[$i]->lat) + $polygon[$i]->lng) ) )
       $c = !$c;
  }
  return $c;
}


------------------------------------------------------------------------
Perform geometric operations on polygons
https://www.phpclasses.org/browse/file/10683.html


-------------------------------------------------------------------------
https://stackoverflow.com/questions/38062642/detecting-point-within-polygon-latitude-and-longitude-in-php

function inside($point, $fenceArea) {
$x = $point['lat']; $y = $point['lng'];

$inside = false;
for ($i = 0, $j = count($fenceArea) - 1; $i <  count($fenceArea); $j = $i++) {
    $xi = $fenceArea[$i]['lat']; $yi = $fenceArea[$i]['lng'];
    $xj = $fenceArea[$j]['lat']; $yj = $fenceArea[$j]['lng'];

    $intersect = (($yi > $y) != ($yj > $y))
        && ($x < ($xj - $xi) * ($y - $yi) / ($yj - $yi) + $xi);
    if ($intersect) $inside = !$inside;
}

return $inside;
}

-----------------------------------------------------------------------------------
funzione js di google 
https://developers.google.com/maps/documentation/javascript/examples/poly-containsLocation#try-it-yourself


funzione di algolia
https://www.algolia.com/doc/api-reference/api-parameters/insidePolygon/

------------------------------------------------------------------------------------
 The point-in-polygon algorithm allows you to check if a point is
inside a polygon or outside of it.
https://assemblysys.com/php-point-in-polygon-algorithm/


---------------------------------------------------------------------------------------
Find Point in polygon PHP
https://newbedev.com/find-point-in-polygon-php

----------------------------------------------------------------------------------------
Check if lat/long point is inside polygons
https://docs.microsoft.com/en-us/answers/questions/414790/check-if-latlong-point-is-inside-polygons.html

----------------------------------------------------------------------------------------

The point-in-polygon algorithm allows you to check if a point is inside a polygon or outside of it.
https://gist.github.com/vzool/e5ee5fab6608c7a9e82e2c4b800a86e3

-------------------------------------------------------------------------------------------


Find Restaurants with Geospatial Queries - MONGO 
https://docs.mongodb.com/manual/tutorial/geospatial-tutorial/

----------------------------------------------------------------------------------------------

soldi api maps
https://laraveldaily.com/laravel-find-addresses-with-coordinates-via-google-maps-api/
---------------------------------------------------------------------------------------------



https://css-tricks.com/lets-make-a-form-that-puts-current-location-to-use-in-a-map/


