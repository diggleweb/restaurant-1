--Query for finding distance between several customers--
SELECT a.name AS from_name, b.name AS to_name, 
   111.1111 *
    DEGREES(ACOS(COS(RADIANS(a.lat))
         * COS(RADIANS(b.lat))
         * COS(RADIANS(a.long - b.long))
         + SIN(RADIANS(a.lat))
         * SIN(RADIANS(b.lat)))) AS distance_in_km
  FROM customers AS a
  JOIN customers AS b ON a.id <> b.id

--Query for finding distance between stores to customers--

SELECT a.name AS from_name, b.name AS to_name, 
   111.1111 *
    DEGREES(ACOS(COS(RADIANS(a.lat))
         * COS(RADIANS(b.lat))
         * COS(RADIANS(a.long - b.long))
         + SIN(RADIANS(a.lat))
         * SIN(RADIANS(b.lat)))) AS distance_in_km
  FROM customers AS a
  JOIN stores AS b ON a.id <> b.id
