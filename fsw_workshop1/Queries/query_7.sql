SELECT first_name, last_name
FROM customer
WHERE customer.first_name = (SELECT first_name FROM actor WHERE actor_id = 8);
