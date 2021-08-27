SELECT co.country, COUNT(co.country_id)
FROM country as co, customer as cu, city as ci, address as a
WHERE cu.address_id = a.address_id AND a.city_id = ci.city_id AND ci.country_id = co.country_id
GROUP BY co.country
ORDER BY COUNT(co.country_id) DESC
LIMIT 3;
