SELECT c.first_name, c.last_name, COUNT(r.rental_id)
FROM customer as c, rental as r
WHERE r.customer_id = c.customer_id AND YEAR(r.rental_date) = 2005
GROUP BY c.first_name
ORDER BY COUNT(r.rental_id) DESC
LIMIT 3;
