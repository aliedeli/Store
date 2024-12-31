SELECT 
    a.account_id,
    a.account_name,
    a.balance,
    COUNT(o.order_id) as total_orders,
    SUM(o.order_amount) as total_order_amount
FROM Accounts a
LEFT JOIN Orders o ON a.account_id = o.account_id
GROUP BY a.account_id, a.account_name, a.balance;
