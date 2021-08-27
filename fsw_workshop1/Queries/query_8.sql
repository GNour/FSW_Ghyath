SELECT st.store_id, YEAR(p.payment_date),MONTH(p.payment_date) ,SUM(p.amount), AVG(p.amount)
FROM staff as s, payment as p, store as st
WHERE s.store_id = st.store_id AND p.staff_id = s.staff_id
GROUP BY st.store_id, YEAR(p.payment_date),MONTH(p.payment_date);
