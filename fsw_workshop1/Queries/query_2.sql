SELECT l.name, COUNT(f.language_id)
FROM film as f, language as l
WHERE l.language_id = f.language_id and f.release_year = 2006
Group by f.language_id
ORDER by COUNT(f.language_id) DESC
LIMIT 3;