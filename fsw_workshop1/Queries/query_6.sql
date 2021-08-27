SELECT c.name, COUNT(fc.film_id)
FROM film as f, film_category as fc, category as c
WHERE fc.film_id = f.film_id
AND fc.category_id = c.category_id
GROUP BY c.name
HAVING COUNT(fc.film_id) BETWEEN 55 AND 65
ORDER BY COUNT(f.title);
