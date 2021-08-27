/*What is the total number of movies per actor?*/
select A.first_name, A.last_name, count(F.film_id)
from film_actor as F, actor as A
WHERE F.actor_id = A.actor_id
group by A.actor_id;




