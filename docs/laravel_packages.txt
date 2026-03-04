-----------------------------------------------
https://gasparesganga.com/labs/php-shapefile/
-----------------------------------------------


fathernelson/laravel-mysql-spatial
-----------------------------------------------

crys/laravel-mysql-spatial
-----------------------------------------------
PHP library for working with geometric objects and geometric functions. Works with a range of formats, including WKT, WKB, and GeoJSON. Used to get centroids, bounding-boxes, area, etc. of a geometric object.
https://geophp.net/
-----------------------------------------------
Get precise geographic coordinates for a geographic feature, such as "Buckingham Palace, London". Supports a wide range of providers.
https://geocoder-php.org/
-----------------------------------------------
Facilitate working with spatial data and spatial relations in Laravel.
https://packagist.org/packages/grimzy/laravel-mysql-spatial
-----------------------------------------------
Provide spatial data support for ActiveRecords in the Yii2 framework.
https://packagist.org/packages/sjaakp/yii2-spatial
-----------------------------------------------
Parse coordinates from their natural-language string representations, such as '79°56′55″W, 40°26′46″N'.
https://packagist.org/packages/creof/geo-parser
-----------------------------------------------
Retrieve country-specific information. Geographic features include states, cities, and borders. Accepts many different formats as input, such as common names, ISO codes, etc.
https://packagist.org/packages/pragmarx/countries
-----------------------------------------------
gasparesganga/php-shapefile
-----------------------------------------------
SELECT zip, primary_city, latitude, longitude,
      111.045* DEGREES(ACOS(LEAST(1.0, COS(RADIANS(latpoint))
                 * COS(RADIANS(latitude))
                 * COS(RADIANS(longpoint) - RADIANS(longitude))
                 + SIN(RADIANS(latpoint))
                 * SIN(RADIANS(latitude))))) AS distance_in_km
 FROM zip
 JOIN (
     SELECT  42.81  AS latpoint,  -70.81 AS longpoint
   ) AS p ON 1=1
 ORDER BY distance_in_km
 LIMIT 15
-----------------------------------------------
 SELECT z.zip,
        z.primary_city,
        z.latitude, z.longitude,
        p.distance_unit
                 * DEGREES(ACOS(LEAST(1.0, COS(RADIANS(p.latpoint))
                 * COS(RADIANS(z.latitude))
                 * COS(RADIANS(p.longpoint) - RADIANS(z.longitude))
                 + SIN(RADIANS(p.latpoint))
                 * SIN(RADIANS(z.latitude))))) AS distance_in_km
  FROM zip AS z
  JOIN (   /* these are the query parameters */
        SELECT  42.81  AS latpoint,  -70.81 AS longpoint,
                50.0 AS radius,      111.045 AS distance_unit
    ) AS p ON 1=1
  WHERE z.latitude
     BETWEEN p.latpoint  - (p.radius / p.distance_unit)
         AND p.latpoint  + (p.radius / p.distance_unit)
    AND z.longitude
     BETWEEN p.longpoint - (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint))))
         AND p.longpoint + (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint))))
  ORDER BY distance_in_km
  LIMIT 15

-----------------------------------------------
https://ourcodeworld.com/articles/read/1019/how-to-find-nearest-locations-from-a-collection-of-coordinates-latitude-and-longitude-with-php-mysql
-----------------------------------------------

-----------------------------------------------
-----------------------------------------------
-----------------------------------------------
-----------------------------------------------
-----------------------------------------------
-----------------------------------------------
-----------------------------------------------
-----------------------------------------------
-----------------------------------------------
-----------------------------------------------
-----------------------------------------------
-----------------------------------------------
-----------------------------------------------
-----------------------------------------------
-----------------------------------------------
