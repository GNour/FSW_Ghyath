SELECT a.first_name, a.last_name, f.release_year
FROM actor as a, film_actor as fa, film as f
WHERE a.actor_id = fa.actor_id 
AND fa.film_id = f.film_id 
AND (f.description LIKE "%Shark%" OR f.description LIKE  "%Crocodile%")
GROUP BY a.first_name
ORDER BY a.last_name;

