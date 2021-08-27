SELECT *
from address 
WHERE address2 is not NULL AND address2 <> ""
order by address2;